document.addEventListener("DOMContentLoaded", function () {
    const hide100Btn = document.getElementById('hide100');
    const hide0Btn = document.getElementById('hide0');
    const hideOthersBtn = document.getElementById('hideOthers');
    const rows = document.querySelectorAll('.table tbody tr');
    const table = document.getElementById('games_table');
    const header = document.getElementById('completion_header');

    let hide100 = false;
    let hide0 = false;
    let hideOther = false;
    hide100Btn.addEventListener('click', function () {
        hide100 = toggleVisibility(this, 100);
    });

    hide0Btn.addEventListener('click', function () {
        hide0 = toggleVisibility(this, 0);
    });

    hideOthersBtn.addEventListener('click', function () {
        let isHidden = this.textContent.includes("Hide");
        rows.forEach(row => {
            const completion = parseFloat(row.cells[1].innerText.replace('%', ''));
            if (completion !== 0 && completion !== 100) {
                row.style.display = isHidden ? 'none' : '';
            }
        });
        this.textContent = isHidden ? "Show Other% Completions" : "Hide Other% Completions";
        hideOther = isHidden;
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
        return isHidden;
    }

    function resetVisibility() {
        rows.forEach(row => {
            const completion = parseFloat(row.cells[1].innerText.replace('%', ''));
            row.style.display = '';
        });
        hide100Btn.textContent = "Hide 100% Completion";
        hide0Btn.textContent = "Hide 0% Completion";
        hideOthersBtn.textContent = "Hide Other% Completion";
    }

    function registerHeader() {
        header.addEventListener('click', function () {
            sort();
        });
    }

    registerHeader();

    function save(table) {
        if (!table)
            return;

        const columns = [];
        const tableColumns = table.querySelectorAll('tr');
        tableColumns.forEach(column => {
            const name = column.children[0].innerText;
            let link = null;
            if (column.children[0].children.length >= 1) {
                link = column.children[0].children[0].href;
            }
            const value = column.children[1].innerText.replace('%', '');
            columns.push({
                'name': name,
                'link': link,
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

            if (parsedData.columns[index].link) {
                let link = document.createElement('a');
                link.href = parsedData.columns[index].link;
                link.innerText = parsedData.columns[index].name;
                link.classList.add('link-style');
                row.children[0].innerText = '';
                row.children[0].appendChild(link);
                row.children[1].innerText = parsedData.columns[index].value + '%'
            } else {
                row.children[0].innerText = parsedData.columns[index].name;
                row.children[1].innerText = parsedData.columns[index].value + '%'
            }
        });
    }

    const tableData = save(table);

    let sortState = 0;

    function sort() {
        sortState = (sortState + 1) % 3;

        const tableDataCopy = JSON.parse(tableData);

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

        resetVisibility();
        apply(table, JSON.stringify(tableDataCopy));
        if (hide0) {
            hide0Btn.click();
        }
        if (hide100) {
            hide100Btn.click();
        }
        if (hideOther) {
            hideOthersBtn.click();
        }

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
