<?php

return [

    'title' => 'Верификујте ја вашата е-пошта',

    'heading' => 'Верификујте ја вашата е-пошта',

    'actions' => [

        'resend_notification' => [
            'label' => 'Испрати повторно',
        ],

    ],

    'messages' => [
        'notification_not_received' => 'Не ја примавте е-поштата што ја испративме?',
        'notification_sent' => 'Испративме е-пошта на :email со инструкции како да ја верификуирате вашата е-пошта.',
    ],

    'notifications' => [

        'notification_resent' => [
            'title' => 'Ја испративме повторно е-поштата.',
        ],

        'notification_resend_throttled' => [
            'title' => 'Поголем број на обиди за испраќање',
            'body' => 'Ве молиме обидете се повторно за :seconds секунди.',
        ],

    ],

];