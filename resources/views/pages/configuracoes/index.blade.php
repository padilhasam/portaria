@extends('layouts.dashboard')

@section('page_dashboard')

{{-- ======================== Cabeçalho ======================== --}}
<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
        {{-- Título --}}
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
            <span class="icon-container d-flex align-items-center justify-content-center"
                  style="width: 36px; height: 36px; background: linear-gradient(135deg, #0d6efd, #0a58ca); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white"
                     class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                          d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                </svg>
            </span>
            Configurações
        </h3>
    </div>
</header>

{{-- Mensagens de sucesso e erros --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm p-4">

    {{-- Configurações de Perfil --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">Dados do Usuário</div>
        <div class="card-body">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">👤 Configurações de Perfil</h5>

                    <form action="{{ route('perfil.update.configuracao') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Foto --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto de Perfil</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImagem(event)">

                            <div class="mt-2">
                                <img id="preview"
                                     src="{{ auth()->user()->foto_url }}"
                                     style="height: 80px; border-radius: 50%;">
                            </div>
                        </div>

                        {{-- Nome / Email / Senha --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome</label>
                            <input type="text" name="nome" class="form-control" value="{{ old('nome', auth()->user()->nome) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">E-mail</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nova Senha</label>
                            <input type="password" name="password" class="form-control" placeholder="Deixe em branco para não alterar">
                        </div>

                        {{-- Preferências --}}
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="tema_escuro" class="form-check-input" id="tema_escuro"
                                {{ old('tema_escuro', auth()->user()->tema_escuro ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tema_escuro">Ativar tema escuro</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Idioma</label>
                            <select name="idioma" class="form-select">
                                <option value="pt" {{ old('idioma', auth()->user()->idioma ?? 'pt') == 'pt' ? 'selected' : '' }}>Português</option>
                                <option value="en" {{ old('idioma', auth()->user()->idioma ?? '') == 'en' ? 'selected' : '' }}>Inglês</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Salvar Perfil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Configurações do Sistema (somente admin) --}}
    @can('isAdmin')
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <h5 class="fw-bold mb-4">🛠️ Configurações do Sistema</h5>

            <form action="{{ route('sistema.update.configuracao') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nome / Email / Logo --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nome do Sistema</label>
                    <input type="text" name="nome_sistema" class="form-control" value="{{ old('nome_sistema', $config->nome_sistema ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email de Contato</label>
                    <input type="email" name="email_contato" class="form-control" value="{{ old('email_contato', $config->email_contato ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Logo do Sistema</label>
                    <input type="file" name="logo" class="form-control" accept="image/*">
                    @if(!empty($config->logo))
                        <img src="{{ asset('storage/'.$config->logo) }}" alt="Logo atual" class="mt-2" style="height: 50px;">
                    @endif
                </div>

                {{-- Avançado --}}

                <hr class="my-4">

                <h6 class="fw-bold text-secondary">🔐 Segurança</h6>
                <div class="mb-3">
                    <label class="form-label">Tentativas de login antes do bloqueio</label>
                    <input type="number" name="tentativas_bloqueio" class="form-control" min="1" max="10" value="{{ old('tentativas_bloqueio', $config->tentativas_bloqueio ?? 5) }}">
                </div>

                <h6 class="fw-bold text-secondary">📣 Notificações</h6>
                <div class="mb-3">
                    <label class="form-label">Canal de envio padrão</label>
                    <select name="canal_notificacao_padrao" class="form-select">
                        <option value="painel" {{ old('canal_notificacao_padrao', $config->canal_notificacao_padrao ?? '') == 'painel' ? 'selected' : '' }}>Painel</option>
                        <option value="email" {{ old('canal_notificacao_padrao', $config->canal_notificacao_padrao ?? '') == 'email' ? 'selected' : '' }}>E-mail</option>
                        <option value="whatsapp" {{ old('canal_notificacao_padrao', $config->canal_notificacao_padrao ?? '') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                    </select>
                </div>

                <h6 class="fw-bold text-secondary">👥 Visitantes</h6>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="exigir_confirmacao_visitante" class="form-check-input" id="exigir_confirmacao_visitante"
                        {{ old('exigir_confirmacao_visitante', $config->exigir_confirmacao_visitante ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="exigir_confirmacao_visitante">Exigir confirmação do morador para visitantes</label>
                </div>

                <h6 class="fw-bold text-secondary">📷 Integrações</h6>
                <div class="mb-3">
                    <label class="form-label">URL da API das Câmeras</label>
                    <input type="url" name="url_api_cameras" class="form-control" value="{{ old('url_api_cameras', $config->url_api_cameras ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Token da API (se necessário)</label>
                    <input type="text" name="token_api_cameras" class="form-control" value="{{ old('token_api_cameras', $config->token_api_cameras ?? '') }}">
                </div>

                <h6 class="fw-bold text-secondary">🧾 Logs e Auditoria</h6>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="log_atividades" class="form-check-input" id="log_atividades"
                        {{ old('log_atividades', $config->log_atividades ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="log_atividades">Ativar log completo de atividades</label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tempo para manter logs (dias)</label>
                    <select name="dias_manutencao_logs" class="form-select">
                        <option value="30" {{ old('dias_manutencao_logs', $config->dias_manutencao_logs ?? '') == 30 ? 'selected' : '' }}>30 dias</option>
                        <option value="60" {{ old('dias_manutencao_logs', $config->dias_manutencao_logs ?? '') == 60 ? 'selected' : '' }}>60 dias</option>
                        <option value="90" {{ old('dias_manutencao_logs', $config->dias_manutencao_logs ?? '') == 90 ? 'selected' : '' }}>90 dias</option>
                    </select>
                </div>

                <h6 class="fw-bold text-secondary">📬 Relatórios</h6>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="exportar_relatorio_automatico" class="form-check-input" id="exportar_relatorio_automatico"
                        {{ old('exportar_relatorio_automatico', $config->exportar_relatorio_automatico ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="exportar_relatorio_automatico">Exportar relatórios automaticamente por e-mail</label>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Salvar Configurações do Sistema</button>
                </div>
            </form>
        </div>
    </div>
    @endcan

</div>

{{-- Preview da imagem --}}
@push('scripts')
<script>
    function previewImagem(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>
@endpush

@endsection
