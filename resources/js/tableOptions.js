document.addEventListener("DOMContentLoaded", function () {
    const hide100Btn = document.getElementById('hide100');
    const hide0Btn = document.getElementById('hide0');
    const hideOthersBtn = document.getElementById('hideOthers');
    const rows = document.querySelectorAll('.table tbody tr');
    const table = document.getElementById('games_table');
    const header = document.getElementById('completion_header');

    hide100Btn.addEventListener('click', function () {
        toggleVisibility(this, 100);
    });

    hide0Btn.addEventListener('click', function () {
        toggleVisibility(this, 0);
    });

    function registerHeader() {
        header.addEventListener('click', function () {
            sort();
        });
    }

    registerHeader();


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

    function save(table) {
        if (!table)
            return;

        const columns = [];
        const tableColumns = table.querySelectorAll('tr');
        tableColumns.forEach(column => {
            const name = column.children[0].innerText;
            const value = column.children[1].innerText.replace('%', '');
            columns.push({
                'name': name,
                'value': value,
            });
        });
        const tableData = {columns};
        return JSON.stringify(tableData);
    }

    function apply(table, tableData) {
        if (!table || !tableData)
            return;

        const parsedData = JSON.parse(tableData);

        const rows = table.querySelectorAll('tr');

        rows.forEach((row, index) => {
            row.children[0].innerText = parsedData.columns[index].name;
            row.children[1].innerText = parsedData.columns[index].value + '%';
        });
    }

    const tableData = save(table);

    let sortState = 0;

    function sort() {
        sortState = (sortState + 1) % 3;

        const tableDataCopy = JSON.parse(tableData);

        console.log(tableDataCopy);
        switch (sortState) {
            case 1:
                tableDataCopy.columns = tableDataCopy.columns.sort((a, b) => +a.value - +b.value);
                break;
            case 2:
                tableDataCopy.columns = tableDataCopy.columns.sort((a, b) => +b.value - +a.value);
                break;
            default:
                break;
        }

        apply(table, JSON.stringify(tableDataCopy));

        switch (sortState) {
            case 1:
                header.textContent = "Completion Rate (%) ▲";
                break;
            case 2:
                header.textContent = "Completion Rate (%) ▼";
                break;
            default:
                header.textContent = "Completion Rate (%)";
                break;
        }
    }


});
