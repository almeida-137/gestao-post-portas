<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solicitation;
use Faker\Factory as Faker;

class SolicitationSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Solicitation::create([
                'cliente' => 'Cliente ' . $i,
                'loja' => 'Loja ' . $i,
                'dataDoPedido' => now(),
                'montador' => 'Montador ' . $i,
                'itens' => json_encode($this->generateItems($i)),
            ]);
        }
    }

    private function generateItems($i)
    {
        $items = [];
        for ($j = 1; $j <= 10; $j++) {
            $items[] = [
                'ambiente' => 'Ambiente ' . $j,
                'cod_ambiente' => 'Código ' . $j,
                'quantidade' => rand(1, 100),
                'descricao' => 'Descrição do item ' . $j,
                'dimensoes' => [
                    'largura' => rand(20, 100),
                    'altura' => rand(20, 100),
                    'profundidade' => rand(10, 50),
                ],
                'cor' => 'Cor ' . $j,
                'cor_borda' => 'Cor Borda ' . $j,
                'filetacao' => '0L 0H',
                'motivo' => 'Motivo ' . $j,
                'obs' => 'Observação ' . $j,
                'anexos' => ['example.png'], // Adicione seus anexos aqui
            ];
        }
        return $items;
    }
}
