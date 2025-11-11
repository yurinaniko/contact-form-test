<?php

use Laravel\Fortify\Features;

return [
    /*
    |--------------------------------------------------------------------------
    | Fortify Home Path
    |--------------------------------------------------------------------------
    |
    | This is the path where users will be redirected after they log in or
    | register successfully. You may change this value to redirect users
    | anywhere within your application.
    |
    */

    'home' => '/admin',

    /*
    |--------------------------------------------------------------------------
    | Fortify Guard
    |--------------------------------------------------------------------------
    |
    | Here you may specify which authentication guard Fortify will use while
    | authenticating users. This value should correspond with one of your
    | guards that is already present in your "auth" configuration file.
    |
    */
    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Fortify Password Broker
    |--------------------------------------------------------------------------
    |
    | Here you may specify which password broker Fortify can use when a user
    | is resetting their password. This configured value should match one
    | of your password brokers setup in your "auth" configuration file.
    |
    */
    'passwords' => 'users',

    /*
    |--------------------------------------------------------------------------
    | Fortify Views
    |--------------------------------------------------------------------------
    |
    | This value determines whether Fortify should load its own views when
    | rendering login and registration screens. If you disable this option,
    | you may need to manually define routes and views.
    |
    */
    'views' => true,

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | Some of the features provided by Fortify are optional. You may disable
    | the features you do not need by removing them from this array.
    |
    */
    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
    ],
];
