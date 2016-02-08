<?php

/* Date: 01/02/2016 */
class theApp{
    static $db =null;

    static function getDataBase(){
        if(!self::$db){
            self::$db = new Database('root', '', 'depannage_sarr');
        }
        return self::$db;
    }
    static function redirect($page){
        header("Location: $page");
        exit();
    }
    static function getAuth(){
        return new Auth(Session::getInstance());
    }
}