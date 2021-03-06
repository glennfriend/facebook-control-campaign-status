<?php
namespace Bridge;

/**
 *  Session
 *      - 在未過期的情況下進入網頁, session expire 會自動延長時間
 */
class Session
{

    /**
     *  init
     */
    public static function init($opt=[])
    {
        $opt += [
            'sessionPath'   => '',
            'expire'        => 7200,    // default 2h = 2 * 60 * 60 = 7200
        ];

        if(!$opt['sessionPath']) {
            throw new \Exception('Error: Session path not setting!');
        }
        ini_set('session.save_path', $opt['sessionPath']);

        /*
            ini_set('session.gc_maxlifetime',  $expire );
            ini_set('session.cookie_lifetime', $expire );
            session_set_cookie_params($expire);

            if (isset($_COOKIE['PHPSESSID']) && ''!==$_COOKIE['PHPSESSID']) {
                setcookie('PHPSESSID', session_id(), time() + $expire, '/');
            }

            print_r(session_get_cookie_params());
        */


        session_start();

        $sessionExpire = self::get('session_expire');
        if ($sessionExpire) {
            if (time() >= $sessionExpire) {
                self::destroy();
            }
        }
        else {
            // first time
        }

        self::set('session_expire', time() + $opt['expire']);
    }

    /* --------------------------------------------------------------------------------
        access
    -------------------------------------------------------------------------------- */

    /**
     *  get session by key
     */
    public static function get($key, $defaultValue=null)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return $defaultValue;
    }

    public static function getAll()
    {
        return $_SESSION;
    }

    /*
        // 支援使用 "." 的方式取得多維陣列下的值 => get('user.name')
        getDot()
    */

    /* --------------------------------------------------------------------------------
        write
    -------------------------------------------------------------------------------- */

    /**
     *  set
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     *  remove
     */
    public static function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     *  destroy all
     */
    public static function destroy()
    {
        session_destroy();
    }

}
