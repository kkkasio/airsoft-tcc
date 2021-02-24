@extends('league.layouts.base')

@section('title', '- Dashboard')

@section('content')

<div class="content">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                    </div>
                    <h2 class="page-title">
                        Visão Geral
                    </h2>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-status-start bg-primary"></div>
                    <div class="card-body">
                        <h3 class="card-title">Card with side status</h3>
                        <p><b>Membros</b>: {{count($members)}}</p>
                        <p><b>Times</b>: {{count($teams)}}</p>
                        <p>Eventos: {{count($members)}}</p>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div id="chart-demo-line" class="chart-lg"></div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<script src="https://preview.tabler.io/dist/libs/apexcharts/dist/apexcharts.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-demo-line'), {
            chart: {
                type: "line",
                fontFamily: 'inherit',
                height: 240,
                parentHeightOffset: 0,
                toolbar: {
                    show: false,
                },
                animations: {
                    enabled: false
                },
            },
            fill: {
                opacity: 1,
            },
            stroke: {
                width: 2,
                lineCap: "round",
                curve: "straight",
            },
            series: [{
                name: "Membros Participantes",
                data: [117, 92, 94, 98, 75, 110, 69, 80, 109, 113, 115, 95]
            },{
                name: "Eventos",
                data: [59, 80, 61, 66, 70, 84, 87, 64, 94, 56, 55, 67]
            },{
                name: "Inscrições",
                data: [53, 51, 52, 41, 46, 60, 45, 43, 30, 50, 58, 59]
            }],
            grid: {
                padding: {
                    top: -20,
                    right: 0,
                    left: -4,
                    bottom: -4
                },
                strokeDashArray: 4,
            },
            xaxis: {
                labels: {
                    padding: 0,
                },
                tooltip: {
                    enabled: false
                },
                type: 'datetime',
            },
            yaxis: {
                labels: {
                    padding: 4
                },
            },
            labels: [
                '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02'
            ],
            colors: ["#fab005", "#5eba00", "#206bc4"],
            legend: {
                show: true,
                position: 'bottom',
                offsetY: 12,
                markers: {
                    width: 10,
                    height: 10,
                    radius: 100,
                },
                itemMargin: {
                    horizontal: 8,
                    vertical: 8
                },
            },
        })).render();
    });
</script>

@endsection
