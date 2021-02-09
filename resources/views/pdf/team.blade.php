<link rel="stylesheet" href="{{ public_path('css/tabler.css') }}">

<title>Membros do Time</title>
<style>
    .page-break {
        page-break-after: always;
    }

</style>
<p class="text-center text-success text-uppercase">Membros do time</p>
<table class="table table-vcenter card-table">
    <tr>
        <td>Nome</td>
        <td>Permissão</td>
        <td>Time</td>
    </tr>
    @foreach ($members as $member)
    <tr>
        <td>{{$member->profile->name}}</td>
        <td>{{$member->type}}</td>
        <td>{{$member->team->name}}</td>
    </tr>
    @endforeach
</table>
