<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 10.12.15
 * Time: 22:04
 * To change this template use File | Settings | File Templates.
 */

require_once 'Inc/DB.php';
require_once 'Repository/UserRepository.php';

$CurrentUser = null;
if(isset($_COOKIE['auth']))
{
    $CurrentUser = getUserBySession($_COOKIE['auth']);
}