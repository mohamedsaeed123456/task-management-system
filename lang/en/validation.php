<?php

return [
    'required' => 'The :attribute field is required',
    'email' => 'The :attribute field must be a valid email address',

    'attributes' => [
        'email' => 'the email',
        'password' => 'the password',
    ],
    'custom' => [
        'email' => [
            'required' => 'The email field is required',
        ],
        'password' => [
            'required' => 'The password field is required',
        ],
    ],
];