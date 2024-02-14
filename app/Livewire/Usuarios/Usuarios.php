<?php

namespace App\Livewire\Usuarios;

use App\Models\Dado;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Usuarios extends Component
{

    // use WithPagination;

    public $query;
    public $resultados;
    public $showResults = false;
    public $usuarioSelecionado;



    public $nomeCompleto;
    public $cpf;
    public $email;
    public $telefone;
    public $cep;
    public $endereco;
    public $numero;
    public $complemento;
    public $bairro;
    public $cidade;
    public $estado;
    public $dataNascimento;

    protected $listeners = ['confirm-delete' => 'deleteUser'];


    public $usuarioParaDeletar;

    public $editando = false;
    public $usuarioParaEditar;

    public $usuarioParaVisualizar;

    protected $rules = [
        'usuarioParaEditar.name'            => 'required|string|max:255',
        'usuarioParaEditar.cpf'             => 'required|string|max:14',
        'usuarioParaEditar.email'           => 'required|string|email|max:255',
        'usuarioParaEditar.telefone'        => 'required|string|max:20',
        'usuarioParaEditar.cep'             => 'required|string|max:9',
        'usuarioParaEditar.endereco'        => 'required|string|max:255',
        'usuarioParaEditar.numero'          => 'required|string|max:20',
        'usuarioParaEditar.complemento'     => 'nullable|string|max:255',
        'usuarioParaEditar.bairro'          => 'required|string|max:255',
        'usuarioParaEditar.cidade'          => 'required|string|max:255',
        'usuarioParaEditar.estado'          => 'required|string|max:2',
        'usuarioParaEditar.data_nascimento' => 'nullable|date',


        'name'            => 'required|string|max:255',
        'email'           => 'required|string|max:14',
        'cpf'             => 'required|string|email|max:255',
        'telefone'        => 'required|string|max:20',
        'cep'             => 'required|string|max:9',
        'endereco'        => 'required|string|max:255',
        'numero'          => 'required|string|max:20',
        'complemento'     => 'nullable|string|max:255',
        'bairro'          => 'required|string|max:255',
        'cidade'          => 'required|string|max:255',
        'estado'          => 'required|string|max:2',
        'dataNascimento' => 'nullable|date',
    ];

    public $obj;



    public function render()
    {

        if (!empty($this->dadoSelecionado)) {
            // Exibe apenas o usuário selecionado
            $dados = Dado::find($this->dadoSelecionado);
        } elseif (!empty($this->query)) {
            // Exibe os resultados da pesquisa
            $dados = Dado::where("name", 'like', '%' . $this->query . '%')->paginate(10);
        } else {
            // Exibe a lista completa de usuários
            $dados = Dado::paginate(10);
        }

        return view('livewire.usuarios.usuarios', compact('dados'));
    }

    public function updatedQuery()
    {


        if (!empty($this->query)) {


            $this->resultados = Dado::where("name", 'like', '%' . $this->query . '%')->take(5)->get();
            if (empty($this->resultados)) {
                Dado::where("email", 'like', '%' . $this->query . '%')->take(5)->get();
                if (empty($this->resultados)) {
                    Dado::where("cpf", 'like', '%' . $this->query . '%')->take(5)->get();
                }
            }
            $this->showResults = true;
        } else {
            $this->resultados = [];
            $this->showResults = false;
        }

        if (empty($this->query)) {
            $this->showResults = false;
            $this->resultados = [];
        }
    }


    public function limparQuery()
    {
        $this->query = '';
        $this->showResults = false;
    }

    public function hideResults()
    {
        $this->showResults = false;
    }

    public function selecionarOpcao($opcao)
    {
        $this->usuarioSelecionado = $opcao;
        $this->showResults = false;
        $this->limparQuery();
    }

    public function salvarUsuario()
    {


        $data = [
            'name'              => $this->nomeCompleto,
            'email'             => $this->email,
            'cpf'               => $this->cpf,
            'telefone'          => $this->telefone,
            'cep'               => $this->cep,
            'endereco'          => $this->endereco,
            'numero'            => $this->numero,
            'complemento'       => $this->complemento,
            'bairro'            => $this->bairro,
            'cidade'            => $this->cidade,
            'estado'            => $this->estado,
            'data_nascimento'   => $this->dataNascimento
        ];

        DB::beginTransaction();

        try {

            // Verifica se já existe um registro com o mesmo CPF ou email
            $existingUser = Dado::where('cpf', $this->cpf)
                ->orWhere('email', $this->email)
                ->first();

            if ($existingUser) {
                // Usuário com CPF ou email duplicado encontrado
                if ($existingUser->cpf === $this->cpf) {
                    // CPF duplicado
                    throw new \Exception('CPF já cadastrado.');
                } else {
                    // Email duplicado
                    throw new \Exception('Email já cadastrado.');
                }
            }

            Dado::create($data);
            DB::commit();


            $this->emit('alerta', [1, "Registro salvo com sucesso."]);

            $this->nomeCompleto     = '';
            $this->cpf              = '';
            $this->email            = '';
            $this->telefone         = '';
            $this->cep              = '';
            $this->endereco         = '';
            $this->numero           = '';
            $this->complemento      = '';
            $this->bairro           = '';
            $this->cidade           = '';
            $this->estado           = '';
            $this->dataNascimento   = '';
        } catch (\Throwable $th) {


            DB::rollback();
            $this->emit('alerta', [2, $th->getMessage()]);
        }
    }


    public function editarUsuario($id)
    {

        $this->editando = true;
        $this->usuarioParaEditar = Dado::find($id);
    }


    public function lerUsuario($id)
    {
        
        $this->usuarioParaVisualizar = Dado::find($id);
    }
    

    public function atualizarUsuario()
    {



        DB::beginTransaction();



        try {
            if ($this->usuarioParaEditar !== null) {
                $idUser = $this->usuarioParaEditar->id;
            }
            if (!empty($idUser)) {
                $existingUser = Dado::where(function ($query) {
                    $query->where('cpf', $this->cpf)
                        ->orWhere('email', $this->email);
                })
                    ->where('id', '!=', $idUser)
                    ->first();







                if ($existingUser) {
                    // Verifica se já existe um registro com o mesmo CPF ou email
                    if ($existingUser->cpf === $this->cpf) {
                        throw new \Exception('Erro: Você esta tentando inserir um CPF que já existe na plataforma');
                    } else {
                        throw new \Exception('Erro: Você esta tentando inserir um E-Mail que já existe na plataforma');
                    }
                }

                // Atualiza os dados do usuário
                $this->usuarioParaEditar->save();

                DB::commit();

                $this->emit('alerta', [1, "Registro atualizado com sucesso."]);

                // Reseta as propriedades
                $this->reset(['editando', 'usuarioParaEditar']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $this->emit('alerta', [2, $th->getMessage()]);
        }
    }


    public function deleteUser($userId)
    {

        
        try {
            DB::beginTransaction();
            $user = Dado::findOrFail($userId);
            $user->delete();
            DB::commit();
            $this->emit('alerta', [1, "Registro deletado com sucesso."]);
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('alerta', [2, "Ocorreu um erro ao apagar os registros"]);
        }
    }
}
