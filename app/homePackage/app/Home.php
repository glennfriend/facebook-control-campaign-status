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
class Home extends BaseController
{

    /**
     *
     */
    protected function defaultPage()
    {
        if (!isset($_SESSION['fb_access_token']) || !$_SESSION['fb_access_token']) {
            return redirect('/login');
        }

        $fb = FacebookHelper::getFacebook();
        $fb->setDefaultAccessToken($_SESSION['fb_access_token']);

        $this->render(__FUNCTION__, [
            'fb'            => $fb,
            'adAccountId'   => attrib('aId'),
            'adAccountName' => attrib('aName'),
            'campaignName'  => attrib('campaigns_selected'),
        ]);
    }

    /**
     *
     */
    protected function status()
    {
        $token = \ViewHelper::getToken();
        if (!$token) {
            throw new \Exception("Token file not found.");
        }

        $fb = FacebookHelper::getFacebook();
        $fb->setDefaultAccessToken($token);

        if (isCli()) {
            $type = getParam(0);
            if ("1" !== $type && "0" !== $type) {
                throw new \Exception("type is error");
                exit;
            }
        }
        else {
            $type = getParam('type');
        }

        $this->render(__FUNCTION__, [
            'fb'    => $fb,
            'type'  => $type
        ]);
    }

    /**
     *  讀取某一個 aId
     *  將讀出來的資料, 狀態為 ACTIVE 的寫入 INI
     *  以方便星期六、星期一零晨的工作
     */
    protected function fbActiveSave()
    {
        $token = \ViewHelper::getToken();
        if (!$token) {
            throw new \Exception("Token file not found.");
        }

        $fb = FacebookHelper::getFacebook();
        $fb->setDefaultAccessToken($token);

        $aId = 'act_112950872167640';

        $this->render(__FUNCTION__, [
            'fb'  => $fb,
            'aId' => $aId,
        ]);
    }

}
