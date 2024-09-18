<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\SolicitationController;

Route::get('/solicitations/export-all', [SolicitationController::class, 'exportAll'])->name('solicitations.export-all');

// Route::post('/solicitations/export', [SolicitationController::class, 'exportSelected'])->name('solicitations.export');

Route::get('/', function () {
    // if (Auth::check()) {
    return redirect()->route('filament.admin.pages.dashboard'); // ou a rota apropriada do Filament
    // }

    // return view('welcome'); // ou outra view para não autenticados
});