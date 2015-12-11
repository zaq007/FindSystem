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


if($CurrentUser != null)
{
    echo json_encode(getTeamTree($CurrentUser->Id));
	die();
}

die("Error!");
