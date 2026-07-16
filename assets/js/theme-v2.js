/* Tuula Credit v2 design: dark/light toggle, loan-solutions tabs and
   calculator display formatting. The theme choice is persisted in
   localStorage['tuula-theme'] and applied before first paint by the
   inline script in header.php (anti-flash). */
(function () {
  "use strict";

  var root = document.documentElement;

  /* ── Dark / light toggle ─────────────────────────────────────── */
  function applyTheme(theme) {
    root.setAttribute("data-theme", theme);
    try {
      localStorage.setItem("tuula-theme", theme);
    } catch (e) {
      /* Storage unavailable (private mode); theme still applies for this view. */
    }
  }

  document.querySelectorAll("[data-theme-toggle]").forEach(function (button) {
    button.addEventListener("click", function () {
      var next = root.getAttribute("data-theme") === "dark" ? "light" : "dark";
      applyTheme(next);
    });
  });

  /* ── Loan solutions tab picker (Home) ────────────────────────── */
  var loanTabs = Array.prototype.slice.call(document.querySelectorAll("[data-loan-tab]"));
  var loanPanels = Array.prototype.slice.call(document.querySelectorAll("[data-loan-panel]"));

  loanTabs.forEach(function (tab) {
    tab.addEventListener("click", function () {
      var id = tab.getAttribute("data-loan-tab");

      loanTabs.forEach(function (other) {
        var active = other === tab;
        other.classList.toggle("is-active", active);
        other.setAttribute("aria-selected", active ? "true" : "false");
      });

      loanPanels.forEach(function (panel) {
        var active = panel.getAttribute("data-loan-panel") === id;
        panel.classList.toggle("is-active", active);
        panel.hidden = !active;
      });
    });
  });

  /* ── FAQ accordion (Home) ────────────────────────────────────── *
   * One item open at a time. Scoped to the v2 markup
   * (.tv2-faq__item wrappers), unlike the flat legacy accordion
   * that app.js drives on the FAQs page via [data-accordion].     */
  document.querySelectorAll("[data-tv2-faq]").forEach(function (faq) {
    var items = Array.prototype.slice.call(faq.querySelectorAll(".tv2-faq__item"));

    items.forEach(function (item) {
      var button = item.querySelector("button");
      var panel = item.querySelector("div");
      if (!button || !panel) return;

      button.addEventListener("click", function () {
        var isOpen = button.getAttribute("aria-expanded") === "true";

        items.forEach(function (other) {
          var otherButton = other.querySelector("button");
          var otherPanel = other.querySelector("div");
          if (otherButton) otherButton.setAttribute("aria-expanded", "false");
          if (otherPanel) otherPanel.hidden = true;
        });

        if (!isOpen) {
          button.setAttribute("aria-expanded", "true");
          panel.hidden = false;
        }
      });
    });
  });

  /* ── Calculator slider displays (Home) ───────────────────────── *
   * The repayment math itself (amortized monthly payment) lives in
   * app.js and is shared with the Apply page via [data-calculator-form];
   * this block only formats the slider labels and keeps the Apply CTA
   * pointing at the currently selected numbers.                      */
  var calc = document.querySelector("[data-tv2-calc]");

  if (calc) {
    var ugxFormat = new Intl.NumberFormat("en-UG", { maximumFractionDigits: 0 });

    var refreshDisplays = function () {
      var amount = Number(calc.elements.namedItem("amount") && calc.elements.namedItem("amount").value) || 0;
      var term = Number(calc.elements.namedItem("term") && calc.elements.namedItem("term").value) || 0;
      var rate = Number(calc.elements.namedItem("rate") && calc.elements.namedItem("rate").value) || 0;

      var amountOut = calc.querySelector("[data-amount-display]");
      var termOut = calc.querySelector("[data-term-display]");
      var rateOut = calc.querySelector("[data-rate-display]");
      var principalOut = calc.querySelector("[data-principal-display]");

      if (amountOut) amountOut.textContent = "UGX " + ugxFormat.format(amount);
      if (principalOut) principalOut.textContent = "UGX " + ugxFormat.format(amount);
      if (termOut) termOut.textContent = term + (term === 1 ? " month" : " months");
      if (rateOut) rateOut.textContent = rate + "% p.a.";

      var applyLink = calc.querySelector("[data-calc-apply]");
      if (applyLink) {
        var base = (window.TUULA && window.TUULA.applyUrl) || "/apply/";
        var params = new URLSearchParams({
          amount: String(amount),
          term: String(term),
          rate: String(rate),
        });
        applyLink.href = base + "?" + params.toString() + "#calculator";
      }
    };

    calc.addEventListener("input", refreshDisplays);
    calc.addEventListener("change", refreshDisplays);
    refreshDisplays();
  }

  /* ── Apply wizard (Apply page) ───────────────────────────────── *
   * Four steps: product → personal info → loan details → verify.
   * The repayment math itself still runs in app.js via the shared
   * [data-calculator-form] hook on the same <form>; this block only
   * manages step state, validation gating and the final submission
   * (an email draft to the Tuula team — the same lead-capture
   * mechanism the previous Apply form used; there is no WordPress
   * loan-application backend).                                      */
  var wizard = document.querySelector("[data-tv2-wizard]");

  if (wizard) {
    var TOTAL_STEPS = 4;
    var currentStep = 1;

    var stepPanels = Array.prototype.slice.call(wizard.querySelectorAll("[data-wizard-step]"));
    var stepperItems = Array.prototype.slice.call(document.querySelectorAll("[data-wizard-item]"));
    var stepperFill = document.querySelector("[data-wizard-fill]");
    var backButton = wizard.querySelector("[data-wizard-back]");
    var nextButton = wizard.querySelector("[data-wizard-next]");
    var statusNote = wizard.querySelector("[data-wizard-status]");
    var productInput = wizard.querySelector("[data-wizard-product-input]");
    var consentBox = wizard.querySelector("[data-wizard-consent]");
    var productCards = Array.prototype.slice.call(wizard.querySelectorAll("[data-wizard-product]"));
    var successBlock = document.querySelector("[data-wizard-success]");
    var stepper = document.querySelector("[data-wizard-stepper]");

    var wizardEmail = (window.TUULA && window.TUULA.email) || "info@tuulacredit.com";

    var fieldValue = function (name) {
      var field = wizard.elements.namedItem(name);
      return field && field.value ? String(field.value).trim() : "";
    };

    var summaryText = function (selector) {
      var el = wizard.querySelector(selector);
      return el ? el.textContent.trim() : "";
    };

    var markSelectedCard = function () {
      productCards.forEach(function (card) {
        card.classList.toggle(
          "is-selected",
          !!productInput.value && card.getAttribute("data-wizard-product") === productInput.value
        );
      });
    };

    var nextIsDisabled = function () {
      if (currentStep === 1) return !productInput.value;
      if (currentStep === TOTAL_STEPS) return !(consentBox && consentBox.checked);
      return false;
    };

    var fillReview = function () {
      var setText = function (selector, value) {
        var el = wizard.querySelector(selector);
        if (el) el.textContent = value || "—";
      };
      var contact = fieldValue("phone");
      var email = fieldValue("email");
      if (email) contact = contact ? contact + " · " + email : email;

      setText("[data-review-product]", productInput.value);
      setText("[data-review-name]", fieldValue("fullName"));
      setText("[data-review-contact]", contact);
      setText(
        "[data-review-amount]",
        summaryText("[data-amount-display]") + " · " + summaryText("[data-term-display]")
      );
      setText("[data-review-monthly]", summaryText("[data-monthly]"));
    };

    var renderWizard = function () {
      stepPanels.forEach(function (panel) {
        panel.hidden = Number(panel.getAttribute("data-wizard-step")) !== currentStep;
      });

      stepperItems.forEach(function (item, i) {
        item.classList.toggle("is-done", i + 1 < currentStep);
        item.classList.toggle("is-active", i + 1 === currentStep);
      });

      if (stepperFill) {
        stepperFill.style.width = ((currentStep - 1) / (TOTAL_STEPS - 1)) * 76 + "%";
      }

      if (backButton) backButton.hidden = currentStep === 1;

      if (nextButton) {
        nextButton.textContent = currentStep === TOTAL_STEPS ? "Submit request" : "Continue →";
        nextButton.disabled = nextIsDisabled();
      }

      if (statusNote) statusNote.hidden = currentStep !== TOTAL_STEPS;

      if (currentStep === TOTAL_STEPS) fillReview();
    };

    var validateStep = function (step) {
      if (step === 1) return !!productInput.value;

      var panel = stepPanels.filter(function (p) {
        return Number(p.getAttribute("data-wizard-step")) === step;
      })[0];
      if (!panel) return true;

      var fields = Array.prototype.slice.call(panel.querySelectorAll("input, select, textarea"));
      for (var i = 0; i < fields.length; i++) {
        if (!fields[i].checkValidity()) {
          fields[i].reportValidity();
          return false;
        }
      }
      return true;
    };

    var scrollToWizardTop = function () {
      var target = stepper || wizard;
      var top = target.getBoundingClientRect().top + window.scrollY - 96;
      window.scrollTo({ top: Math.max(top, 0), behavior: "smooth" });
    };

    var submitWizard = function () {
      var lines = [
        "New Tuula Credit loan request (website Apply wizard)",
        "",
        "Loan product: " + productInput.value,
        "Amount: " + summaryText("[data-amount-display]"),
        "Term: " + summaryText("[data-term-display]"),
        "Annual interest estimate: " + summaryText("[data-rate-display]"),
        "Estimated monthly payment: " + summaryText("[data-monthly]"),
        "Estimated total interest: " + summaryText("[data-interest]"),
        "Estimated total repayment: " + summaryText("[data-total]"),
        "",
        "Full name: " + fieldValue("fullName"),
        "Phone: " + fieldValue("phone"),
        "Email: " + fieldValue("email"),
        "National ID number: " + fieldValue("nin"),
        "Employment / business status: " + fieldValue("employment"),
        "",
        "Loan purpose:",
        fieldValue("purpose"),
      ];
      var subject = "Tuula Credit loan request - " + (productInput.value || "New request");
      var mailtoUrl =
        "mailto:" + wizardEmail +
        "?subject=" + encodeURIComponent(subject) +
        "&body=" + encodeURIComponent(lines.join("\n"));

      if (successBlock) {
        var copy = successBlock.querySelector("[data-wizard-success-copy]");
        var phone = fieldValue("phone");
        if (copy && phone) {
          copy.textContent =
            "We have opened an email draft with your details — press send in your email app " +
            "and the Tuula Credit team will call " + phone + " to continue your application.";
        }
        wizard.hidden = true;
        if (stepper) stepper.hidden = true;
        successBlock.hidden = false;
        successBlock.scrollIntoView({ behavior: "smooth", block: "center" });
      }

      window.location.href = mailtoUrl;
    };

    productCards.forEach(function (card) {
      card.addEventListener("click", function () {
        productInput.value = card.getAttribute("data-wizard-product") || "";
        markSelectedCard();

        /* Apply the product's example amount/term/rate to the shared
           calculator (same presets the Home page panels link with). */
        ["amount", "term", "rate"].forEach(function (name) {
          var preset = card.getAttribute("data-" + name);
          var field = wizard.elements.namedItem(name);
          if (preset && field) field.value = preset;
        });
        wizard.dispatchEvent(new Event("input", { bubbles: true }));

        /* Selecting a product advances to step 2 (as in the design). */
        currentStep = 2;
        renderWizard();
        scrollToWizardTop();
      });
    });

    if (nextButton) {
      nextButton.addEventListener("click", function () {
        if (!validateStep(currentStep)) return;
        if (currentStep === TOTAL_STEPS) {
          if (consentBox && !consentBox.checked) return;
          submitWizard();
          return;
        }
        currentStep += 1;
        renderWizard();
        scrollToWizardTop();
      });
    }

    if (backButton) {
      backButton.addEventListener("click", function () {
        currentStep = Math.max(1, currentStep - 1);
        renderWizard();
        scrollToWizardTop();
      });
    }

    if (consentBox) {
      consentBox.addEventListener("change", function () {
        if (nextButton) nextButton.disabled = nextIsDisabled();
      });
    }

    /* If a preset link landed here with ?loanType=… (app.js already
       prefilled the hidden input), reflect the selection on the cards. */
    markSelectedCard();
    renderWizard();
  }

  /* ── Contact message form (Contact page) ─────────────────────── *
   * Submits directly to the server, which emails the real Tuula
   * address via wp_mail() (see tuula_handle_contact_submit() in
   * functions.php). Falls back to a mailto draft only if the request
   * itself fails to reach the server (offline, blocked, etc.).       */
  var contactForm = document.querySelector("[data-tv2-contact-form]");

  if (contactForm) {
    contactForm.addEventListener("submit", function (event) {
      event.preventDefault();
      if (!contactForm.reportValidity()) return;

      var contactEmail = (window.TUULA && window.TUULA.email) || "info@tuulacredit.com";
      var status = contactForm.querySelector("[data-contact-status]");
      var submitBtn = contactForm.querySelector('button[type="submit"]');
      var data = new FormData(contactForm);
      var name = String(data.get("fullName") || "").trim();

      function mailtoFallback() {
        var body = [
          "New website message for Tuula Credit",
          "",
          "Name: " + name,
          "Phone: " + (data.get("phone") || ""),
          "Email: " + (data.get("email") || ""),
          "",
          "Message:",
          data.get("message") || "",
        ].join("\n");
        var subject = "Website message" + (name ? " from " + name : "");
        if (status) {
          status.textContent = "Opening an email draft to " + contactEmail + " in your email app…";
        }
        window.location.href =
          "mailto:" + contactEmail +
          "?subject=" + encodeURIComponent(subject) +
          "&body=" + encodeURIComponent(body);
      }

      if (!window.TUULA || !window.TUULA.ajaxUrl || !window.TUULA.contactNonce || !window.fetch) {
        mailtoFallback();
        return;
      }

      data.append("action", "tuula_contact_submit");
      data.append("nonce", window.TUULA.contactNonce);

      if (submitBtn) submitBtn.disabled = true;
      if (status) status.textContent = "Sending your message…";

      fetch(window.TUULA.ajaxUrl, {
        method: "POST",
        credentials: "same-origin",
        body: data,
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (json) {
          if (json && json.success) {
            if (status) {
              status.textContent = (json.data && json.data.message) || "Thanks — your message has been sent.";
            }
            contactForm.reset();
          } else {
            if (status) {
              status.textContent = (json && json.data && json.data.message) || "Sorry, something went wrong. Please try again.";
            }
          }
        })
        .catch(function () {
          mailtoFallback();
        })
        .finally(function () {
          if (submitBtn) submitBtn.disabled = false;
        });
    });
  }
})();
