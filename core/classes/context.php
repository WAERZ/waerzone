<?php
class Context
{
    private static $instance = null;

    public static function init()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function __construct(){}
    private function __clone(){}

    /**
     * This method checks the user and return the required value of session
     * @param string $param
     * @return bool
     * @todo cookie exist
     */
    public static function getUser()
    {
        if (isset($_SESSION["user"]['login'])) {     // session exist login
            return $_SESSION["user"]['login'];    // return required user login
        } else{
            return false;
        }
    }
}