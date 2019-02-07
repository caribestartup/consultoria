
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

@section('js')
    <script src="{{ asset('/plugins/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('/plugins/highcharts/modules/exporting.js') }}"></script>
    <script type="text/javascript">

    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Planes de acción por coachs'
            },
            xAxis: {
                categories: [<?php echo $coachs; ?>] //aqui coachs
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total fraccionados por sus estado'
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
                series: [{  // aquí la serie seria diferente en ves de los amount aquí es los terminados para cada coachs
                name: 'Terminados',
                data: [<?php echo $dataResult['terminados']; ?>]
            }, {
                name: 'Comenzados', // aquí la serie seria diferente en ves de los amount aquí es los sin terminar para cada coachs
                data: [<?php echo $dataResult['sinTerminar']; ?>]
            }, {
                name: 'Sin comenzar',    // aquí la serie seria diferente en ves de los amount aquí es los totales para cada coachs
                data: [<?php echo $dataResult['sinComerzar']; ?>]
            }]
        });
    });
	</script>
@endsection
