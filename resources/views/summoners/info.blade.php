<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

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
        }
    </style>
    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <script>
        var summoner_as_json = '{{ json_encode($summoner->toArray()) }}';
        console.log(summoner_as_json);
    </script>
    <script src="{{asset('js/lookupLiveGame.js')}}"></script>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">{{ $summoner->name }}</div>
        <div class="summoner_info">
                Level {{ $summoner->summonerLevel }}


        </div>
        <button id="liveGame">Live Game Info</button>
        <div class="live_game_display"></div>
    </div>
</div>





</body>
</html>
