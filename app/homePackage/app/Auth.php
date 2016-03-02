<?php
namespace AppModule;

use Facebook\Facebook;
use Facebook\FacebookApp;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

use FacebookAds\Api;
use FacebookAds\Object\AdUser;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\AdSetFields;

use FacebookHelper;

/**
 *
 */
class Auth extends Tool\BaseController
{

    protected function init()
    {
        $_SESSION['fb_access_token'] = '';
    }

    /**
     *
     */
    protected function login()
    {
        $fb = FacebookHelper::getFacebook();

        if (isset($_SESSION['fb_access_token']) && $_SESSION['fb_access_token']) {
            return redirect('/');
        }

        $_SESSION['fb_access_token'] = '';

        $this->render('login', [
            'fb' => $fb,
        ]);
    }

    /**
     *
     */
    protected function facebookCallback()
    {
        $fb = FacebookHelper::getFacebook();
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (isset($accessToken)) {
            $_SESSION['fb_access_token'] = (string) $accessToken;
        }

        $this->render('facebookCallback', [
            'fb'          => $fb,
            'helper'      => $helper,
            'accessToken' => $accessToken,
        ]);
    }

}
