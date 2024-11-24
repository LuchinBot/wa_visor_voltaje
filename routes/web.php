<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;

Route::get('firebase/get', [FirebaseController::class, 'getData']);

Route::get('/', [FirebaseController::class, 'showChart']); 
Route::get('/firebase/data', [FirebaseController::class, 'getRealtimeData']);
Route::get('/consultas', [FirebaseController::class, 'showConsultaPage'])->name('consultas.index');
Route::get('/consultas/data', [FirebaseController::class, 'queryData'])->name('consultas.queryData');

/*
Route::get('/', function () {
    return view('welcome');
});*/
