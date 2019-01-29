
<div id="container" style="min-width: 500px; height: 400px; margin: 0 auto"></div>

@section('js')
    <script src="{{ asset('/plugins/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('/plugins/highcharts/modules/exporting.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#container').highcharts({
                    chart: {
                        type: 'column',
                        margin: [ 50, 50, 120, 80]
                    },
                    title: {
                        text: 'Cantidad de Planes de Acción por Coachs'
                    },
                    xAxis: {
                        categories: [<?php echo $coachs; ?>],
                        
                        labels: {
                            rotation: -35,
                            align: 'right',
                            style: {
                                fontSize: '10px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Planes de Acción'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    tooltip: {
                        pointFormat: 'Cantidad de Planes de Acción',
                    },
                    series: [{
                        name: 'Planes de Acción',
                        data: [<?php echo $amounts; ?>],
                        dataLabels: {
                            enabled: true,
                            rotation: -90,
                            color: '#FFFFFF',
                            align: 'right',
                            x: 4,
                            y: 10,
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif',
                                textShadow: '0 0 3px black'
                            }
                        }
                    }]
                });
        });
    </script>
@endsection
