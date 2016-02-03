<?php

class AuthorizedController extends BaseController
{
    /**
     * Whitelisted auth routes.
     *
     * @var array
     */
    protected $whitelist = [];

    /**
     * Initializer.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply the auth filter
        $this->beforeFilter('auth', ['except' => $this->whitelist]);

        // Call parent
        parent::__construct();
    }
}
