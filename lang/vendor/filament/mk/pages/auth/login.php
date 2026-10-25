<?php

return [

    'title' => 'Најава',

    'heading' => 'Најави се',

    'actions' => [

        'register' => [
            'before' => 'или',
            'label' => 'регистрирај се за сметка',
        ],

        'request_password_reset' => [
            'label' => 'Ја заборавивте лозинката?',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'Е-пошта',
        ],

        'password' => [
            'label' => 'Лозинка',
        ],

        'remember' => [
            'label' => 'Запомни ме',
        ],

        'actions' => [

            'authenticate' => [
                'label' => 'Најави се',
            ],

        ],

    ],

    'messages' => [

        'failed' => 'Понудените кредиденцијали не се совпаѓаат со нашите записи.',

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Поголем број на обиди за најава',
            'body' => 'Ве молиме обидете се повторно за :seconds секунди.',
        ],

    ],

];