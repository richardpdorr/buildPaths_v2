<!DOCTYPE html>
<html>
<head>
    <title>Realtime LoL Summoner Lookup</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
            font-family: 'Lato';
        }

        .summoner-lookup-form{
            width:300px;
        }

        .summoner-search-input{
            text-align:center;
        }

        .lookup-helper{
            width:60%;
        }

    </style>
    <script src="{!! asset('js/vendor.js') !!}"></script>
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">
    <script src="{!! asset('js/bootstrap.min.js') !!}"></script>
</head>
<body>
<div class="container">

    <div class="content">
        <div class="title">Summoner Lookup</div>
    </div>

    @if (session('error'))
        <div class="row">
            <div class="alert alert-danger col-md-3 col-md-offset-3">{{ session('error') }}</div>
        </div>
    @endif

    {!! Form::open(['method'=>'POST', 'action'=>'SummonerController@store']) !!}

    {{ csrf_field() }}

    <div class="form-group summoner-lookup-form center-block">
            {!! Form::text('name', null, ['class'=>'form-control summoner-search-input', 'placeholder'=>'Enter Summoner Name']) !!}
        </div>

        <div class="form-group">
        {!! Form::submit('search', ['class'=>'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
</div>
</body>
</html>
