<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>

	<script src="vergrafica_mqtt.js"></script>
	<script src="justgage.js"></script>
	<script src="raphael-2.1.4.min.js"></script>

	<!-- grafica de base de datos -->

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>

	<!-- grafica 2 -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>

	<!-- libreria para grafica en tiempo real-->
	<script src="https://code.highcharts.com/stock/modules/stock.js"></script>
	<!-- Fin -->

</head>

<body>
	<?php
	include_once("leer_datos.php");
	?>
	<div id="valor_temp"></div>
	<div id="valor_hum"></div>
	<div id="tiempo_real"></div>

	<figure class="highcharts-figure">
		<div id="humedad"></div>
	</figure>

	<figure class="highcharts-figure">
		<div id="valor"></div>
	</figure>

	<script>
		var a = new JustGage({
			id: "valor_temp",
			min: 0,
			max: 100,
			title: "Valor microservo",
			pointer: true,
			pointerOptions: {
				toplength: 10,
				bottomlength: 10,
				bottomwidth: 8,
				color: '#1E90FF'
			}
		});

		Highcharts.stockChart('tiempo_real', {
			chart: {
				events: {
					load: function() {
						// set up the updating of the chart each second
						var series = this.series[0];
						setInterval(function() {
							var x = (new Date()).getTime(), // current time 
								y = valor_hum;
							series.addPoint([x, y]);
						}, 1000);
					}
				}
			},

			rangeSelector: {
				buttons: [{
					count: 1,
					type: 'minute',
					text: '1M'
				}, {
					count: 5,
					type: 'minute',
					text: '5M'
				}, {
					type: 'all',
					text: 'All'
				}],
				inputEnabled: false,
				selected: 0
			},

			title: {
				text: 'MICROSERVO EN TIEMPO REAL'
			},

			exporting: {
				enabled: false
			},

			series: [{
				name: 'ºC',
				data: (function() {
					// generate an array of random data
					var data = [],
						time = (new Date()).getTime(),
						i;

					for (i = -300; i <= 0; i += 1) {
						data.push([
							time + i * 1000, -1
						]);
					}
					return data;
				}())
			}]
		});

		
		Highcharts.chart('humedad', {

			title: {
				text: 'Logarithmic axis demo'
			},

			xAxis: {
				tickInterval: 1,
				type: 'datetime',
				accessibility: {
					rangeDescription: 'Range: 1 to 10'
				}
			},

			yAxis: {
				type: 'logarithmic',
				minorTickInterval: 0.1,
				accessibility: {
					rangeDescription: 'Range: 0.1 to 1000'
				}
			},

			tooltip: {
				headerFormat: '<b>{series.name}</b><br />',
				pointFormat: 'x = {point.x}, y = {point.y}'
			},

			series: [{
				data: [
					<?php
					datos();
					?>
				],
				pointStart: 1
			}]
		});

		// Data retrieved from https://companiesmarketcap.com/
		Highcharts.chart('valor', {
			chart: {
				type: 'area',
				inverted: true
			},
			title: {
				text: 'Alibaba and Meta (Facebook) revenue',
				align: 'left'
			},
			accessibility: {
				keyboardNavigation: {
					seriesNavigation: {
						mode: 'serialize'
					}
				}
			},
			tooltip: {
				pointFormat: '• {series.name}: <b>${point.y} B</b>'
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -150,
				y: 100,
				floating: true,
				borderWidth: 1,
				backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
			},
			yAxis: {
				labels: {
					format: '${text}'
				},
				title: {
					text: 'Revenue (billions USD)'
				}
			},
			plotOptions: {
				series: {
					pointStart: 2014
				},
				area: {
					fillOpacity: 0.5
				}
			},
			series: [{
				name: 'Alibaba',
				data: [
					<?php
					datos();
					?>
				]
			}, {
				name: 'Meta (Facebook)',
				data: [11.49, 17.08, 26.88, 39.94, 55.01, 69.65, 84.17, 117.93]
			}]
		});
	</script>
</body>

</html>