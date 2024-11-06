<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnginnersTable extends Migration
{
    /**
     * Execute a migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enginners', function (Blueprint $table) {
            $table->id(); // Criar a chave primária auto incremento
            $table->string('cliente'); // Campo para o nome do cliente
            $table->date('dataEng'); // Data Engenharia
            $table->date('dataPcp')->nullable(); // Data PCP, pode ser nula
            $table->date('dataFinalizacao')->nullable(); // Data de Finalização, pode ser nula
            $table->string('status'); // Status do engenheiro
            $table->json('itens')->nullable(); // Itens, armazenado como JSON (pode ser nulo)
            $table->timestamps(); // Cria campos 'created_at' e 'updated_at'
        });
    }

    /**
     * Revert the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enginners');
    }
}
