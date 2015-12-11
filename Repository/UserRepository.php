<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 10.12.15
 * Time: 22:07
 * To change this template use File | Settings | File Templates.
 */

require_once "\\Inc\\DB.php";

function getUser($session)
{
    global $db;
    try
    {
        $query = $db->prepare("SELECT * FROM `Users` WHERE 'session'=':session'");
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