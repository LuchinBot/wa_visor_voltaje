<!-- resources/views/consultas.blade.php -->
@extends('layouts.app')

@section('title', 'Consulta de Datos de Voltaje')

@section('content')
<h4 class="fw-bold text-dark m-0 py-3 border-bottom mb-3">Consulta de Datos de Voltaje</h4>
<form id="formConsulta" class="mb-3 bg-white p-3 rounded">
    <div class="row">
        <div class="col-md-4">
            <label for="fechaInicio" class="form-label fw-bold text-secondary">Fecha de inicio</label>
            <input type="datetime-local" class="form-control" id="fechaInicio">
        </div>
        <div class="col-md-4">
            <label for="fechaFin" class="form-label fw-bold text-secondary">Fecha de fin</label>
            <input type="datetime-local" class="form-control" id="fechaFin">
        </div>
        <div class="col-md-2">
            <label for="voltajeMin" class="form-label fw-bold text-secondary">Voltaje Mínimo</label>
            <input type="number" class="form-control" id="voltajeMin">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100">Consultar</button>
        </div>
    </div>
</form>

<div id="resultados" class="mt-4 bg-white p-3 rounded"></div>
@endsection

@section('scripts')
<script>
document.getElementById('formConsulta').addEventListener('submit', function(e) {
    e.preventDefault();
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    const voltajeMin = document.getElementById('voltajeMin').value;

    let url = `/consultas/data?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`;
    if (voltajeMin) {
        url += `&voltaje_min=${voltajeMin}`;
    }

    axios.get(url)
        .then(response => {
            const data = response.data;
            let resultadosHTML = '<table class="table table-striped">';
            resultadosHTML +=
                '<thead><tr><th>Fecha y hora</th><th class="text-start">Voltaje</th><th class="text-center">SSID</th><th class="text-center">Dispositivo</th></tr></thead>';
            resultadosHTML += '<tbody>';

            data.forEach(item => {
                resultadosHTML += `<tr>
                            <td>${new Date(item.fecha_recopilacion).toLocaleString()}</td>
                            <td class="text-start">${item.voltaje}</td>
                            <td class="text-center">${item.ssid_dispositivo}</td>
                            <td class="text-center">${item.ip_dispositivo}</td>
                        </tr>`;
            });

            resultadosHTML += '</tbody></table>';
            document.getElementById('resultados').innerHTML = resultadosHTML;
        })
        .catch(error => {
            console.error('Error al realizar la consulta:', error);
            document.getElementById('resultados').innerHTML = 'Error al obtener los datos.';
        });
});
</script>
@endsection