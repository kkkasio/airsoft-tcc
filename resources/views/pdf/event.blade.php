<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evento: {{$event->name}} </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <h3>{{$event->name}}</h3>
    <h6>Data e horário de Início: {{$event->startdate->format('d/m/y H:m')}}</h6>
    <h6>Local: {{$event->location ? $event->location : 'Não informado' }}</h6>
    @foreach ($event->squads as $squad)
    <p class="text-center lead">SQUAD: {{$squad->name}}</p>
    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th scope="col">Nome</th>
            </tr>
        </thead>
        <tbody>
            @foreach($squad->squadMembers as $member)
            <tr scope="row">
                <td>{{$member->profile->name}} - (<small>{{strtoupper($member->profile->team->team->name)}})</small>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
</body>

</html>
