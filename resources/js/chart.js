import {Chart, registerables} from "chart.js";
Chart.register(...registerables);
window.Chart = Chart;
import 'chartjs-adapter-date-fns';
