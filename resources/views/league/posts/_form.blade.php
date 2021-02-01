<div class="form-group">
    <label for="title" class="form-label col-3 col-form-label">Título</label>
    <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror"
        placeholder="Título do comunicado" value="{{ old('title') || isset($post->title) }}" required>
    @error('title')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="content" class="form-label col-3 col-form-label">Conteúdo</label>
    <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content"
        placeholder="Conteúdo da do comunicado" required>{{ old('content') || isset($post->content) }}</textarea>
    @error('content')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
