<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 10.12.15
 * Time: 22:15
 * To change this template use File | Settings | File Templates.
 */

require_once 'Core/Auth.php';
require_once 'Repository/UserRepository.php';


$Password = $_POST['password'];

if($CurrentUser == null)
{
	$User = getUserByPassword($Password);
	if($User != null)
	{
		$Session = sessionGenerator();
		updateSession($User->Id, $Session);
		setcookie("auth", $Session);
	}
} 

header("Location: /", 301);