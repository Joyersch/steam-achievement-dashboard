<script>
    import * as echarts from "echarts";
    import { onMount } from "svelte";

    export let data;

    let cfx;

    let option = {
        tooltip: {
            trigger: "axis",
            axisPointer: {
                type: "cross",
            },
            formatter: (params) => {
                const date = new Date(params[0].value[0]);

                if (params.length == 1) {
                    return `${date.toUTCString()}<br/>  ${params[0].value[1]}`;
                }
                return `${date.toUTCString()}<br/>  ${params[0].value[1]} - ${params[params.length - 1].value[1]}`;
            },
        },
        legend: {
            data: ["Provided by steam", "Tracked by this tool"],
            selected: {
                "Tracked by this tool": false, // Verstecke diesen Datensatz standardmäßig
            },
        },
        xAxis: {
            type: "time",
            name: "Date",
            nameLocation: "middle",
            nameGap:
                data.chartData.length > data.secondChartData.length
                    ? data.chartData.length
                    : data.secondChartData.length,
            axisLabel: {
                formatter: function (value) {
                    return new Date(value).toLocaleDateString();
                },
            },
        },
        yAxis: {
            type: "value",
            name: "Completion (%)",
            nameLocation: "middle",
            nameGap:
                data.chartData.length > data.secondChartData.length
                    ? data.chartData.length
                    : data.secondChartData.length,
            min: 0,
            max: 100,
            axisLabel: {
                formatter: "{value}%",
            },
            splitLine: {
                show: true,
            },
        },
        series: [
            {
                name: "Provided by steam",
                type: "line",
                data: data.secondChartData.map((point) => [point.x, point.y]),
                lineStyle: {
                    color: "rgb(255, 99, 132)",
                },
                itemStyle: {
                    color: "rgb(255, 99, 132)",
                },
                showSymbol: true,
                symbol: "roundRect",
            },
            {
                name: "Tracked by this tool",
                type: "line",
                data: data.chartData.map((point) => [point.x, point.y]),
                lineStyle: {
                    color: "rgb(75, 192, 192)",
                },
                showSymbol: false,
            },
        ],
    };

    onMount(() => {
        const chart = echarts.init(cfx);
        chart.setOption(option);
        window.addEventListener("resize", () => chart.resize());
    });
</script>

<main class="bg-box">
    <div class="flex justify-center content-center flex-col">
        <div class="container mx-auto bg-paper" style="max-width: 750px;">
            <a class="font-rubik text-l ml-3" href="/stats/{data.user}"
                >Return to {data.user}'s stats</a
            >
            <div class="flex justify-center mt-3 mb-3 font-grandstander">
                <h1 class="text-4xl ml-3 mr-3">
                    Stats of {data.game} for {data.user}
                </h1>
            </div>
            <div class="font-rubik min-h-screen">
                <div class="ml-2 mr-5">
                    <div bind:this={cfx} style="width: 100%; height: 600px;" />
                </div>
            </div>
        </div>
    </div>
</main>
