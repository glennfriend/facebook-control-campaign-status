<?php
use Facebook\Facebook;

class FacebookHelper
{

    public static function getFacebook()
    {
        try {
            $fb = new Facebook([
               'app_id'     => conf('facebook.app.id'),
               'app_secret' => conf('facebook.app.secret'),
               'default_graph_version' => 'v2.7',
            ]);
        }
        catch(\Exception $e) {
            pr($e->getMessage(), true);
            exit;
        }

        return $fb;
    }
}
