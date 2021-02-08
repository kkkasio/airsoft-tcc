<div class="form-group">
    <label for="name" class="form-label col-3 col-form-label">Nome do time</label>
    <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror"
        placeholder="Nome do time" value="{{ old('name') || isset($team->name) ? $team->name : ''}}" required>
    @error('title')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="slug" class="form-label col-3 col-form-label">Slug (url na plataforma)</label>
    <div class="input-group input-group-flat">
        <span class="input-group-text">
            https://localhost.com/time/
        </span>
        <input type="text" id="slug" name="slug" value="{{ old('slug') || isset($team->slug) ? $team->slug : '' }}"
            class="form-control @error('slug') is-invalid @enderror ps-1" autocomplete="off" {{isset($team->slug) ? 'disabled' : ''}} required>

        @error('slug')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    @if(isset($team->slug))
    <div class="form-check-label">Você não pode alterar esse campo</div>
    @endif
</div>

<div class="form-group">
    <label for="about" class="form-label col-3 col-form-label">Sobre o time</label>
    <textarea id="about" class="form-control @error('about') is-invalid @enderror" name="about"
        placeholder="Conte um pouco da história do time"
        required>{{ old('about') || isset($team->about) ? $team->about : '' }}</textarea>
    @error('about')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
