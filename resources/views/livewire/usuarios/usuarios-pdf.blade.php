<div>

    <livewire:componentes.alerta.alerta />


    <head>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>

        <!-- Estilos personalizados -->
        <style>
            body {
                background-color: #f8f9fa;
                /* cor de fundo mais escura */
                color: #212529;
                /* cor de texto padrão */
                z-index: 0;
            }

            .header-container {
                padding-top: 20px;
                padding-bottom: 20px;
                background-color: #343a40;
                /* cor de fundo mais escura para o cabeçalho */
                color: #fff;
                /* cor de texto para o cabeçalho */
            }

            .header-container img {
                max-height: 50px;
                display: block;
                margin: 0 auto;
                /* centralizando a logo */
            }

            .search-bar {
                max-width: 200px;
                /* Ajusta a largura da barra de pesquisa */
            }

            .btn-primary {
                padding: 0.5rem 1rem;
                /* Aumenta o tamanho dos botões */
                font-size: 1rem;
                /* Aumenta o tamanho da fonte dos botões */
            }

            @media (max-width: 768px) {

                /* Empilha os elementos em dispositivos móveis */
                .d-flex {
                    flex-direction: column;
                }

                .search-bar {
                    margin-bottom: 1rem;
                }
            }

            .table-container {
                background-color: #fff;
                /* cor de fundo da tabela */
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                /* sombra suave */
            }

            /* Estilização dos botões */
            .btn {
                padding: 0.5rem 1rem;
                /* aumentando o tamanho dos botões */
                font-size: 1rem;
                /* aumentando o tamanho do texto dos botões */
            }

            /* Estilização da tabela */
            .table tbody tr:hover {
                background-color: #f2f2f2;
                /* cor de fundo ao passar o mouse */
            }

            .table th,
            .table td {
                vertical-align: middle;
                /* centralizando conteúdo verticalmente */
            }

            .table th {
                background-color: #55a751;
                /* cor de fundo do cabeçalho */
                color: #fff;
                /* cor do texto do cabeçalho */
            }

            .table th,
            .table td {
                border: 1px solid #dee2e6;
                /* bordas da tabela */
            }

            .table th,
            .table td .btn {
                color: white;
            }

            .table th,
            .table td:last-child {
                text-align: center;
                /* centralizando conteúdo das últimas células */
            }



            /* Estilos da lista de resultados */
            .result-list {
                position: absolute;
                top: calc(100% + 0.5rem);
                /* Posiciona a lista abaixo do input */
                width: calc(100% - 1rem);
                /* Ajusta a largura para coincidir com o input */
                max-width: 25rem;
                background-color: #fff;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                /* Garante que a lista esteja acima de outros elementos */
            }

            .result-item {
                padding: 0.5rem;
                font-size: 1rem;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .result-item:hover {
                background-color: #edf2f7;
            }

            .modal-backdrop.fade.show {
                display: none;
            }

            .btn-logout {
                margin-left: 15px;
                background-color: #f28063;
                color: #fff;
                border-color: transparent;
                border-radius: 5px;
                font-weight: bold;
                padding: 10px 20px;
                display: inline-flex;
                align-items: center;
                transition: background-color 0.3s ease-in-out;
            }

            .btn-logout:hover {
                background-color: #d06b49;
            }

            .align-right {
                float: right;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 header-container">
                    <header class="text-center">
                        <!-- Logo centralizado e barra de pesquisa alinhada à direita -->
                        <div class="d-flex justify-content-between align-items-center">
                            <img src="{{ asset('imgs/logo.png') }}" alt="Logo">
                            <!-- Input -->


                            <a href="{{ route('logout') }}" class="btn btn-logout">
                                <i class="bi bi-box-arrow-right"></i>
                            </a>

                        </div>
                    </header>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 table-container p-4">


                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="input-group search-bar">
                            <input type="text" class="form-control" placeholder="Pesquisar..."
                                wire:model.debounce.500ms="query" wire:keydown.escape="limparQuery"
                                wire:blur="hideResults" />
                            <button class="btn btn-primary" type="button"><i class="bi bi-search"></i></button>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovoUsuario">Novo
                            Usuário</button>
                    </div>

                    <!-- Estilização da tabela -->
                    <div class="table-responsive">



                        <table class="table table-bordered table-hover" id="tabela-users">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th>Idade</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($dados) == 0)


                                    <tr>
                                        <td colspan="5" class="no-data">Nenhum dado disponível</td>
                                    </tr>
                                @else
                                    @foreach ($dados as $dado)
                                        <tr>
                                            <td>{{ $dado->name }}</td>
                                            <td>
                                                @php
                                                    $dataNascimento = \Carbon\Carbon::parse($dado->data_nascimento);
                                                    $idade = $dataNascimento->diffInYears(\Carbon\Carbon::now());
                                                    echo $idade;
                                                @endphp
                                            </td>

                                            <td>{{ $dado->email }}</td>
                                            <td>{{ $dado->telefone }}</td>
                                            <td>
                                                <!-- Botões de ação, como editar, excluir, etc. -->
                                                <button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalVisualizarUsuario" wire:self.ignore
                                                    wire:click="lerUsuario({{ $dado->id }})"><i
                                                        class="bi bi-eye"></i>
                                                </button>


                                                <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditarUsuario"
                                                    data-usuario-id="{{ $dado->id }}" wire:self.ignore
                                                    wire:click="editarUsuario({{ $dado->id }})">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>


                                                <button onclick="confirmarExclusao({{ $dado->id }})"
                                                    class="btn btn-danger">
                                                    <i class="bi bi-trash-fill"></i></button>


                                            </td>
                                        </tr>
                                    @endforeach
                                @endif



                            </tbody>
                        </table>

                        <div class="text-right">
                            <button class="btn btn-primary" wire:click="exportarPdf">Exportar PDF</button>
                            <button class="btn btn-primary" wire:click="exportarCsv">Exportar CSV</button>
                        </div>

                    </div>
                   
                </div>
            </div>

        </div>

    </body>

</div>
