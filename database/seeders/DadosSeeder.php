<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;


class DadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create('pt_BR');;

        for ($i = 0; $i < 100; $i++) {
            DB::table('dados')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'cpf' => $this->cpf(),
                'telefone' => $faker->phoneNumber,
                'cep' => $faker->postcode,
                'endereco' => $faker->streetAddress,
                'numero' => $faker->buildingNumber,
                'complemento' => $faker->optional()->secondaryAddress,
                'bairro' => $faker->streetName,
                'cidade' => $faker->city,
                'estado' => $faker->stateAbbr,
                'data_nascimento' => $faker->date(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Generate a valid CPF number.
     *
     * @return string
     */
    private function cpf()
    {
        $n = 9;
        $n1 = '';
        $n2 = '';

        // Gerando números aleatórios para os primeiros 9 dígitos do CPF
        for ($i = 0; $i < $n; $i++) {
            $n1 .= mt_rand(0, 9);
        }

        // Calculando o primeiro dígito verificador
        for ($i = 0, $j = 10, $soma = 0; $i < $n; $i++, $j--) {
            $soma += $n1[$i] * $j;
        }
        $d1 = ($soma % 11) < 2 ? 0 : 11 - ($soma % 11);

        // Adicionando o primeiro dígito verificador ao CPF
        $n1 .= $d1;

        // Calculando o segundo dígito verificador
        for ($i = 0, $j = 11, $soma = 0; $i < $n + 1; $i++, $j--) {
            $soma += $n1[$i] * $j;
        }
        $d2 = ($soma % 11) < 2 ? 0 : 11 - ($soma % 11);

        // Adicionando o segundo dígito verificador ao CPF
        $n1 .= $d2;

        // Formatando o CPF no formato XXX.XXX.XXX-XX
        return vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split($n1));
    }
}
