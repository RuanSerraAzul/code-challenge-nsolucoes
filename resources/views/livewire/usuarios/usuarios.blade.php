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



                    </div>
                    {{ $dados->links() }}




                </div>
            </div>

            <!-- Modal de Cadastro de Novo Usuário -->
            <div class="modal fade" id="modalNovoUsuario" wire:ignore.self wire:key="modalNovoUsuarioKey" tabindex="-1"
                aria-labelledby="modalNovoUsuarioLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalNovoUsuarioLabel">Novo Usuário</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulário de Cadastro de Novo Usuário -->
                            <form>
                                <!-- Campos do formulário -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nomeCompleto" class="form-label">Nome Completo</label>
                                        <input type="text" class="form-control" wire:model.defer="nomeCompleto"
                                            id="nomeCompleto" placeholder="Digite o nome completo" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cpf" class="form-label">CPF</label>
                                        <input oninput="mascaraCpf(this)" type="text" class="form-control"
                                            maxlength="14" wire:model.defer="cpf" id="cpf"
                                            placeholder="Digite o CPF" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" id="email"
                                            wire:model.defer="email" placeholder="Digite o e-mail" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telefone" class="form-label">Telefone</label>
                                        <input type="tel" class="form-control" id="telefone"
                                            onkeypress="mascara(this, mascaraTelefone);"
                                            onblur="mascara(this, mascaraTelefone);" placeholder="Digite o telefone"
                                            wire:model.defer="telefone" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="cep" class="form-label">CEP</label>
                                        <input type="text" class="form-control" id="cep"
                                            placeholder="Digite o CEP" wire:model.defer="cep"
                                            onkeypress="mascaraCep(this)" maxlength="9" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="endereco" class="form-label">Endereço</label>
                                        <input type="text" class="form-control" id="endereco"
                                            wire:model.defer="endereco" placeholder="Digite o endereço" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="numero" class="form-label">Número</label>
                                        <input type="text" class="form-control" id="numero"
                                            wire:model.defer="numero" placeholder="Digite o número" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="complemento" class="form-label">Complemento</label>
                                        <input type="text" class="form-control" id="complemento"
                                            wire:model.defer="complemento" placeholder="Digite o complemento">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="bairro" class="form-label">Bairro</label>
                                        <input type="text" class="form-control" id="bairro"
                                            wire:model.defer="bairro" placeholder="Digite o bairro" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cidade" class="form-label">Cidade</label>
                                        <input type="text" class="form-control" id="cidade"
                                            wire:model.defer="cidade" placeholder="Digite a cidade" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select id="estado"class="form-control" id="estado"
                                            wire:model.defer="estado" placeholder="Digite o estado" required>
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amapá</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PR">Paraná</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                            <option value="EX">Estrangeiro</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dataNascimento" class="form-label">Data de Nascimento</label>
                                        <input type="date" class="form-control" id="dataNascimento"
                                            wire:model.defer="dataNascimento" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="button" id="btnSalvar"wire:click="salvarUsuario"
                                class="btn btn-primary">Salvar</button>

                        </div>
                    </div>
                </div>
            </div>





            <!-- Modal de Edição de Usuário -->
            <div class="modal fade" id="modalEditarUsuario" wire:ignore.self tabindex="-1"
                aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">

                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuário</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulário de Edição de Usuário -->
                            @if ($usuarioParaEditar)
                                <form id="formEditarUsuario" wire:submit.prevent="atualizarUsuario">
                                    <!-- Campos do formulário preenchidos com os dados do usuário -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="nomeCompleto" class="form-label">Nome Completo</label>
                                            <input type="text" class="form-control" id="nomeCompletoEditar"
                                                value ="{{ $usuarioParaEditar->name }}"
                                                wire:model='usuarioParaEditar.name'
                                                placeholder="Digite o nome completo" required>


                                        </div>
                                        <div class="col-md-6">
                                            <label for="cpf" class="form-label">CPF</label>
                                            <input type="text" class="form-control" id="cpfEditar"
                                                oninput="mascaraCpf(this)" maxlength="14"
                                                value ="{{ $usuarioParaEditar->cpf }}"
                                                wire:model='usuarioParaEditar.cpf' placeholder="Digite o CPF"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input type="email" class="form-control" id="emailEditar"
                                                value ="{{ $usuarioParaEditar->email }}"
                                                wire:model='usuarioParaEditar.email' placeholder="Digite o e-mail"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="telefone" class="form-label">Telefone</label>
                                            <input type="tel" class="form-control" id="telefoneEditar"
                                                value ="{{ $usuarioParaEditar->telefone }}"
                                                wire:model='usuarioParaEditar.telefone'
                                                placeholder="Digite o telefone" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="cep" class="form-label">CEP</label>
                                            <input type="text" class="form-control" id="cepEditar"
                                                value ="{{ $usuarioParaEditar->cep }}"
                                                wire:model='usuarioParaEditar.cep' placeholder="Digite o CEP"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="endereco" class="form-label">Endereço</label>
                                            <input type="text" class="form-control" id="enderecoEditar"
                                                value ="{{ $usuarioParaEditar->endereco }}"
                                                wire:model='usuarioParaEditar.endereco'
                                                placeholder="Digite o endereço" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="numero" class="form-label">Número</label>
                                            <input type="text" class="form-control" id="numeroEditar"
                                                value ="{{ $usuarioParaEditar->numero }}"
                                                wire:model='usuarioParaEditar.numero' placeholder="Digite o número"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="complemento" class="form-label">Complemento</label>
                                            <input type="text" class="form-control" id="complementoEditar"
                                                value ="{{ $usuarioParaEditar->complemento }}"
                                                wire:model='usuarioParaEditar.complemento'
                                                placeholder="Digite o complemento">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="bairro" class="form-label">Bairro</label>
                                            <input type="text" class="form-control" id="bairroEditar"
                                                value ="{{ $usuarioParaEditar->bairro }}"
                                                wire:model='usuarioParaEditar.bairro' placeholder="Digite o bairro"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cidade" class="form-label">Cidade</label>
                                            <input type="text" class="form-control" id="cidadeEditar"
                                                value ="{{ $usuarioParaEditar->cidade }}"
                                                wire:model='usuarioParaEditar.cidade' placeholder="Digite a cidade"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="estado" class="form-label">Estado</label>
                                            <select class="form-control" id="estadoEditar" required
                                                wire:model='usuarioParaEditar.estado'>
                                                <option value="AC"
                                                    {{ $usuarioParaEditar->estado == 'AC' ? 'selected' : '' }}>Acre
                                                </option>
                                                <option value="AL"
                                                    {{ $usuarioParaEditar->estado == 'AL' ? 'selected' : '' }}>Alagoas
                                                </option>
                                                <option value="AP"
                                                    {{ $usuarioParaEditar->estado == 'AP' ? 'selected' : '' }}>Amapá
                                                </option>
                                                <option value="AM"
                                                    {{ $usuarioParaEditar->estado == 'AM' ? 'selected' : '' }}>Amazonas
                                                </option>
                                                <option value="BA"
                                                    {{ $usuarioParaEditar->estado == 'BA' ? 'selected' : '' }}>Bahia
                                                </option>
                                                <option value="CE"
                                                    {{ $usuarioParaEditar->estado == 'CE' ? 'selected' : '' }}>Ceará
                                                </option>
                                                <option value="DF"
                                                    {{ $usuarioParaEditar->estado == 'DF' ? 'selected' : '' }}>Distrito
                                                    Federal
                                                </option>
                                                <option value="ES"
                                                    {{ $usuarioParaEditar->estado == 'ES' ? 'selected' : '' }}>Espírito
                                                    Santo
                                                </option>
                                                <option value="GO"
                                                    {{ $usuarioParaEditar->estado == 'GO' ? 'selected' : '' }}>Goiás
                                                </option>
                                                <option value="MA"
                                                    {{ $usuarioParaEditar->estado == 'MA' ? 'selected' : '' }}>Maranhão
                                                </option>
                                                <option value="MT"
                                                    {{ $usuarioParaEditar->estado == 'MT' ? 'selected' : '' }}>Mato
                                                    Grosso</option>
                                                <option value="MS"
                                                    {{ $usuarioParaEditar->estado == 'MS' ? 'selected' : '' }}>Mato
                                                    Grosso do Sul
                                                </option>
                                                <option value="MG"
                                                    {{ $usuarioParaEditar->estado == 'MG' ? 'selected' : '' }}>Minas
                                                    Gerais
                                                </option>
                                                <option value="PA"
                                                    {{ $usuarioParaEditar->estado == 'PA' ? 'selected' : '' }}>Pará
                                                </option>
                                                <option value="PB"
                                                    {{ $usuarioParaEditar->estado == 'PB' ? 'selected' : '' }}>Paraíba
                                                </option>
                                                <option value="PR"
                                                    {{ $usuarioParaEditar->estado == 'PR' ? 'selected' : '' }}>Paraná
                                                </option>
                                                <option value="PE"
                                                    {{ $usuarioParaEditar->estado == 'PE' ? 'selected' : '' }}>
                                                    Pernambuco
                                                </option>
                                                <option value="PI"
                                                    {{ $usuarioParaEditar->estado == 'PI' ? 'selected' : '' }}>Piauí
                                                </option>
                                                <option value="RJ"
                                                    {{ $usuarioParaEditar->estado == 'RJ' ? 'selected' : '' }}>Rio de
                                                    Janeiro
                                                </option>
                                                <option value="RN"
                                                    {{ $usuarioParaEditar->estado == 'RN' ? 'selected' : '' }}>Rio
                                                    Grande do Norte
                                                </option>
                                                <option value="RS"
                                                    {{ $usuarioParaEditar->estado == 'RS' ? 'selected' : '' }}>Rio
                                                    Grande do Sul
                                                </option>
                                                <option value="RO"
                                                    {{ $usuarioParaEditar->estado == 'RO' ? 'selected' : '' }}>Rondônia
                                                </option>
                                                <option value="RR"
                                                    {{ $usuarioParaEditar->estado == 'RR' ? 'selected' : '' }}>Roraima
                                                </option>
                                                <option value="SC"
                                                    {{ $usuarioParaEditar->estado == 'SC' ? 'selected' : '' }}>Santa
                                                    Catarina
                                                </option>
                                                <option value="SP"
                                                    {{ $usuarioParaEditar->estado == 'SP' ? 'selected' : '' }}>São
                                                    Paulo
                                                </option>
                                                <option value="SE"
                                                    {{ $usuarioParaEditar->estado == 'SE' ? 'selected' : '' }}>Sergipe
                                                </option>
                                                <option
                                                    value="TO"{{ $usuarioParaEditar->estado == 'TO' ? 'selected' : '' }}>
                                                    Tocantins
                                                </option>
                                                <option value="EX"
                                                    {{ $usuarioParaEditar->estado == 'EX' ? 'selected' : '' }}>
                                                    Estrangeiro
                                                </option>
                                            </select>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="dataNascimento" class="form-label">Data de Nascimento</label>
                                            @if ($editando)
                                                <input type="date" class="form-control" id="dataNascimentoEditar"
                                                    value="{{ $usuarioParaEditar->data_nascimento ? \Carbon\Carbon::parse($usuarioParaEditar->data_nascimento)->format('Y-m-d') : '' }}"
                                                    required>
                                            @else
                                                <input type="date" class="form-control" id="dataNascimentoEditar"
                                                    wire:model.defer="usuarioParaEditar.data_nascimento" required>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Botões de ação -->
                                    <div class="modal-footer">
                                        <button type="button" id="btnFecharEditar" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fechar</button>
                                        <button type="button" id="btnEditar" class="btn btn-primary">Salvar</button>

                                    </div>
                                </form>
                            @else
                                <!-- Exibe um loader enquanto os dados estão sendo carregados -->
                                <div class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Carregando...</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Leitura de Usuário -->
            <div class="modal fade" id="modalVisualizarUsuario" wire:ignore.self tabindex="-1"
                aria-labelledby="modalVisualizarUsuarioLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="modalVisualizarUsuarioLabel">Visualizar Usuário</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>


                        <div class="modal-body">
                            @if ($usuarioParaVisualizar)
                                <!-- Campos de leitura dos dados do usuário -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nomeCompleto" class="form-label">Nome Complet:</label>
                                        <p>{{ $usuarioParaVisualizar->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cpf" class="form-label">CPF:</label>
                                        <p>{{ $usuarioParaVisualizar->cpf }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">E-mail:</label>
                                        <p>{{ $usuarioParaVisualizar->email }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telefone" class="form-label">Telefone:</label>
                                        <p>{{ $usuarioParaVisualizar->telefone }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="cep" class="form-label">CEP:</label>
                                        <p>{{ $usuarioParaVisualizar->cep }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="endereco" class="form-label">Endereço:</label>
                                        <p>{{ $usuarioParaVisualizar->endereco }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="numero" class="form-label">Número:</label>
                                        <p>{{ $usuarioParaVisualizar->numero }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="complemento" class="form-label">Complemento:</label>
                                        <p>{{ $usuarioParaVisualizar->complemento }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="bairro" class="form-label">Bairro:</label>
                                        <p>{{ $usuarioParaVisualizar->bairro }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cidade" class="form-label">Cidade:</label>
                                        <p>{{ $usuarioParaVisualizar->cidade }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="estado" class="form-label">Estado:</label>
                                        <p>{{ $usuarioParaVisualizar->estado }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dataNascimento" class="form-label">Data de Nascimento:</label>
                                        <p>{{ \Carbon\Carbon::parse($usuarioParaVisualizar->data_nascimento)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function mascaraCpf(i) {

                var v = i.value;

                if (isNaN(v[v.length - 1])) { // impede entrar outro caractere que não seja número
                    i.value = v.substring(0, v.length - 1);
                    return;
                }

                i.setAttribute("maxlength", "14");
                if (v.length == 3 || v.length == 7) i.value += ".";
                if (v.length == 11) i.value += "-";

            }

            function mascara(o, f) {
                setTimeout(function() {
                    var v = mascaraTelefone(o.value);
                    if (v != o.value) {
                        o.value = v;
                    }
                }, 1);
            }

            function mascaraTelefone(v) {
                var r = v.replace(/\D/g, "");
                r = r.replace(/^0/, "");
                if (r.length > 10) {
                    r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
                } else if (r.length > 5) {
                    r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
                } else if (r.length > 2) {
                    r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
                } else {
                    r = r.replace(/^(\d*)/, "($1");
                }
                return r;
            }

            function mascaraCep(cep) {
                if (cep.value.length == 5) {
                    cep.value = cep.value + '-'
                }
            }

            $(document).ready(function() {
                // Evento de clique no botão "Salvar"
                $('#modalNovoUsuario').on('click', '.btn-primary', function() {
                    var cpf = $('#cpf').val(); // Obtém o valor do campo CPF

                    // Faz a requisição AJAX
                    $.ajax({
                        url: '/api/v1/validaCPF/' + cpf,
                        type: 'GET',
                        success: function(response) {
                            // Verifica se o CPF é válido ou não
                            if (response.success) {
                                alert('CPF válido');

                            } else {
                                alert('CPF inválido');
                            }
                        },
                        error: function() {
                            alert('Erro ao validar CPF');
                        }
                    });
                });
            });


            $(document).ready(function() {
                // Evento de clique no botão "Salvar"
                $(document).on('click', '#btnEditar', function() {
                    var cpf = $('#cpfEditar').val(); // Obtém o valor do campo CPF
                    // Faz a requisição AJAX
                    $.ajax({
                        url: '/api/v1/validaCPF/' + cpf,
                        type: 'GET',
                        success: function(response) {
                            // Verifica se o CPF é válido ou não
                            if (response.success) {
                                Livewire.emit('atualizarUsuario');
                            } else {
                                // Exibe mensagem de erro
                                alert('CPF inválido. Por favor, insira um CPF válido.');
                            }
                        },
                        error: function() {
                            alert('Erro ao validar CPF');
                        }
                    });
                });
            });



            $(document).ready(function() {
                // Função para verificar se todos os campos obrigatórios estão preenchidos no modal de criação
                function verificarCamposCriacao() {
                    var camposPreenchidos = true;
                    $('#modalNovoUsuario input[required]').each(function() {
                        if (!$(this).val().trim()) {
                            camposPreenchidos = false;
                            return false; // Termina o loop assim que encontrar um campo vazio
                        }
                    });
                    // Desabilita ou habilita o botão de acordo com o estado dos campos
                    $('#btnSalvar').prop('disabled', !camposPreenchidos);
                }

                // Chama a função verificarCamposCriacao quando os campos são alterados
                $('#modalNovoUsuario input[required]').on('input', verificarCamposCriacao);

                // Chama a função verificarCamposCriacao quando o modal é exibido
                $('#modalNovoUsuario').on('shown.bs.modal', function() {
                    verificarCamposCriacao();
                });

                // Evento de clique no botão "Salvar" do modal de criação
                $('#modalNovoUsuario').on('click', '.btn-primary', function() {
                    // Verifica se todos os campos obrigatórios estão preenchidos antes de enviar o formulário
                    return $('#modalNovoUsuario input:invalid').length === 0;
                });
            });


            $(document).ready(function() {
                // Função para verificar se todos os campos obrigatórios estão preenchidos no modal de edição
                function verificarCamposEdicao() {
                    var camposPreenchidos = true;
                    $('#modalEditarUsuario input[required]').each(function() {
                        if (!$(this).val().trim()) {
                            camposPreenchidos = false;
                            return false; // Termina o loop assim que encontrar um campo vazio
                        }
                    });
                    // Desabilita ou habilita o botão de acordo com o estado dos campos
                    $('#btnEditar').prop('disabled', !camposPreenchidos);
                }

                // Chama a função verificarCamposEdicao quando os campos são alterados
                $('#modalEditarUsuario input[required]').on('input', verificarCamposEdicao);

                // Chama a função verificarCamposEdicao quando o modal é exibido
                $('#modalEditarUsuario').on('shown.bs.modal', function() {
                    verificarCamposEdicao();
                });

                // Evento de clique no botão "Salvar" do modal de edição
                $('#modalEditarUsuario').on('click', '.btn-primary', function() {
                    // Verifica se todos os campos obrigatórios estão preenchidos antes de enviar o formulário
                    return $('#modalEditarUsuario input:invalid').length === 0;
                });

                // Chama a função verificarCamposEdicao quando o conteúdo do modal é alterado (por exemplo, ao carregar)
                $('#modalEditarUsuario').on('change', function() {
                    verificarCamposEdicao();
                });
            });

            function confirmarExclusao(id) {
                if (confirm('Tem certeza que deseja excluir o usuário?')) {
                    Livewire.emit('confirm-delete', id);
                }
            }
        </script>

        <!-- datatables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>



    </body>

</div>
