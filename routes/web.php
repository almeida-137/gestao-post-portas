<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SolicitationController;
use App\Http\Controllers\PDFController;

Route::get('/generate-pdf/{id}', [PDFController::class, 'generatePDF']);
Route::get('/solicitations/export-all', [SolicitationController::class, 'exportAll'])->name('solicitations.export-all');
Route::get('/admin/solicitation/{record}', [SolicitationController::class, 'show'])->name('admin.solicitations.show');
Route::get('/', function () {
    return redirect()->route('filament.admin.resources.solicitations.index'); // ou a rota apropriada do Filament

});