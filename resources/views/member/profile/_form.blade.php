<div class="form-group">
    <label for="name" class="form-label col-3 col-form-label">Seu nome</label>
    <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror"
        placeholder="Seu nome" value="{{ old('name') || $profile->name ? $profile->name : ''}}" required>
    @error('title')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>


<div class="form-group">
    <label for="nickname" class="rm-label col-3 col-form-label">Apelido no airsoft</label>
    <input id="nickname" type="text" name="nickname"
        value="{{ old('nickname') || $profile->nickname ? $profile->nickname : ''}}"
        class="form-control @error('nickname') is-invalid @enderror" placeholder="Como você é conhecido no arisoft?"
        autocomplete="off" required>
    @error('nickname')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group">
    <label class="rm-label col-3 col-form-label">Data de Nascimento</label>
    <input type="text" name="birthday" required class="form-control @error('birthday') is-invalid @enderror"
        data-mask="00/00/0000"
        value={{ old('birthday') || $profile->birthday ? date('d/m/Y', strtotime($profile->birthday)) : '' }}
        data-mask-visible="true" placeholder="00/00/0000" value="{{ old('birthday') }}" autocomplete="off">
    @error('birthday')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="avatar" class="form-label col-3 col-form-label">Foto</label>
    <input type="file" id="avatar" name="avatar" accept="image/jpg, image/jpeg, image/png" class="form-control @error('avatar') is-invalid @enderror">
    @error('avatar')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

</div>

<div class="form-group">
    <div class="rm-label col-3 col-form-label">Selecione seu Gênero</div>
    <div>
        <label class="form-check form-check-inline">
            <input class="form-check-input" name="gender" value="F" type="radio"
                {{$profile->gender === 'F' ? 'checked': ''}}>
            <span class="form-check-label">Feminino</span>
        </label>
        <label class="form-check form-check-inline">
            <input class="form-check-input" name="gender" value="M" type="radio"
                {{$profile->gender === 'M' ? 'checked': ''}}>
            <span class="form-check-label">Masculino</span>
        </label>

    </div>
</div>

<div class="form-group">
    <div class="rm-label col-3 col-form-label">Selecione um estado</div>
    <select name="estado" required class="form-select @error('estado') is-invalid @enderror">
        @foreach ($states as $state)
        <option value="{{$state->id}}" {{$profile->state_id === $state->id ? 'selected':''}}>{{$state->title}}</option>

        @endforeach

    </select>
    @error('estado')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group">
    <div class="rm-label col-3 col-form-label">Selecione a cidade</div>
    <select name="cidade" required class="form-select @error('cidade') is-invalid @enderror">
        @foreach ($cities as $city)
        <option value="{{$city->id}}" {{$profile->city_id === $city->id ? 'selected':''}}>{{$city->title}}</option>
        @endforeach
    </select>
    @error('cidade')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>


<div class="form-group">
    <label for="slug" class="form-label col-3 col-form-label">Slug (url na plataforma)</label>
    <div class="input-group input-group-flat">
        <span class="input-group-text">
            https://localhost.com/membro/
        </span>
        <input type="text" id="slug" name="slug" value="{{ old('slug') || $profile->slug ? $profile->slug : '' }}"
            class="form-control @error('slug') is-invalid @enderror ps-1" autocomplete="off"
            <?php echo $profile->slug ? 'disabled': '' ?> required>

        @error('slug')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    @if($profile->slug)
    <div class="form-check-label">Você não pode alterar esse campo</div>
    @endif
</div>

<script>
    $('select[name=estado]').change(function () {
            var idEstado = $(this).val();
            $.get('/get-cidades/' + idEstado, function (cidades) {
                console.log(cidades)
                $('select[name=cidade]').empty();
                $.each(cidades, function (key, value) {
                    $('select[name=cidade]').append('<option value=' + value.id + '>' + value.title + '</option>');
                });
            });
        });


</script>
