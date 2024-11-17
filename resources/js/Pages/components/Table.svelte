<script>
    export let data;

    let filtedData = [...data.stats];
    let sortOrder = { column: null, direction: null };

    let filters = {
        show100: true,
        show0: true,
        showOther: true,
    };

    let sortedData = [...filtedData];

    function sortData() {
        if (sortOrder === "asc") {
            sortOrder = "desc";
        } else if (sortOrder === "desc") {
            sortOrder = null;
        } else {
            sortOrder = "asc";
        }

        updateDOM();
    }

    function applySort() {
        sortedData = [...filtedData];
        if (sortOrder === "asc") {
            sortedData.sort((a, b) => a.completion - b.completion);
        } else if (sortOrder === "desc") {
            sortedData.sort((a, b) => b.completion - a.completion);
        } else {
            sortedData = [...filtedData];
        }
        sortedData = [...sortedData];
    }

    function toggleFilter(filterType) {
        filters[filterType] = !filters[filterType];
        updateDOM();
    }

    function applyFilters() {
        filtedData = data.stats.filter((stat) => {
            if (!filters.show100 && stat.completion === 1) return false;
            if (!filters.show0 && stat.completion === 0) return false;
            if (
                !filters.showOther &&
                stat.completion > 0 &&
                stat.completion < 1
            )
                return false;
            return true;
        });

        filtedData = [...filtedData];
    }

    function updateDOM() {
        applyFilters();
        applySort();
    }
</script>

<div class="mb-4 flex justify-center space-x-4">
    <button
        on:click={() => toggleFilter("show100")}
        class="border-2 border-box rounded-full px-6 py-2"
    >
        {filters.show100 ? "Hide 100%" : "Show 100%"}
    </button>
    <button
        on:click={() => toggleFilter("show0")}
        class="border-2 border-box rounded-full px-6 py-2"
    >
        {filters.show0 ? "Hide 0%" : "Show 0%"}
    </button>
    <button
        on:click={() => toggleFilter("showOther")}
        class="border-2 border-box rounded-full px-6 py-2"
    >
        {filters.showOther ? "Hide Other%" : "Show Other%"}
    </button>
</div>
<div class="flex flex-col">
    <div class="flex-grow">
        <table class="table w-full border-collapse">
            <thead>
                <tr>
                    <th class="text-left text-xl w-full"> Game Name </th>
                    <th
                        class="text-right text-xl"
                        style="min-width:250px"
                        id="completion_header"
                        on:click={() => sortData("completion")}
                    >
                        Completion Rate (%)
                        {#if sortOrder === "asc"}
                            {"▲"}
                        {/if}
                        {#if sortOrder === "desc"}
                            {"▼"}
                        {/if}
                    </th>
                </tr>
            </thead>
            <tbody>
                {#each sortedData as stat}
                    <tr class="border-t-2 border-box box-border">
                        <td class="text-left py-1">
                            <a
                                href="/stats/{data.user.name}/{stat.game.id}"
                                class="link-style">{stat.game.name}</a
                            >
                        </td>
                        <td class="text-center py-1">
                            {(stat.completion * 100).toFixed(2)}%
                        </td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
</div>
