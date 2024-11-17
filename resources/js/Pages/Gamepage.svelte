<script>
    import { Chart, registerables } from "chart.js";
    Chart.register(...registerables);
    window.Chart = Chart;
    import "chartjs-adapter-date-fns";
    import { onMount } from "svelte";

    export let data;

    let cfx;

    let combinedChartConfig = {
        type: "line",
        data: {
            datasets: [
                {
                    label: "Provided by steam",
                    data: data.secondChartData,
                    borderColor: "rgb(255, 99, 132)",
                    fill: false,
                },
                {
                    label: "Tracked by this tool",
                    data: data.chartData,
                    borderColor: "rgb(75, 192, 192)",
                    fill: false,
                    hidden: true,
                },
            ],
        },
        options: {
            scales: {
                x: {
                    type: "time",
                    time: {
                        tooltipFormat: "MM/dd/yyyy HH:mm:ss",
                        displayFormats: {
                            hour: "MMM d, h",
                            minute: "MMM d, HH:mm",
                            day: "MMM d",
                        },
                    },
                    title: {
                        display: true,
                        text: "Date",
                    },
                },
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: "Completion (%)",
                    },
                    ticks: {
                        stepSize: 10,
                        font: {
                            size: 14,
                        },
                        padding: 10,
                    },
                },
            },
            parsing: {
                xAxisKey: "x",
                yAxisKey: "y",
            },
        },
    };

    onMount(() => {
        new Chart(cfx, combinedChartConfig);
    });
</script>

<main class="bg-box">
    <div class="flex justify-center content-center flex-col">
        <div class="container mx-auto bg-paper" style="max-width: 750px;">
            <a class="font-rubik text-l ml-3" href="/stats/{data.user}"
                >Return to {data.user}'s stats</a
            >
            <div class="flex justify-center mt-3 mb-3 font-grandstander">
                <h1 class="text-4xl">Stats of {data.game} for {data.user}</h1>
            </div>
            <div class="font-rubik min-h-screen">
                <div class="ml-2 mr-5">
                    <canvas bind:this={cfx}></canvas>
                </div>
            </div>
        </div>
    </div>
</main>
