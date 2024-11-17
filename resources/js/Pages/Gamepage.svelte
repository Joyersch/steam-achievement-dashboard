<script>
    import { Chart, registerables } from "chart.js";
    Chart.register(...registerables);
    window.Chart = Chart;
    import "chartjs-adapter-date-fns";
    import { onMount } from "svelte";

    export let data;

    let cfx;
    let cfx2;

    let chartConfig = {
        type: "line",
        data: {
            datasets: [
                {
                    label: "Completion Over Time",
                    data: data.chartData,
                    borderColor: "rgb(75, 192, 192)",
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
                },
            },
            parsing: {
                xAxisKey: "x",
                yAxisKey: "y",
            },
        },
    };

    let chartConfig2 = {
        type: "line",
        data: {
            datasets: [
                {
                    label: "Completion Over Time",
                    data: data.secondChartData,
                    borderColor: "rgb(75, 192, 192)",
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
                },
            },
            parsing: {
                xAxisKey: "x",
                yAxisKey: "y",
            },
        },
    };

    onMount(() => {
        new Chart(cfx, chartConfig);
        new Chart(cfx2, chartConfig2);
    });
</script>

<main class="bg-box">
    <div class="flex justify-center content-center flex-col">
        <div class="container mx-auto bg-paper" style="max-width: 750px;">
            <div class="flex justify-center mt-3 mb-3 font-grandstander">
                <h1 class="text-4xl">Stats of {data.game} for {data.user}</h1>
            </div>
            <div class="font-rubik min-h-screen">
                <h2 class="text-center">Based on unlock time</h2>
                <canvas bind:this={cfx}></canvas>
                <h2 class="text-center">Tracked over time</h2>
                <canvas bind:this={cfx2}></canvas>
            </div>
        </div>
    </div>
</main>
