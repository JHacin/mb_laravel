<?php

return [
    'home' => '/',
    'login' => '/prijava',
    'register' => '/registracija',
    'forgot_password' => '/geslo/ponastavitev',
    'confirm_password' => '/geslo/potrditev',
    'user_profile' => '/profil',
    'cat_sponsorship_form' => '/muce/{cat}/postani-boter',
    'admin' => [
        'dashboard' => 'dashboard',
        'login' => 'login',
        'users' => 'uporabniki',
        'users_add' => 'uporabniki/create',
        'users_edit' => 'uporabniki/{id}/edit',
        'roles' => 'vloge',
        'permissions' => 'dovoljenja',
        'cats' => 'muce',
        'cats_add' => 'muce/create',
        'cats_edit' => 'muce/{id}/edit',
        'cat_locations' => 'lokacije',
        'cat_locations_add' => 'lokacije/create',
        'cat_locations_edit' => 'lokacije/{id}/edit',
        'sponsorships' => 'botrovanja',
        'sponsorships_add' => 'botrovanja/create',
        'sponsorships_edit' => 'botrovanja/{id}/edit',
        'person_data' => 'neregistrirani-botri',
        'person_data_add' => 'neregistrirani-botri/create',
        'person_data_edit' => 'neregistrirani-botri/{id}/edit',
    ]
];
