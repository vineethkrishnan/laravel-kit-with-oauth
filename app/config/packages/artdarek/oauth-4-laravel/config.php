<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | oAuth Config
      |--------------------------------------------------------------------------
     */

    /**
     * Storage
     */
    'storage' => 'Session',
    /**
     * Consumers
     */
    'consumers' => array(
        /**
         * Facebook
         */
        'Facebook' => array(
            'client_id' => 'YOUR API KEY',
            'client_secret' => 'YOUR API SECRET',
            'scope' => array('email'),
        ),
        /**
         * Linkedin
         */
        'Linkedin' => array(
            'client_id' => 'CLIENT ID',
            'client_secret' => 'CLIENT SECRET',
            'scope' => array('r_fullprofile', 'r_emailaddress', 'r_contactinfo'),
        ),
        /**
         * Twitter
         */
        'Twitter' => array(
            'client_id' => 'API KEY',
            'client_secret' => 'API SECRET',
        // No scope - oauth1 doesn't need scope
        ),
    )
);
