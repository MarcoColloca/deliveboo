@extends('layouts.app')

@section('title', 'Statistiche dei tuoi ordini')

@section('content')
<section>


    <div class="container">
        <x-filters :companies="$companies" />
        <div class="card mt-3">
            <div class="card-body">
                <canvas id="barChart" height="400"></canvas>
            </div>
        </div>
    </div>

    <script>
        let chart;

        function getData() {
            $.ajax({
                url: '/admin/bar-chart',
                method: 'GET',
                dataType: 'json',
                data: {
                    'company': $("#company").val(),
                    'from': $("#from").val(),
                    'to': $("#to").val(),
                },
                success: function (data) {
                    const companyData = data.companyData;
                    const labels = companyData.map(item => item.period);
                    const totalOrders = companyData.map(item => item.total_orders);
                    const orderCounts = companyData.map(item => item.order_count);

                    const ctx = document.getElementById('barChart').getContext('2d');

                    if (chart) {
                        chart.destroy();
                    }

                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Guadagni',
                                    data: totalOrders,
                                    backgroundColor: 'rgb(252, 183, 33)',
                                    yAxisID: 'y',
                                },
                                {
                                    label: 'Numero ordini',
                                    data: orderCounts,
                                    backgroundColor: 'rgb(24, 71, 93)',
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Euro €'
                                    }
                                },
                                y1: {
                                    beginAtZero: true,
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Numero ordini'
                                    },
                                    grid: {
                                        drawOnChartArea: false,
                                    },
                                }

                            }
                        }
                    });
                },

            });
        }
        $(document).ready(function () {
            getData();
        });
    </script>

</section>

@endsection