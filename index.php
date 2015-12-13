<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 10.12.15
 * Time: 22:15
 * To change this template use File | Settings | File Templates.
 */

require_once 'Core/Auth.php';

if($CurrentUser == null)
{
echo <<< login
<form action="/login.php" method="POST">
    <input name="password" />
    <input type="submit"/>
</form>
login;
} else
{
    var_dump($CurrentUser);


}