<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
      .highcharts-figure, .highcharts-data-table table {
    min-width: 320px; 
    max-width: 660px;
    margin: 1em auto;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

  </style>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>
<body>
  <figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        Variable radius pie charts can be used to visualize a
        second dimension in a pie chart. In this chart, the more
        densely populated countries are drawn further out, while the
        slice width is determined by the size of the country.
    </p>
</figure>
</body>
<script type="text/javascript">
Highcharts.chart('container', {
    chart: {
        type: 'variablepie'
    },
    title: {
        text: 'Countries compared by population density and total area.'
    },
    tooltip: {
        headerFormat: '',
        pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
            'Area (square km): <b>{point.ya}</b><br/>' +
            'Population density (people per square km): <b>{point.z}</b><br/>' +
            'TESTING: <b>{point.x}</b><br/>' +
            'ROAST: <b>{point.W}</b><br/>'
    },
    series: [{
        minPointSize: 10,
        innerSize: '20%',
        zMin: 0,
        name: 'countries',
        data: [{
            name: 'Spain',
            y: 505370,
            z: 92.9,
            x:123,
            W: 92.9
        }, {
            name: 'France',
            y: 551500,
            z: 118.7,
            x:123,
            W: 92.9
        }, {
            name: 'Poland',
            y: 312685,
            z: 124.6,
            x:123,
            W: 92.9
        }, {
            name: 'Czech Republic',
            y: 78867,
            z: 137.5,
            x:123,
            W: 92.9
        }, {
            name: 'Italy',
            y: 301340,
            z: 201.8,
            x:123,
            W: 92.9
        }, {
            name: 'Switzerland',
            y: 41277,
            z: 214.5,
            x:123,
            W: 92.9
        }, {
            name: 'Germany',
            y: 357022,
            z: 235.6,
            x:123,
            W: 92.9
        }, {
            name: 'Germany',
            y: 357022,
            z: 235.6,
            x:123,
            W: 92.9
        }, {
            name: 'Germany',
            y: 357022,
            z: 235.6,
            x:123,
            W: 92.9
        }, {
            name: 'Germany',
            y: 357022,
            z: 235.6,
            x:123,
            W: 92.9
        }]
    }]
});

</script>
</html>




