<div>

    <style>
        /* Estilos de alerta */
        .alert {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            
        }

        .visible {
            display: block;
            z-index: 1000;
        }

        .hidden {
            display: none;
        }

        /* Estilos da caixa de alerta */
        .alert-box {
            border-radius: 0.375rem;
            width: 15rem;
            background-color: #ffffff;
            /* Adicionando cor de fundo */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Adicionando sombra */
        }

        /* Estilos dos botões de fechar */
        .close {
            background-color: transparent;
            border: none;
            cursor: pointer;
            float: right;
            padding: 0.5rem;
        }

        /* Estilos dos textos */
        .alert-box p {
            font-weight: 500;
            padding: 0.5rem;
        }

        /* Estilos dos diferentes tipos de alerta */
        .alert-box.success {
            background-color: #22c55e;
            color: #047857;
        }

        .alert-box.error {
            background-color: #ef4444;
            color: #991b1b;
        }

        .alert-box.info {
            background-color: #60a5fa;
            color: #1e3a8a;
        }

        .close-btn {
            background-color: transparent;
            border: none;
            cursor: pointer;
            float: right;
            font-size: 1.5rem;
            /* Ajuste o tamanho do ícone conforme necessário */
            color: #212529;
            /* Cor do ícone */
            margin: 0;
            padding: 0.25rem 0.5rem;
            /* Espaçamento interno */
            transition: color 0.3s ease;
            /* Transição suave da cor */
        }

        .close-btn:hover {
            color: #ff0000;
            /* Cor do ícone ao passar o mouse */
        }
    </style>

    <div class="alert {{ $alerta ? 'visible' : 'hidden' }}">
    
        <div class="alert-box {{ $alerta == 1 ? 'success' : ($alerta == 2 ? 'error' : 'info') }}">
        
            <button wire:click="fecharAlerta()" class="close-btn">&times;</button>
             <i class="bi bi-circle-exclamation"></i>
            <p>{{ $mensagem }}</p>
        </div>

    </div>

</div>
