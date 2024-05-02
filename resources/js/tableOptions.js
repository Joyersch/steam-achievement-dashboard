document.addEventListener("DOMContentLoaded", function () {
    const hide100Btn = document.getElementById('hide100');
    const hide0Btn = document.getElementById('hide0');
    const hideOthersBtn = document.getElementById('hideOthers');
    const rows = document.querySelectorAll('.table tbody tr');

    hide100Btn.addEventListener('click', function () {
        toggleVisibility(this, 100);
    });

    hide0Btn.addEventListener('click', function () {
        toggleVisibility(this, 0);
    });

    hideOthersBtn.addEventListener('click', function () {
        let isHidden = this.textContent.includes("Hide");
        rows.forEach(row => {
            const completion = parseFloat(row.cells[1].innerText.replace('%', ''));
            if (completion !== 0 && completion !== 100) {
                row.style.display = isHidden ? 'none' : '';
            }
        });
        this.textContent = isHidden ? "Show Non-Extreme Completions" : "Hide Non-Extreme Completions";
    });

    function toggleVisibility(button, completionTarget) {
        let isHidden = button.textContent.includes("Hide");
        rows.forEach(row => {
            const completion = parseFloat(row.cells[1].innerText.replace('%', ''));
            if (completion === completionTarget) {
                row.style.display = isHidden ? 'none' : '';
            }
        });
        button.textContent = isHidden ? "Show " + completionTarget + "% Completion" : "Hide " + completionTarget + "% Completion";
    }
});
