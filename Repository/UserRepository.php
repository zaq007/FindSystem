<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 10.12.15
 * Time: 22:07
 * To change this template use File | Settings | File Templates.
 */

require_once "Inc/DB.php";
require_once "Model/UserModel.php";

function getUserBySession($session)
{
    global $db;
    try
    {
        $query = $db->prepare("SELECT * FROM `Users` WHERE session=:session");
        $query->bindParam(":session", $session);
        $query->execute();
        if($query->rowCount() == 0)
            return null;
        return $query->fetchAll(PDO::FETCH_CLASS, 'UserModel')[0];
    }catch (Exception $e)
    {
        echo $e->getMessage();
        return null;
    }
}

function getUserByPassword($password)
{
	global $db;
    try
    {
        $query = $db->prepare("SELECT * FROM `Users` WHERE Password=:password");
        $query->bindParam(":password", $password);
        $query->execute();
        if($query->rowCount() == 0)
            return null;
        return $query->fetchAll(PDO::FETCH_CLASS, 'UserModel')[0];
    }catch (Exception $e)
    {
        echo $e->getMessage();
        return null;
    }	
}

function updateSession($UserId, $Session)
{
	global $db;
    try
    {
        $query = $db->prepare("UPDATE `Users` SET Session=:session WHERE Id=:userid");
        $query->bindParam(":session", $Session);
        $query->bindParam(":userid", $UserId);
		return $query->execute();
    }catch (Exception $e)
    {
        echo $e->getMessage();
        return null;
    }	
}

function sessionGenerator()
{
	return md5("FIND".time()."FIND");	
}