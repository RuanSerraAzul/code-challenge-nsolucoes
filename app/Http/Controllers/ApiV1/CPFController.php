<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CPFController extends Controller
{
    public function validateCPF($cpf)
    {
        $cpfSemMascara = preg_replace('/[^0-9]/', "", $cpf); //REGEX para remover mascara do CPF

        if (strlen($cpfSemMascara) != 11) {  //validar se o CPF tem 11 caracteres sem mascara

            return response()->json([
                'success' => false,
                'message' => 'CPF não é válido',
            ], 200);
        }

        if (strlen($cpfSemMascara) != 11 || preg_match('/([0-9])\1{10}/', $cpfSemMascara)) { //verificar se o CPF não possui todos os seus 11 dígitos iguais.
            return response()->json([
                'success' => false,
                'message' => 'CPF não é válido',
            ], 200);
        }

        $sum = 0;
        $number_to_multiplicate = 10;
        $number_quantity_to_loop = [9, 10];

        foreach ($number_quantity_to_loop as $item) {

            $sum = 0;
            $number_to_multiplicate = $item + 1;

            for ($index = 0; $index < $item; $index++) {

                $sum += $cpfSemMascara[$index] * ($number_to_multiplicate--);
            }

            $result = (($sum * 10) % 11);
        }

        if ($cpfSemMascara[$item] != $result) {
            return response()->json([
                'success' => false,
                'message' => 'CPF não é válido',
            ], 200);
        };


        return response()->json([
            'success' => true,
            'message' => 'CPF válido',
        ], 200);
    }
}
