<script>
    import Activities from "./components/Activities.svelte";
    export let data;
</script>

<main class="bg-box">
    <div class="flex justify-center content-center flex-col">
        <div class="container mx-auto bg-paper" style="max-width: 750px;">
            <div class="flex justify-center mt-3 mb-3 font-grandstander">
                <h1 class="text-4xl">Acitivies of the last month</h1>
            </div>
            <div class="font-rubik">
                <Activities {data} />
            </div>
        </div>
    </div>
</main>
