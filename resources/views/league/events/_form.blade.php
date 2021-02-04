<div class="form-group">
    <div class="mb-3">
        <label for="name" class="form-label col-3 col-form-label">Nome da missão</label>
        <input type="text" id="name" name="name" value="{{old('name')}}"
            class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>

<div class="form-group">
    <div class="mb-3">
        <label for="date" class="form-label col-3 col-form-label">Data</label>
        <input type="text" id="data" name="date" class="form-control @error('data') is-invalid @enderror"
            data-mask="00/00/0000" data-mask-visible="true" value="{{old('date')}}" placeholder="00/00/0000"
            autocomplete="off" required>

        @error('data')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>


<div class="form-group">
    <div class="mb-3">
        <label for="players" class="form-label col-3 col-form-label">Mínimo de Jogadores</label>
        <input type="number" id="players" name="players" class="form-control @error('players') is-invalid @enderror"
            required>

        @error('players')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group">
    <div class="mb-3">
        <label for="about" class="form-label col-3 col-form-label">Sobre o jogo</label>
        <textarea id="about" name="about" class="form-control" name="example-textarea-input" rows="6"
            placeholder="Breve descrição sobre o evento.."></textarea>

        @error('about')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group">
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-select">
            <option value="Aberto">Aberto</option>
            <option value="Planejado">Planejado</option>
            <option value="Encerrado">Encerrado</option>
        </select>
    </div>
</div>

<div class="form-group">
    <div class="mb-3">
        <label for="status" class="form-label">Organização</label>
        <select id="status" name="status" class="form-select">
            <option value="ADM">Administração</option>
            @foreach ($teams as $team)
            <option value="{{$team->team->id}}">{{$team->team->name}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <div class="mb-3">
        <label for="file" class="form-label col-3 col-form-label">PDF da Missão</label>
        <input type="file" id="file" name="file" class="form-control @error('file') is-invalid @enderror">

        @error('title')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
