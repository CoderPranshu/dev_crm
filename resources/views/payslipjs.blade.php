<script>
document.addEventListener("DOMContentLoaded", function () {

    // Helper: find element by id first, then by name. If found by name and has no id, set id for future use.
    function el(nameOrId) {
        let e = document.getElementById(nameOrId);
        if (e) return e;
        // try by name
        e = document.querySelector('[name="' + nameOrId + '"]');
        if (e) {
            // ensure it has an id for later direct access
            if (!e.id) e.id = nameOrId;
            return e;
        }
        return null;
    }

    // Safe numeric read
    function num(nameOrId) {
        const element = el(nameOrId);
        if (!element) return 0;
        const v = parseFloat(element.value);
        return isNaN(v) ? 0 : v;
    }

    // Safe write
    function setVal(nameOrId, value) {
        const element = el(nameOrId);
        if (!element) return;
        element.value = value;
    }

    // flash highlight
    function flash(nameOrId) {
        const element = el(nameOrId);
        if (!element) return;
        element.classList.add("flash");
        setTimeout(() => element.classList.remove("flash"), 500);
    }

    /* ---------- Core calculations ---------- */

    // 1. Gross = basic(net_salary) + hra + conveyance + other_allowance
    function calculateGross() {
        const gross =
            num("net_salary") +
            num("hra") +
            num("conveyance_allowance") +
            num("other_allowance");

        setVal("gross_salary", gross.toFixed(2));
        flash("gross_salary");

        // After gross changes, recalc derived values
        calculateTotalDeductions(); // keeps total_deduc and total_net consistent
        calculateTotalNet();
        calculateFinalPayable();
    }

    // 2. Total Deductions = pf + esi + tax + tds + other_deduc
    function calculateTotalDeductions() {
        const total =
            num("pf") +
            num("esi") +
            num("tax") +
            num("tds") +
            num("other_deduc");

        setVal("total_deduc", total.toFixed(2));
        flash("total_deduc");

        calculateTotalNet();
        calculateFinalPayable();
    }

    // 3. Total Net = Gross - Total Deductions
    function calculateTotalNet() {
        const gross = num("gross_salary");
        const totalDeduc = num("total_deduc");
        const totalNet = gross - totalDeduc;
        setVal("total_net", totalNet.toFixed(2));
        flash("total_net");
    }

    // 4. Absent calculation: working_days - present_days
    function calculateAbsent() {
        const workingDays = num("working_days");
        const presentDays = num("present_days");

        let absent = workingDays - presentDays;
        if (absent < 0) absent = 0;

        setVal("leave_withoutpay", absent);
        flash("leave_withoutpay");

        // Absent affects final payable (LWP)
        calculateFinalPayable();
    }

    // 5. Final payable calculation
    function calculateFinalPayable() {
        // values
        const totalNet = num("total_net");      // gross - deductions
        const bonus = num("bonus");
        const penalty = num("penalty");
        const overtimeHrs = num("over_time");

        const grossSalary = num("gross_salary");
        const netSalary = num("net_salary");    // basic
        const workingDays = num("working_days");
        const absent = num("leave_withoutpay");

        // Overtime pay: hourlyRate based on BASIC (net_salary) per working hour
        let overtimePay = 0;
        if (netSalary > 0 && workingDays > 0) {
            const hourlyRate = netSalary / (workingDays * 8); // 8 hrs/day
            overtimePay = overtimeHrs * hourlyRate;
        }

        // LWP deduction: usually applied on basic salary per day
        // Use basic (net_salary) per day OR gross depending on your policy.
        // I'll use BASIC (net_salary) per day as it's common practice.
        let lwpDeduction = 0;
        if (workingDays > 0) {
            const perDayOnBasic = netSalary / workingDays;
            lwpDeduction = absent * perDayOnBasic;
        }

        // Final
        const finalPayable = totalNet + bonus + overtimePay - lwpDeduction - penalty;

        // Avoid negative - optional (if you want allow negative, remove Math.max)
        const finalSafe = parseFloat(finalPayable.toFixed(2));
        setVal("final_payable", finalSafe);
        flash("final_payable");
    }

    /* ---------- Wiring events ---------- */

    // Input groups:
    const grossInputs = ["net_salary", "hra", "conveyance_allowance", "other_allowance"];
    const deductionInputs = ["pf", "esi", "tax", "tds", "other_deduc"];
    const presentWorkingInputs = ["present_days", "working_days"];
    const finalInputs = ["bonus", "penalty", "over_time"];

    // attach listeners safely (only if element exists)
    grossInputs.forEach(id => {
        const e = el(id);
        if (e) e.addEventListener("input", calculateGross);
    });

    deductionInputs.forEach(id => {
        const e = el(id);
        if (e) e.addEventListener("input", calculateTotalDeductions);
    });

    presentWorkingInputs.forEach(id => {
        const e = el(id);
        if (e) e.addEventListener("input", function () {
            calculateAbsent();
            // ensure totals are fresh if present changes (present won't change gross/deductions,
            // but absent affects final pay)
            calculateFinalPayable();
        });
    });

    finalInputs.forEach(id => {
        const e = el(id);
        if (e) e.addEventListener("input", calculateFinalPayable);
    });

    // Also ensure when total_net or total_deduc are manually changed (if ever), trigger flows
    ["total_deduc", "total_net", "gross_salary", "final_payable"].forEach(id => {
        const e = el(id);
        // readonly fields likely exist; if user or script updates them, we keep consistency
        if (e) e.addEventListener("input", function () {
            calculateTotalNet();
            calculateFinalPayable();
        });
    });

    // Initial run to populate computed fields
    calculateGross();
    calculateTotalDeductions();
    calculateTotalNet();
    calculateAbsent();
    calculateFinalPayable();

});
</script>

<style>
.flash {
    background: #fff7a8 !important;
    transition: background 0.5s ease;
}
</style>
