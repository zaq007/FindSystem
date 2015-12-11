<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 10.12.15
 * Time: 22:29
 * To change this template use File | Settings | File Templates.
 */

require_once "Inc/DB.php";
require_once "Model/TreeModel.php";

function getTree($id)
{
    global $db;
    try
    {
        $query = $db->prepare("SELECT * FROM `Trees` WHERE `Id` = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        if($query->rowCount() == 0)
            return null;
        return $query->fetchAll(PDO::FETCH_CLASS, 'TreeModel')[0];
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    return null;
}

function getCurrentTree($UserId)
{
	global $db;
    try
    {
        $query = $db->prepare("SELECT tr.Id, tr.isSolved, tr.TaskID, tr.Position 
							   FROM `Users` u 
							   JOIN `Trees` tr ON (u.CurrentTreeID = tr.Id)
							   WHERE u.Id = :userid");
        $query->bindParam(':userid', $UserId);
        $query->execute();
        if($query->rowCount() == 0)
            return null;
        return $query->fetchAll(PDO::FETCH_CLASS, 'TreeModel')[0];
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    return null;	
}

function insertTree($TeamId, $TaskId, $Position)
{
    global $db;
    try
    {
        $query = $db->prepare('INSERT INTO `Trees` (`TeamID`, `TaskID`, `Position`) VALUES (:teamId, :taskId, :position)');
        $query->bindParam(':teamId', $TeamId);
        $query->bindParam(':taskId', $TaskId);
        $query->bindParam(':position', $Position);
        return $query->execute();
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    return false;
}

function updateTree($TeamId, $TaskId, $Position)
{
    global $db;
    try
    {
        $query = $db->prepare("UPDATE `Trees` SET `TaskID` = :taskId WHERE `TeamID` = :teamId AND `Position` = :position AND isSolved = 0");
        $query->bindParam(':teamId', $TeamId);
        $query->bindParam(':taskId', $TaskId);
        $query->bindParam(':position', $Position);
        return $query->execute();
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    return false;
}

function getTeamTree($TeamId)
{
	global $db;
    try
    {
        $query = $db->prepare("SELECT *
								FROM `Trees`
								WHERE `TeamID` = :teamId");
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