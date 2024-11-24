<!-- resources/views/grafico.blade.php -->
@extends('layouts.app')

@section('title', 'Gráfico de Voltaje en Tiempo Real')

@section('content')
<h4 class="fw-bold text-dark m-0 p-0">Voltaje en Tiempo Real</h4>
<div class="d-flex justify-content-start border-bottom py-3 mb-3">
    <button type="button" class="btn btn-success me-2">
        <span id="ssid_dispositivo"></span> <span class="badge bg-white"><i class="fa fa-wifi text-dark"></i></span>
    </button>
    <button type="button" class="btn btn-success">
        <span id="ip_dispositivo"></span> <span class="badge bg-white"><i class="fa fa-server text-dark"></i></span>
    </button>
</div>

<div class="col">
    <div class="col-md-12 bg-dark rounded p-3 mb-3">
        <canvas id="voltajeChart"></canvas>
    </div>
    <p class="fw-bold border-bottom">Consola <small class="text-muted fw-light">(Mostrando las últimas 10
            variaciones)</small></p>
    <div id="consola" class="border rounded bg-dark text-white p-3 my-3"></div>
</div>
@endsection

@section('scripts')
<script>
const ctxLine = document.getElementById('voltajeChart').getContext('2d');

let timeLabels = []; // Para las etiquetas del tiempo (en timestamp)
let voltageData = []; // Para los datos de voltaje
let last10Data = []; // Array para almacenar los últimos 10 datos en la consola

const voltageChartLine = new Chart(ctxLine, {
    type: 'line', // Tipo de gráfico de línea
    data: {
        labels: timeLabels, // Las etiquetas del eje X (timestamp)
        datasets: [{
            label: 'Voltaje',
            data: voltageData, // Datos del voltaje
            borderColor: 'rgba(75, 192, 192, 1)',
            fill: false,
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                type: 'time', // Usamos el tipo de escala de tiempo
                time: {
                    unit: 'second', // Mostrar por segundos (en vez de minutos)
                    tooltipFormat: 'll HH:mm:ss', // Mostrar hora, minuto y segundo en el tooltip
                    displayFormats: {
                        second: 'HH:mm:ss', // Formato de visualización de la etiqueta
                    }
                },
                title: {
                    display: true,
                    text: 'Hora'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Voltaje'
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Voltaje: ' + context.raw.toFixed(2); // Mostrar valor más preciso en tooltip
                    }
                }
            },
            legend: {
                labels: {
                    usePointStyle: true,
                },
            }
        }
    }
});

// Función para obtener datos de Firebase y actualizar los gráficos
function updateChart() {
    axios.get('/firebase/data') // URL del backend que obtiene los datos
        .then(response => {
            const data = response.data;

            // Procesamos los datos y actualizamos ambos gráficos
            data.forEach(reading => {
                const timestamp = new Date(reading.fecha_recopilacion).getTime(); // Convertir a timestamp
                const voltage = reading.voltaje;
                const ipDispositivo = reading.ip_dispositivo;
                const ssidDispositivo = reading.ssid_dispositivo;

                // Mostrar IP y SSID en la interfaz de usuario
                document.getElementById('ip_dispositivo').textContent = 'IP: ' + ipDispositivo;
                document.getElementById('ssid_dispositivo').textContent = 'SSID: ' + ssidDispositivo;

                // Definir fechaHora para mostrar en la consola
                const fechaHora = new Date(reading.fecha_recopilacion).toLocaleString();

                // Añadir el último dato al array de los 10 más recientes
                last10Data.push({
                    fechaHora,
                    voltage
                });

                // Limitar a los 10 últimos datos
                if (last10Data.length > 10) {
                    last10Data.shift(); // Eliminar el primer elemento si hay más de 10
                }

                // Mostrar los últimos 10 datos en la consola en orden descendente
                const consolaHTML = last10Data.reverse().map(item => {
                    return `Fecha y hora: ${item.fechaHora} - Voltaje: ${item.voltage}`;
                }).join('<br>');

                document.getElementById('consola').innerHTML = consolaHTML;

                // Añadir los nuevos valores al gráfico
                timeLabels.push(timestamp); // Usamos el timestamp como etiqueta para el eje X
                voltageData.push(voltage);

                // Limitar el número de puntos de datos a mostrar (por ejemplo, los últimos 50)
                if (timeLabels.length > 50) {
                    timeLabels.shift();
                    voltageData.shift();
                }
            });

            // Actualizamos el gráfico
            voltageChartLine.update();
        })
        .catch(error => {
            console.error("Error al obtener los datos de Firebase:", error);
        });
}

// Actualizamos los gráficos cada 3 segundos
setInterval(updateChart, 3000);
</script>
@endsection