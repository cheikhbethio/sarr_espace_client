<?php
/**
 * Created by PhpStorm.
 * User: moussa
 * Date: 01/02/2016
 * Time: 14:06
 */

spl_autoload_register('myAdminAutoLoad');

function myAdminAutoLoad($class){
    require "../class/$class.php";
}