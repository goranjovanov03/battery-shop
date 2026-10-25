<?php

return [

    'label' => 'Навигација за страницирање',

    'overview' => '{1} Приказан 1 резултат|[2,*] Приказани :first до :last од :total резултати',

    'fields' => [

        'records_per_page' => [

            'label' => 'По страница',

            'options' => [
                'all' => 'Сите',
            ],

        ],

    ],

    'actions' => [

        'first' => [
            'label' => 'Прва',
        ],

        'go_to_page' => [
            'label' => 'Иди на страница :page',
        ],

        'last' => [
            'label' => 'Последна',
        ],

        'next' => [
            'label' => 'Следна',
        ],

        'previous' => [
            'label' => 'Претходна',
        ],

    ],

];