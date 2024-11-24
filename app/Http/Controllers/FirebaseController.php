<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class FirebaseController extends Controller
{
    public function getData()
    {
        try {
            $firebase = (new Factory)
                ->withServiceAccount(config('firebase.credentials.file'))
                ->withDatabaseUri(config('firebase.database_url'))
                ->createDatabase();

            $reference = $firebase->getReference('lecturas');
            $data = $reference->getValue();

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error al conectar con Firebase: ' . $e->getMessage());
            return response()->json(['error' => 'Error al conectar con Firebase'], 500);
        }
    }

    public function showChart()
    {
        return view('chart'); 
    }

    public function getRealtimeData()
    {
        $firebase = (new Factory)
            ->withServiceAccount(config('firebase.credentials.file'))
            ->withDatabaseUri(config('firebase.database_url'))
            ->createDatabase();

        $reference = $firebase->getReference('lecturas');
        $data = $reference->getValue();

        $formattedData = [];

        foreach ($data as $key => $reading) {
            $formattedData[] = [
                'fecha_recopilacion' => $reading['fecha_recopilacion'],
                'voltaje' => $reading['voltaje'],
                'ip_dispositivo' => $reading['ip_dispositivo'],
                'ssid_dispositivo' => $reading['ssid_dispositivo']
            ];
        }

        return response()->json($formattedData);
    }

    public function showConsultaPage()
    {
        return view('consultas');
    }
    public function queryData(Request $request)
    {
        try {
            $firebase = (new Factory)
                ->withServiceAccount(config('firebase.credentials.file'))
                ->withDatabaseUri(config('firebase.database_url'))
                ->createDatabase();

            $reference = $firebase->getReference('lecturas');
            $data = $reference->getValue();

            $filteredData = [];
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFin = $request->input('fecha_fin');
            $voltajeMin = $request->input('voltaje_min');

            foreach ($data as $key => $reading) {
                // Filtrar por fecha
                $fecha = new \DateTime($reading['fecha_recopilacion']);
                $fechaInicioObj = $fechaInicio ? new \DateTime($fechaInicio) : null;
                $fechaFinObj = $fechaFin ? new \DateTime($fechaFin) : null;

                // Verificar si la fecha está dentro del rango
                if (($fechaInicioObj && $fecha < $fechaInicioObj) || ($fechaFinObj && $fecha > $fechaFinObj)) {
                    continue;
                }

                // Filtrar por voltaje mínimo
                if ($voltajeMin && $reading['voltaje'] < $voltajeMin) {
                    continue;
                }

                // Si pasa los filtros, lo agregamos a los resultados
                $filteredData[] = [
                    'fecha_recopilacion' => $reading['fecha_recopilacion'],
                    'voltaje' => $reading['voltaje'],
                    'ip_dispositivo' => $reading['ip_dispositivo'],
                    'ssid_dispositivo' => $reading['ssid_dispositivo']
                ];
            }

            return response()->json($filteredData);
        } catch (\Exception $e) {
            Log::error('Error al conectar con Firebase: ' . $e->getMessage());
            return response()->json(['error' => 'Error al conectar con Firebase'], 500);
        }
    }
}
