<?php

return [

    /*
    |--------------------------------------------------------------------------
    | data_base_dir
    |--------------------------------------------------------------------------
    |
    | Defines the base directory for absolute path calculation.
    |
    */

    'data_base_dir' => '/var/ftp-data',


    /*
    |--------------------------------------------------------------------------
    | Domain Separator
    |--------------------------------------------------------------------------
    |
    | Defines the symbol which is used as domain separator for ftp login.
    |
    */

    'domain_separator' => '@',

    /*
    |--------------------------------------------------------------------------
    | FTP URL
    |--------------------------------------------------------------------------
    |
    | Defines FTP server URL.
    |
    */

    'url' => env('FTP_URL', 'ftp'),

    /*
    |--------------------------------------------------------------------------
    | SSL Expiration
    |--------------------------------------------------------------------------
    |
    | Defines a period in days when SSL certificate expiration alarm should be triggered
    |
    */
    'ssl_expiration' => env('FTP_SSL_EXPIRATION', 3),
];