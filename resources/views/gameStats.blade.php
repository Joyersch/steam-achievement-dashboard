<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Game Completion Chart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h1 class="text-center">Game Title: {{ $game->name }}</h1> <!-- Hier den Titel des Spiels einfügen -->
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Completion Over Time',
                        data: @json($chartData),
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                tooltipFormat: 'MM/dd/yyyy HH:mm:ss',
                                displayFormats: {
                                    hour: 'MMM d, hA',
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
            })
        ;
    });
</script>
</body>
</html>
