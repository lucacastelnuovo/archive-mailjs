<?php

namespace App\Helpers;

class SessionHelper
{
    /**
     * Set session var
     *
     * @param string $name
     * @param mixed $data
     * 
     * @return mixed
     */
    public static function set($name, $data)
    {
        $_SESSION[$name] = $data;

        return $data;
    }

    /**
     * Unset session var
     *
     * @param string $name
     * 
     * @return void
     */
    public static function unset($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * Get session var
     *
     * @param string $name
     * 
     * @return mixed
     */
    public static function get($name)
    {
        return $_SESSION[$name];
    }

    /**
     * Destroy and restart a session
     *
     * @param string $haystack
     * @param string $needle
     * 
     * @return void
     */
    public static function destroy()
    {
        session_destroy();
        session_start();
    }

    /**
     * Check if user is logged in
     *
     * @param string $haystack
     * @param string $needle
     * 
     * @return bool
     */
    public static function valid()
    {
        $ip_match = SessionHelper::get('ip') === $_SERVER['REMOTE_ADDR'];
        $session_valid = time() - SessionHelper::get('last_activity') < config('auth')['session_expires'];

        SessionHelper::set('last_activity', time());

        return $ip_match && $session_valid;
    }
}
