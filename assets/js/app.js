/* Tuula Credit theme JS - ported from the approved static prototype.
   WordPress adaptations: apply-page URL and notification email come from
   the localized TUULA object (see functions.php), with safe fallbacks. */
const TUULA_CONFIG = window.TUULA || {};
const APPLY_URL = TUULA_CONFIG.applyUrl || "/apply/";
const TUULA_EMAIL = TUULA_CONFIG.email || "info@tuulacredit.com";

const navToggle = document.querySelector("[data-nav-toggle]");
const nav = document.querySelector("[data-nav]");

if (navToggle && nav) {
  navToggle.addEventListener("click", () => {
    const isOpen = nav.classList.toggle("is-open");
    navToggle.setAttribute("aria-expanded", String(isOpen));
  });

  nav.addEventListener("click", (event) => {
    if (event.target instanceof HTMLAnchorElement) {
      nav.classList.remove("is-open");
      navToggle.setAttribute("aria-expanded", "false");
    }
  });
}

const yearTarget = document.querySelector("[data-current-year]");
if (yearTarget) {
  yearTarget.textContent = String(new Date().getFullYear());
}

const ugxNumber = new Intl.NumberFormat("en-UG", {
  maximumFractionDigits: 0,
});

const formatUgx = {
  format(value) {
    return `UGX ${ugxNumber.format(Number(value) || 0)}`;
  },
};

const calculatorForm = document.querySelector("[data-calculator-form]");
const applicationForm = document.querySelector("[data-application-form]");
const applicationSummary = document.querySelector("[data-application-summary]");
const anchorOffset = 96;

function scrollToElement(element, behavior = "smooth") {
  const top = element.getBoundingClientRect().top + window.scrollY - anchorOffset;
  window.scrollTo({ top: Math.max(top, 0), behavior });
}

function scrollToHashTarget() {
  if (!window.location.hash) return;

  const targetId = decodeURIComponent(window.location.hash.slice(1));
  const target = document.getElementById(targetId);
  if (!target) return;

  window.requestAnimationFrame(() => scrollToElement(target, "auto"));
}

function setCalculatorValue(name, value) {
  if (!calculatorForm || value == null || value === "") return;

  const field = calculatorForm.elements.namedItem(name);
  if (
    field instanceof HTMLInputElement ||
    field instanceof HTMLSelectElement ||
    field instanceof HTMLTextAreaElement
  ) {
    field.value = value;
  }
}

function setCalculatorValues(values) {
  if (!calculatorForm) return false;

  setCalculatorValue("loanType", values.loanType);
  setCalculatorValue("amount", values.amount);
  setCalculatorValue("term", values.term);
  setCalculatorValue("rate", values.rate);
  updateCalculatorSummary();
  return true;
}

function prefillCalculatorFromUrl() {
  if (!calculatorForm) return;

  const params = new URLSearchParams(window.location.search);
  setCalculatorValues({
    loanType: params.get("loanType"),
    amount: params.get("amount"),
    term: params.get("term"),
    rate: params.get("rate"),
  });
}

function buildApplyUrlFromPreset(button) {
  const params = new URLSearchParams();

  if (button.dataset.loanPreset) params.set("loanType", button.dataset.loanPreset);
  if (button.dataset.amount) params.set("amount", button.dataset.amount);
  if (button.dataset.term) params.set("term", button.dataset.term);
  if (button.dataset.rate) params.set("rate", button.dataset.rate);

  const query = params.toString();
  return `${APPLY_URL}${query ? `?${query}` : ""}#calculator`;
}

function getCalculatorValues() {
  if (!calculatorForm) return null;

  const formData = new FormData(calculatorForm);
  const loanType = String(formData.get("loanType") || "");
  const principal = Number(formData.get("amount"));
  const term = Number(formData.get("term"));
  const annualRate = Number(formData.get("rate"));

  if (!principal || !term || annualRate < 0) return null;

  const monthlyRate = annualRate / 100 / 12;
  const monthlyPayment = monthlyRate === 0
    ? principal / term
    : principal * (monthlyRate * (1 + monthlyRate) ** term) / ((1 + monthlyRate) ** term - 1);
  const totalRepayment = monthlyPayment * term;
  const totalInterest = Math.max(totalRepayment - principal, 0);

  return {
    annualRate,
    loanType,
    principal,
    term,
    monthlyPayment,
    totalInterest,
    totalRepayment,
  };
}

function updateCalculatorSummary() {
  if (!calculatorForm) return null;

  const values = getCalculatorValues();
  if (!values) return null;

  const monthly = formatUgx.format(values.monthlyPayment);
  const interest = formatUgx.format(values.totalInterest);
  const total = formatUgx.format(values.totalRepayment);

  const monthlyTarget = calculatorForm.querySelector("[data-monthly]");
  const interestTarget = calculatorForm.querySelector("[data-interest]");
  const totalTarget = calculatorForm.querySelector("[data-total]");

  if (monthlyTarget) monthlyTarget.textContent = monthly;
  if (interestTarget) interestTarget.textContent = interest;
  if (totalTarget) totalTarget.textContent = total;

  return { ...values, monthly, interest, total };
}

