<?php

use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;
use OAuth;

class User extends SentryUserModel {

    /**
     * Indicates if the model should soft delete.
     *
     * @var bool
     */
    protected $softDelete = true;

    /**
     * Returns the user full name, it simply concatenates
     * the user first and last name.
     *
     * @return string
     */
    public function fullName() {
        return "{$this->first_name} {$this->last_name}";
    }

    public function facebookAuth($code = NULL) {
        $fb = OAuth::consumer('Facebook');
        if ($code == NULL) {
            $authUrl = $fb->getAuthorizationUri();
            return (String) $authUrl;
        }
        //if authorized get the token
        $fb->requestAccessToken($code);

        //get the data
        $fbUser = json_decode($fb->request('/me'));
//        dd($fbUser);
        try {
            $user = Sentry::findUserByLogin($fbUser->email);
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $user = new User([
                'first_name' => $fbUser->first_name,
                'last_name' => $fbUser->last_name,
                'email' => $fbUser->email,
                'password' => uniqid(),
                'activated' => true
            ]);
            $user->save();
        }
        // login the user
        Sentry::login($user);
        return $user;
    }

    public function linkedinAuth($code = NULL) {

        $linkedinService = OAuth::consumer('Linkedin');

        if (!empty($code)) {

            // This was a callback request from linkedin, get the token
            $token = $linkedinService->requestAccessToken($code);
            // Send a request with it. Please note that XML is the default format.
            $result = json_decode($linkedinService->request('/people/~:(id,first-name,last-name,email-address,industry,headline,current-status,specialties,interests,positions,languages,skills,educations,phone-numbers,date-of-birth,picture-url,public-profile-url,location)?format=json'), true);
            try {
                $user = Sentry::findUserByLogin($result["emailAddress"]);
            } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                $user = new User([
                    'first_name' => $result['firstName'],
                    'last_name' => $result['lastName'],
                    'email' => $result["emailAddress"],
                    'password' => uniqid(),
                    'activated' => true
                ]);
                $user->save();
            }
            // login the user
            Sentry::login($user);
            return $user;
        }// if not ask for permission first
        else {
            // get linkedinService authorization
            $url = $linkedinService->getAuthorizationUri(array('state' => 'DCEEFWF45453sdffef424'));
            // return to linkedin login url
            return (string) $url;
        }
    }

    public function twitterAuth($token = NULL, $verify = NULL) {
        // get twitter service
        $tw = OAuth::consumer('Twitter');

        // check if code is valid
        // if code is provided get user data and sign in
        if (!empty($token) && !empty($verify)) {

            // This was a callback request from twitter, get the token
            $token = $tw->requestAccessToken($token, $verify);

            // Send a request with it
            $result = json_decode($tw->request('account/verify_credentials.json'));

            try {
                $user = User::where('twitter_id', '=', $result->id)->firstOrFail();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                //if user is not yet registered we have to store existing twitter id and ask for more details
                Session::put('twitterAccount', $result);
                throw new UserNotRegisteredException();
            }
            // login the user
            Sentry::login($user);
            return $user;
        }
        // if not ask for permission first
        else {
            // get request token
            $reqToken = $tw->requestRequestToken();

            // get Authorization Uri sending the request token
            $url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

            // return to twitter login url
            return (string) $url;
        }
    }

    public function twitterLogin($twitter = null, $email = null) {
        try {
            $user = Sentry::findUserByLogin($email);
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $user = new User([
                'first_name' => $twitter->name,
                'email' => $email,
                'password' => uniqid(),
                'activated' => true,
                'website' => $twitter->url,
                'twitter_id' => $twitter->id
            ]);
            $user->save();
        }
        // login the user
        Sentry::login($user);
        return $user;
    }

    /**
     * Returns the user Gravatar image url.
     *
     * @return string
     */
    public function gravatar() {
        // Generate the Gravatar hash
        $gravatar = md5(strtolower(trim($this->gravatar)));

        // Return the Gravatar url
        return "//gravatar.org/avatar/{$gravatar}";
    }

}

class UserNotRegisteredException extends Exception {
    
}
