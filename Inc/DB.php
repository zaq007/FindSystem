<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 10.12.15
 * Time: 22:02
 * To change this template use File | Settings | File Templates.
 */

require_once '\\Inc\\config.php';

$db = null;
try
{
    $db = new PDO($config['DB_SERVERNAME'], $config['DB_USERNAME'], $config['DB_PASSWORD']);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(PDOException $e)
{
    echo $e->getMessage();
}