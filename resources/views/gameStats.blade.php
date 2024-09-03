<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Game Completion Chart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss', 'resources/js/chart.js'])
</head>
<body>
<div class="container mt-5">
    <a href="/stats/{{$user->name}}" class="btn border">Stats for {{$user->name}}</a>
    <div class="row">
        <h1 class="text-center">Game Title: {{ $game->name }}</h1>
        <h2 class="text-center">Based on unlock time</h2>
        <canvas id="myChart2"></canvas>
        <h2 class="text-center">Tracked over time</h2>
        <canvas id="myChart"></canvas>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('myChart').getContext('2d');
        var ctx2 = document.getElementById('myChart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Completion Over Time',
                    data: @json($chartData),
                    borderColor: 'rgb(75, 192, 192)',
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            tooltipFormat: 'MM/dd/yyyy HH:mm:ss',
                            displayFormats: {
                                hour: 'MMM d, h',
                                minute: 'MMM d, HH:mm',
                                day: 'MMM d'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Completion (%)'
                        }
                    }
                },
                parsing: {
                    xAxisKey: 'x',
                    yAxisKey: 'y'
                }
            }
        });

        var myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Completion Over Time',
                    data: @json($secondChartData),
                    borderColor: 'rgb(75, 192, 192)',
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            tooltipFormat: 'MM/dd/yyyy HH:mm:ss',
                            displayFormats: {
                                hour: 'MMM d, h',
                                minute: 'MMM d, HH:mm',
                                day: 'MMM d'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Completion (%)'
                        }
                    }
                },
                parsing: {
                    xAxisKey: 'x',
                    yAxisKey: 'y'
                }
            }
        });
    });
</script>
</body>
</html>
