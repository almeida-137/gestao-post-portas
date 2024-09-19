<?php
// database/migrations/xxxx_xx_xx_create_solicitacoes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitationTable extends Migration
{
    public function up()
    {
        Schema::create('solicitations', function (Blueprint $table) {
            $table->id();
            $table->string('loja');
            $table->date('dataDoPedido');
            $table->string('cliente');
            $table->string('montador');
            $table->enum('status', ['Enviado', 'Em Produção', 'Produção 3CAD', 'Pedido Vitralle', 'Concluído']);
            $table->json('itens')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitations');
    }
}
