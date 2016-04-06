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


$Answer =  trim(mb_strtolower($_POST['answer'], mb_internal_encoding()));

if($CurrentUser != null)
{
    $Task = getCurrentTask($CurrentUser->Id);
	if($Task != null)
	{
		if(strcmp($Task->Answer, $Answer) == 0 )
		{
			$Tree = getCurrentTree($CurrentUser->Id);
			switch ($Tree->Position)
			{
				case 1:
					insertTree($CurrentUser->Id, null, 2);
					insertTree($CurrentUser->Id, null, 3);
				break;
				case 2:
					insertTree($CurrentUser->Id, null, 4);
					insertTree($CurrentUser->Id, null, 5);
				break;
				case 3:
					insertTree($CurrentUser->Id, null, 6);
					insertTree($CurrentUser->Id, null, 7);
				break;
				case 4:
					if(isSolved($CurrentUser->Id, 5))
						insertTree($CurrentUser->Id, null, 8);
				break;
				case 5:
					if(isSolved($CurrentUser->Id, 4))
						insertTree($CurrentUser->Id, null, 8);
				break;
				case 6:
					if(isSolved($CurrentUser->Id, 7))
						insertTree($CurrentUser->Id, null, 9);
				break;
				case 7:
					if(isSolved($CurrentUser->Id, 6))
						insertTree($CurrentUser->Id, null, 9);
				break;
				case 8:
					if(isSolved($CurrentUser->Id, 9))
						insertTree($CurrentUser->Id, null, 10);
				break;
				case 9:
					if(isSolved($CurrentUser->Id, 8))
						insertTree($CurrentUser->Id, null, 10);
				break;
				case 10:
				break;
			}
			setSolved($CurrentUser->Id, $Tree->Position);
			die("OK");
		}
	}
}

die("Error!");
