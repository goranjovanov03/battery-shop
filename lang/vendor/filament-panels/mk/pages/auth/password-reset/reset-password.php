<?php

return [

    'title' => 'Ресетирајте ја вашата лозинка',

    'heading' => 'Ресетирајте ја вашата лозинка',

    'form' => [

        'email' => [
            'label' => 'Е-пошта',
        ],

        'password' => [
            'label' => 'Лозинка',
            'validation_attribute' => 'лозинка',
        ],

        'password_confirmation' => [
            'label' => 'Потврдете лозинка',
        ],

        'actions' => [

            'reset' => [
                'label' => 'Ресетирај лозинка',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Поголем број на обиди за ресетирање',
            'body' => 'Ве молиме обидете се повторно за :seconds секунди.',
        ],

    ],

];