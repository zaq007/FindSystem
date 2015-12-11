<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 10.12.15
 * Time: 22:22
 * To change this template use File | Settings | File Templates.
 */

set_include_path('..');

require_once 'Core/Auth.php';
require_once 'Repository/TreeRepository.php';
require_once 'Repository/TaskRepository.php';


$Position = (int)$_POST['position'];

if($CurrentUser != null)
{
    if($CurrentUser->CurrentTreeID == null)
    {
        chooseTask($CurrentUser, $Position);
        $CurrentUser = getUser($_COOKIE['auth']);
    }


    $Tree = getTree($CurrentUser->CurrentTreeID);
    if($Tree->Position == $Position)
    {
        $Task = getTask($Tree->TaskID);
        echo json_encode(Array( "text" => $Task->Text));
		die();
    } 
}

die("Error!");
