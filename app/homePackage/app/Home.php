<?php
namespace AppModule;

use Facebook\Facebook;
use Facebook\FacebookApp;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

use FacebookHelper;

/**
 *
 */
class Home extends Tool\BaseController
{

    protected function init()
    {
        if (!isset($_SESSION['fb_access_token']) || !$_SESSION['fb_access_token']) {
            return redirect('/login');
        }
    }

    /**
     *
     */
    protected function defaultPage()
    {
        $fb = FacebookHelper::getFacebook();
        $fb->setDefaultAccessToken($_SESSION['fb_access_token']);

        $this->render('defaultPage', [
            'fb'            => $fb,
            'adAccountId'   => attrib('aId'),
            'adAccountName' => attrib('aName'),
            'campaignName'  => attrib('campaigns_selected'),
        ]);
    }

    /**
     *
     */
    protected function pause()
    {
        $fb = FacebookHelper::getFacebook();
        $fb->setDefaultAccessToken($_SESSION['fb_access_token']);

        $this->render('pause', [
            'fb'            => $fb,
            'adAccountId'   => attrib('aId'),
        ]);
    }

}
