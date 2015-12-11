<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 10.12.15
 * Time: 22:29
 * To change this template use File | Settings | File Templates.
 */

require_once "\\Inc\\DB.php";
require_once "\\Repository\\TreeRepository.php";

function getTree($id)
{
    global $db;
    try
    {
        $query = $db->prepare("SELECT * FROM `Tasks` WHERE 'id' = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        if($query->rowCount() == 0)
            return null;
        return $query->fetchAll(PDO::FETCH_CLASS, 'TaskModel')[0];
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    return null;
}

function getSolved($TeamId)
{
	global $db;
    try
    {
        $query = $db->prepare("SELECT TaskID
                                from Trees
                                where TeamID = :teamId AND isSolved = true");
        $query->bindParam(':teamId', $TeamId);
        $query->execute();
        return $query->fetchAll();
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    return Array();
	
}

function isSolved($TeamId, $Position)
{
	global $db;
    try
    {
        $query = $db->prepare("SELECT * 
                               FROM Trees
                               where TeamID = :teamId AND Position=:position AND isSolved = true");
        $query->bindParam(':teamId', $TeamId);
		$query->bindParam(':position', $Position);
        $query->execute();
        $query->fetchAll();
		if($query->rowCount() == 0)
            return false;
		return true;
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
}

function getSuitable($TeamId)
{
    global $db;
    try
    {
        $query = $db->prepare("select *
                                from `tasks`
                                where id not in (
                                select TaskID
                                from Trees
                                where TeamID = :teamId AND isSolved = true
                                minus
                                select t.Id as \"TaskID\"
                                from Users u
                                join Trees t on u.CurrentTreeID = t.Id)
                                and id <> 1 and id <> 10");
        $query->bindParam(':teamId', $TeamId);
        $query->execute();
        if($query->rowCount() == 0)
            return null;
        return $query->fetchAll(PDO::FETCH_CLASS, 'TaskModel')[0];
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    return null;



}

function chooseTask($User, $Position)
{
    $fp = fopen('/tmp/php-commit.lock', 'r+');
    while (!flock($fp, LOCK_EX | LOCK_NB)) {
        usleep(100);
    }

    $TaskID;

    if($Position == 1 || $Position == 10)
        $TaskID = $Position;
    else
    {
        $Task = getSuitable($User->Id);
        $TaskID = $Task->Id;
    }

    updateTree($User->Id, $TaskID, $Position);

    flock($fp, LOCK_UN);
    fclose($fp);
}

function getCurrentTask($UserId)
{
	global $db;
    try
    {
        $query = $db->prepare("SELECT t.Id AS 'Id', t.Text AS 'Text', t.Answer AS 'Answer' 
							   FROM `Users` u 
							   JOIN `Trees` tr ON (u.CurrentTreeID = tr.Id)
							   JOIN `Tasks` t ON (tr.TaskID = t.Id)
							   WHERE u.Id = :userid");
        $query->bindParam(':userid', $UserId);
        $query->execute();
        if($query->rowCount() == 0)
            return null;
        return $query->fetchAll(PDO::FETCH_CLASS, 'TaskModel')[0];
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    return null;	
}