<div>

    <head>
        <style>
            /* Reset CSS */
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: Arial, sans-serif;
                font-size: 16px;
                background-color: #f5f5f5;
            }

            .container {
                padding: 20px 0;
            }

            .card {
                border: 1px solid #ddd;
                border-radius: 4px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .card-header {
                background-color: #428bca;
                color: #fff;
                padding: 10px;
                text-align: center;
            }

            .card-body {
                padding: 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-control {
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 10px;
                height: 44px;
                box-shadow: none;
            }

            .form-control:focus {
                border-color: #428bca;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }

            .btn-primary {
                background-color: #428bca;
                color: #fff;
                border-color: #428bca;
                border-radius: 4px;
                padding: 10px 20px;
                font-size: 16px;
                transition: 0.3s;
            }

            .btn-primary:hover {
                background-color: #337ab7;
                border-color: #337ab7;
            }

            /* Estilos adicionais para hover */

            .form-group:hover .form-control {
                border-color: #337ab7;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }

            .btn-primary {
                height: 44px;
                background-color: #428bca;
                border-color: #428bca;
                border-radius: 4px;
                font-size: 16px;
                transition: 0.3s;
            }

            .btn-primary:hover {
                background-color: #337ab7;
                border-color: #337ab7;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <img src="{{ asset('imgs/logo.png') }}" alt="Logo" height="75" width="150">
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="login">


                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input wire:model.defer="email" type="email" class="form-control" id="email"
                                        name="email" placeholder="Digite seu email">
                                </div>

                                <div class="form-group">
                                    <label for="password">Senha</label>
                                    <input wire:model.defer="password" type="password" class="form-control"
                                        id="password" name="password" placeholder="Digite sua senha">
                                </div>
                                <div class="form-group text-center">
                                    <span class="text-danger">{{ $erroLogin }}</span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



</div>
