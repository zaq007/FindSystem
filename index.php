<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 10.12.15
 * Time: 22:15
 * To change this template use File | Settings | File Templates.
 */

require_once 'Core/Auth.php';

$html = "";
if($CurrentUser == null)
{
    $html = file_get_contents(__DIR__ . "/Layout/login.html");
}
{
    $html = file_get_contents(__DIR__ . "/Layout/index.html");
}
echo $html;