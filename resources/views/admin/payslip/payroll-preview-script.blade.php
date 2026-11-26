<script>
(function () {
    function initializePayslipPreview() {
        const form = document.getElementById('payslip-payroll-form');
        if (!form) return;
        const breakdown = form.querySelector('#payroll-breakdown');
        const field = (id) => form.querySelector('#' + id)
            || form.querySelector('[name="' + id + '"]');
        const number = (id) => Math.max(0, parseFloat(field(id)?.value) || 0);
        const money = (value) => Math.round((value + Number.EPSILON) * 100) / 100;

        const periodInput = form.querySelector('.date-range-picker');
        const dates = (attribute) => JSON.parse(breakdown?.getAttribute(attribute) || '[]');
        const monthlyCounts = JSON.parse(breakdown?.getAttribute('data-monthly-counts') || '{}');
        const rateForDate = (date, monthlyGross) => {
            const count = Number(monthlyCounts[date.slice(0, 7)] || 0);
            return count > 0 ? monthlyGross / count : 0;
        };

        function calculate() {
            const monthlyGross = number('net_salary') + number('hra')
                + number('conveyance_allowance') + number('other_allowance');
            const gross = money(dates('data-working-dates').reduce((total, date) =>
                total + rateForDate(date, monthlyGross), 0));
            const unpaidDates = dates('data-unpaid-dates');
            const halfDates = dates('data-half-dates');
            if (field('leave_withoutpay')) field('leave_withoutpay').value = unpaidDates.length;
            const absence = money(unpaidDates.reduce((total, date) =>
                total + rateForDate(date, monthlyGross), 0));
            const half = money(halfDates.reduce((total, date) =>
                total + rateForDate(date, monthlyGross) * 0.5, 0));
            const late = parseInt(breakdown?.dataset.lateBalance || '0', 10) || 0;
            const other = money(number('pf') + number('esi') + number('tax')
                + number('tds') + number('other_deduc'));
            const total = money(other + absence + half + late);
            const net = money(gross - total);
            const finalPayable = money(net + number('bonus') - number('penalty'));

            if (field('gross_salary')) field('gross_salary').value = gross.toFixed(2);
            if (field('total_deduc')) field('total_deduc').value = total.toFixed(2);
            if (field('total_net')) field('total_net').value = net.toFixed(2);
            if (field('final_payable')) field('final_payable').value = finalPayable.toFixed(2);
            if (breakdown) {
                const set = (key, value) => {
                    const target = breakdown.querySelector('[data-value="' + key + '"]');
                    if (target) target.textContent = '₹' + value.toFixed(2);
                };
                set('absence', absence);
                set('half', half);
                set('late', late);
                set('final', finalPayable);
            }
        }

        // Reload the server-side attendance breakdown when the selected dates change.
        // This keeps holiday, approved leave and punch counts in the same date range.
        function loadPeriod() {
            const match = periodInput?.value.match(/^\s*(\d{2})\/(\d{2})\/(\d{2,4})\s+-\s+(\d{2})\/(\d{2})\/(\d{2,4})\s*$/);
            if (!match || periodInput.value === periodInput.dataset.loadedRange) return;
            const year = (value) => value.length === 2 ? '20' + value : value;
            const start = `${year(match[3])}-${match[1]}-${match[2]}`;
            const end = `${year(match[6])}-${match[4]}-${match[5]}`;
            const url = new URL(window.location.href);
            url.searchParams.set('period_start', start);
            url.searchParams.set('period_end', end);
            url.searchParams.set('year', year(match[3]));
            url.searchParams.set('month', Number(match[1]));
            window.location.assign(url.toString());
        }
        if (periodInput) {
            periodInput.addEventListener('change', loadPeriod);
            if (window.jQuery) window.jQuery(periodInput).on('apply.daterangepicker', () => setTimeout(loadPeriod, 0));
        }
        form.addEventListener('input', () => queueMicrotask(calculate));
        form.addEventListener('change', () => queueMicrotask(calculate));
        form.addEventListener('submit', (event) => {
            if (periodInput?.value !== periodInput?.dataset.loadedRange) {
                event.preventDefault();
                loadPeriod();
                return;
            }
            calculate();
        });
        calculate();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializePayslipPreview);
    } else {
        initializePayslipPreview();
    }
})();
</script>