function syncApplicationEstimate() {
  if (!applicationForm) return null;

  const values = updateCalculatorSummary();
  if (!values) return null;

  const fieldMap = {
    "[data-loan-type-field]": values.loanType,
    "[data-amount-field]": formatUgx.format(values.principal),
    "[data-term-field]": `${values.term} months`,
    "[data-rate-field]": `${values.annualRate}%`,
    "[data-monthly-field]": values.monthly,
    "[data-interest-field]": values.interest,
    "[data-total-field]": values.total,
  };

  Object.entries(fieldMap).forEach(([selector, value]) => {
    const field = applicationForm.querySelector(selector);
    if (field) field.value = value;
  });

  if (applicationSummary) {
    applicationSummary.textContent = `${values.loanType}: ${formatUgx.format(values.principal)} over ${values.term} months. Estimated monthly payment ${values.monthly}; total repayment ${values.total}.`;
  }

  return values;
}

if (calculatorForm) {
  prefillCalculatorFromUrl();
  calculatorForm.addEventListener("input", updateCalculatorSummary);
  calculatorForm.addEventListener("change", updateCalculatorSummary);
  updateCalculatorSummary();

  const goToApplication = () => {
    if (!calculatorForm.reportValidity()) return;
    syncApplicationEstimate();
    const applicationSection = document.querySelector("#application");
    if (applicationSection) scrollToElement(applicationSection);
  };

  calculatorForm.addEventListener("submit", (event) => {
    event.preventDefault();
    goToApplication();
  });

  calculatorForm.querySelector("[data-apply-estimate]")?.addEventListener("click", goToApplication);
}

document.querySelectorAll("[data-loan-preset]").forEach((button) => {
  button.addEventListener("click", () => {
    if (!calculatorForm) {
      window.location.href = buildApplyUrlFromPreset(button);
      return;
    }

    setCalculatorValues({
      loanType: button.dataset.loanPreset,
      amount: button.dataset.amount,
      term: button.dataset.term,
      rate: button.dataset.rate,
    });
    syncApplicationEstimate();
    scrollToElement(calculatorForm);
  });
});

function buildEmailBody(formData) {
  return [
    "New Tuula Credit loan request",
    "",
    `Loan type: ${formData.get("loanType") || ""}`,
    `Loan amount: ${formData.get("amount") || ""}`,
    `Term: ${formData.get("term") || ""}`,
    `Annual interest estimate: ${formData.get("rate") || ""}`,
    `Estimated monthly payment: ${formData.get("monthlyPayment") || ""}`,
    `Estimated total interest: ${formData.get("totalInterest") || ""}`,
    `Estimated total repayment: ${formData.get("totalRepayment") || ""}`,
    "",
    `Applicant type: ${formData.get("applicantType") || ""}`,
    `Full name: ${formData.get("fullName") || ""}`,
    `Phone: ${formData.get("phone") || ""}`,
    `Email: ${formData.get("email") || ""}`,
    `Location: ${formData.get("location") || ""}`,
    `Preferred contact time: ${formData.get("contactTime") || ""}`,
    "",
    "Loan purpose:",
    formData.get("purpose") || "",
  ].join("\n");
}

if (applicationForm) {
  applicationForm.addEventListener("submit", (event) => {
    event.preventDefault();
    syncApplicationEstimate();

    if (!applicationForm.reportValidity()) return;

    const formData = new FormData(applicationForm);
    const subject = `Tuula Credit loan request - ${formData.get("loanType") || "New request"}`;
    const body = buildEmailBody(formData);
    const mailtoUrl = `mailto:${TUULA_EMAIL}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    const status = applicationForm.querySelector("[data-form-status]");

    if (status) {
      status.textContent = "Opening an email draft with the calculator and applicant details for the Tuula team.";
    }

    window.location.href = mailtoUrl;
  });
}

const processTabs = document.querySelector("[data-process-tabs]");

if (processTabs) {
  const activateProcessTab = (button) => {
    const tab = button.dataset.processTab;
    if (!tab) return;

    processTabs.querySelectorAll("[data-process-tab]").forEach((button) => {
      const isActive = button.dataset.processTab === tab;
      button.classList.toggle("is-active", isActive);
      button.setAttribute("aria-selected", String(isActive));
    });

    processTabs.querySelectorAll("[data-process-panel]").forEach((panel) => {
      const isActive = panel.dataset.processPanel === tab;
      panel.classList.toggle("is-active", isActive);
      panel.hidden = !isActive;
    });
  };

  processTabs.querySelectorAll("[data-process-tab]").forEach((button) => {
    button.addEventListener("click", () => activateProcessTab(button));
  });
}

const accordion = document.querySelector("[data-accordion]");

if (accordion) {
  accordion.addEventListener("click", (event) => {
    if (!(event.target instanceof HTMLButtonElement)) return;

    const button = event.target;
    const panel = button.nextElementSibling;
    const isOpen = button.getAttribute("aria-expanded") === "true";

    accordion.querySelectorAll("button").forEach((item) => {
      item.setAttribute("aria-expanded", "false");
    });

    accordion.querySelectorAll("div").forEach((item) => {
      item.hidden = true;
    });

    if (panel instanceof HTMLDivElement && !isOpen) {
      button.setAttribute("aria-expanded", "true");
      panel.hidden = false;
    }
  });
}

scrollToHashTarget();
