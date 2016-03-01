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

        // TODO: please add to view
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['ads_management']; // Optional Permissions
        $loginUrl = $helper->getLoginUrl('http://training3.simplybridal.com/facebook-control-compain-status/fb-callback', $permissions);
        echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
    }

    /**
     *
     */
    protected function facebookCallback()
    {
        $fb     = FacebookHelper::getFacebook();
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

        if (! isset($accessToken)) {
           if ($helper->getError()) {
              header('HTTP/1.0 401 Unauthorized');
              echo "Error: " . $helper->getError() . "\n";
              echo "Error Code: " . $helper->getErrorCode() . "\n";
              echo "Error Reason: " . $helper->getErrorReason() . "\n";
              echo "Error Description: " . $helper->getErrorDescription() . "\n";
           } else {
              header('HTTP/1.0 400 Bad Request');
              echo 'Bad request';
           }
           exit;
        }

        //$_SESSION['facebook_access_token'] = (string) $accessToken;
        $_SESSION['fb_access_token'] = (string) $accessToken;

        // OAuth 2.0 client handler
        $oAuth2Client = $fb->getOAuth2Client();

        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

        echo 'is ok';
    }

}
