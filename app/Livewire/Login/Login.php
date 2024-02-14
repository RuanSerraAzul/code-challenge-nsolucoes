<?php

namespace App\Livewire\Login;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component
{
    public function render()
    {
        return view('livewire.login.login');
    }

    public $email = '';
    public $password = '';
    public $erroLogin = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:3',
    ];

    protected $messages = [
        'email.required' => 'O campo e-mail é obrigatório.',
        'email.email' => 'E-mail inválido.',
        'password.required' => 'O campo senha é obrigatório.',
    ];

    public function login()
    {
        $this->validate();

        $credentials = ["email" => $this->email, "password" => $this->password];

        if (Auth::attempt($credentials)) {

            return redirect()->route('usuarios');
        } else {
            $this->erroLogin = "Login ou senha inválida";
        }
    }

    public function logout()
    {

        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
    
}
