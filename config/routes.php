<?php

return [
    'home' => '/',
    'login' => '/prijava',
    'logout' => '/odjava',
    'register' => '/registracija',
    'forgot_password' => '/geslo/ponastavitev',
    'reset_password_form' => '/geslo/ponastavitev/{token}',
    'send_reset_link_email' => '/geslo/email',
    'user_profile' => '/profil',
    'why_become_sponsor' => '/zakaj-postati-boter',
    'cat_list' => '/muce',
    'cat_details' => '/muce/{cat}',
    'cat_sponsorship_form' => '/muce/{cat}/postani-boter',
    'special_sponsorships' => '/posebna-botrstva',
    'gift_sponsorship' => '/podari-botrstvo',
    'news' => '/novice',
    'faq' => '/pravila-in-pogosta-vprasanja',
    'privacy' => '/zasebnost',
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
        'sponsorships_cancel' => 'botrovanja/{sponsorship}/cancel',
        'special_sponsorships' => 'posebna-botrstva',
        'special_sponsorships_add' => 'posebna-botrstva/create',
        'special_sponsorships_edit' => 'posebna-botrstva/{id}/edit',
        'sponsors' => 'botri',
        'sponsors_add' => 'botri/create',
        'sponsors_edit' => 'botri/{id}/edit',
        'sponsor_cancel_all_sponsorships' => 'botri/{personData}/cancel-all-sponsorships',
        'sponsorship_message_types' => 'vrste-pisem',
        'sponsorship_message_types_add' => 'vrste-pisem/create',
        'sponsorship_message_types_edit' => 'vrste-pisem/{id}/edit',
        'sponsorship_messages' => 'pisma',
        'sponsorship_messages_add' => 'pisma/create',
        'get_messages_sent_to_sponsor' => 'pisma/{personData}/get-sent-messages',
        'get_parsed_template_preview' => 'pisma/parsed-template-preview',
        'news' => 'novice',
    ]
];
