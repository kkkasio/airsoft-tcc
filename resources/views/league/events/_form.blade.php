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
        <label for="avatar" class="form-label">Foto</label>
        <input type="file" id="avatar" name="avatar" class="form-control @error('avatar') is-invalid @enderror">
        @error('avatar')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>



</div>

<div class="form-group">
    <div class="mb-3">
        <label for="startdate" class="form-label col-3 col-form-label">Data e hora de início</label>
        <input type="datetime-local" id="startdate" name="startdate"
            class="form-control @error('startdate') is-invalid @enderror"
            value="{{old('startdate') || '2000-01-01 00:00' }}" autocomplete="off" required>

        @error('startdate')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group">
    <div class="mb-3">
        <label for="enddate" class="form-label col-3 col-form-label">Data e hora de encerramento</label>
        <input type="datetime-local" id="enddate" name="enddate"
            class="form-control @error('enddate') is-invalid @enderror"
            value="{{old('enddate') || '2000-01-01 00:00' }}" autocomplete="off" required>

        @error('enddate')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>


<div class="form-group">
    <div class="mb-3">
        <label for="players" class="form-label col-3 col-form-label">Mínimo de Jogadores</label>
        <input type="number" id="players" name="players" value="{{old('players')}}"
            class="form-control @error('players') is-invalid @enderror" required>

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
            placeholder="Breve descrição sobre o evento..">{{old('about')}}</textarea>

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
        @error('status')
        <span class="" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group">
    <div class="mb-3">
        <label for="time" class="form-label">Organização</label>
        <select id="time" name="time" class="form-select">
            <option value="0">Administração</option>
            @foreach ($teams as $team)
            <option value="{{$team->team->id}}">{{$team->team->name}}</option>
            @endforeach
        </select>
        @error('time')
        <span class="" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group">
    <div class="mb-3">
        <label for="file" class="form-label col-3 col-form-label">PDF da Missão</label>
        <input type="file" id="file" name="file" class="form-control @error('file') is-invalid @enderror">

        @error('file')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
