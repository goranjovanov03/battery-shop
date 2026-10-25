<?php

return [

    'title' => 'Регистрација',

    'heading' => 'Регистрирај се',

    'actions' => [

        'login' => [
            'before' => 'или',
            'label' => 'најави се во својата сметка',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'Е-пошта',
        ],

        'name' => [
            'label' => 'Име',
        ],

        'password' => [
            'label' => 'Лозинка',
            'validation_attribute' => 'лозинка',
        ],

        'password_confirmation' => [
            'label' => 'Потврдете лозинка',
        ],

        'actions' => [

            'register' => [
                'label' => 'Регистрирај се',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Поголем број на обиди за регистрација',
            'body' => 'Ве молиме обидете се повторно за :seconds секунди.',
        ],

    ],

];