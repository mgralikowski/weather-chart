<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Weather forecast for {{ $current }}</title>
</head>
<body>
<div class="container">
    <div class="starter-template">
        <h1>Weather forecast for {{ $current }}</h1>
        <p class="lead">Please select a city by clicking the button below..</p>
        @foreach ($cities as $city)
            <a href="{{ route('index', $city) }}" class="btn {{ $city === $current ? 'btn-warning' : 'btn-primary' }} ">{{ $city }}</a>
        @endforeach
        <hr>
        <div id="chart" style="height: 600px"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
    Highcharts.chart('chart', {
        chart: {
            type: 'spline',
            zoomType: 'x',
            panning: true,
            panKey: 'shift'
        },

        title: {
            text: '{{ $current }}'
        },

        subtitle: {
            text: 'Click and drag to zoom in. Hold down shift key to pan.'
        },

        xAxis: {
            type: 'datetime'
        },

        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
            }
        },

        tooltip: {
            shared: true,
            valueDecimals: 0,
        },

        series: [{
            name: 'Humidity',
            data: @json($humidity),
            type: 'column',
            tooltip: {
                valueSuffix: '%'
            },
        }, {
            name: 'Temperature',
            data: @json($temperature),
            tooltip: {
                valueSuffix: '°F'
            },
        }, {
            name: 'Pressure',
            data: @json($pressure),
            tooltip: {
                valueSuffix: 'hPa'
            },
            visible: false,
        }]
    });
</script>
</body>
</html>
