<script>
    import Table from "./components/Table.svelte";

    export let data;
</script>

<main class="bg-box">
    <div class="flex justify-center content-center flex-col">
        <div
            class="container mx-auto bg-paper min-h-screen"
            style="max-width: 750px;"
        >
            <a class="font-rubik text-l ml-3" href="..">Return to Activities</a>
            <div class="flex justify-center mt-3 mb-3 font-grandstander">
                <h1 class="text-4xl">Stats of {data.user.name}</h1>
            </div>
            <div class="font-rubik">
                <h2 class="text-2xl ml-3 mr-3">
                    {data.user.name} has
                    <strong>{(data.completion * 100).toFixed(3)}%</strong>
                    completion average with
                    <strong>
                        {data.achievements}
                    </strong>
                    achievements where
                    <strong>
                        {data.games.started}/{data.games.count}
                    </strong>
                    games have been started of which
                    <strong>
                        {data.games.finished}/{data.games.started}
                    </strong>
                    games have been finished.
                </h2>
            </div>

            <div class="m-3 mt-5">
                <Table {data} />
            </div>
        </div>
    </div>
</main>
