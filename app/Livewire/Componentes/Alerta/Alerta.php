<?php

namespace App\Livewire\Componentes\Alerta;

use Livewire\Component;

class Alerta extends Component
{
    public $alerta = 0; // 0 - sem alertas | 1 - sucesso | 2 - error 
    public $mensagem = '';
    protected $listeners = ['alerta' => 'alerta'];

    public function render()
    {
        return view('livewire.componentes.alerta.alerta');
    }

    public function alerta($emit){
        $this->alerta = $emit[0];
        $this->mensagem = $emit[1];
    }

    public function fecharAlerta(){
        $this->alerta = 0;
    }
}