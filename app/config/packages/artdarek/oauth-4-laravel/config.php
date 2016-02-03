<?php

return [
    /*
      |--------------------------------------------------------------------------
      | oAuth Config
      |--------------------------------------------------------------------------
     */

    /*
     * Storage
     */
    'storage' => 'Session',
    /*
     * Consumers
     */
    'consumers' => [
        /*
         * Facebook
         */
        'Facebook' => [
            'client_id'     => 'YOUR API KEY',
            'client_secret' => 'YOUR API SECRET',
            'scope'         => ['email'],
        ],
        /*
         * Linkedin
         */
        'Linkedin' => [
            'client_id'     => 'CLIENT ID',
            'client_secret' => 'CLIENT SECRET',
            'scope'         => ['r_fullprofile', 'r_emailaddress', 'r_contactinfo'],
        ],
        /*
         * Twitter
         */
        'Twitter' => [
            'client_id'     => 'API KEY',
            'client_secret' => 'API SECRET',
        // No scope - oauth1 doesn't need scope
        ],
    ],
];
