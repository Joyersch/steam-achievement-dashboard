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
                <h2 class="text-2xl flex justify-center">
                    {data.user.name} has
                    <strong class="ml-1 mr-1">
                        {(data.completion * 100).toFixed(3)}%
                    </strong>
                    completion average...
                </h2>
                <h2 class="text-2xl flex justify-center">
                    with
                    <div class="ml-1 mr-1">
                        <strong>
                            {data.achievements}
                        </strong>
                    </div>
                    achievements...
                </h2>
                <h2 class="text-2xl flex justify-center">
                    where
                    <div class="ml-1 mr-1">
                        <div class="flex flex-row">
                            <strong>
                                {data.games.started}
                            </strong>
                            <div>/</div>
                            <strong>
                                {data.games.count}
                            </strong>
                        </div>
                    </div>
                    games have been started...
                </h2>
                <h2 class="text-2xl flex justify-center">
                    of which
                    <div class="ml-1 mr-1">
                        <div class="flex flex-row">
                            <strong>
                                {data.games.finished}
                            </strong>
                            <div>/</div>
                            <strong>
                                {data.games.started}
                            </strong>
                        </div>
                    </div>
                    games have been finished.
                </h2>
            </div>

            <div class="m-3 mt-5">
                <Table {data} />
            </div>
        </div>
    </div>
</main>
