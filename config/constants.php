<?php
//file : app/config/constants.php

return [
    'RIOT_API_RESPONSES' => [   '200' => 'Success',
                                '400' => 'Bad Request',
                                '401' => 'Unauthorized',
                                '404' => 'Data not found',
                                '429' => 'Rate limit exceeded',
                                '500' => 'Internal server error',
                                '503' => 'Service unavailable'],

    'RIOT_GAME_MODES' => [  "CLASSIC" => "Classic",
                            "ODIN" => "",
                            "ARAM" => "",
                            "TUTORIAL" => "",
                            "ONEFORALL" => "",
                            "ASCENSION" => "",
                            "FIRSTBLOOD" => "",
                            "KINGPORO" => ""],

    'RIOT_GAME_TYPES' => [  "CUSTOM_GAME" => "",
                            "MATCHED_GAME" => "Matched",
                            "TUTORIAL_GAME" => ""]
];