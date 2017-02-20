$(document).ready(function() {
    $('#liveGame').click(function () {

        var decoded_json = $('<textarea />').html(json_w_html_entities).text();
        var obj_from_json = JSON.parse(decoded_json);
        var active_game_url = "/active/game";

        $.ajax({
            type: "POST",
            url: active_game_url,
            data: {"id":obj_from_json.summoner_id},
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    });
});
