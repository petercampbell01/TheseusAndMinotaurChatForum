<?php
set_include_path('./');
require_once ('MySQLDB.php');
require_once ('User.php');
include_once ('myFunctions.php');
include_once ('db.php');
session_save_path("./");
session_start();session_save_path("./");
session_start();
if(isset($_SESSION['time'])){
	if(!checkSessionActive($_SESSION['time'])){
		return false;
	}
}


$_SESSION['time'] = time();
$str =  $_GET['q'];
$newArr = array_map('intval', explode(',', $str));;
$count = $newArr[0];
$incr = $newArr[1];
$message_id = $newArr[2];
$user_id = $newArr[3];
echo addLikes($db, $user_id, $message_id, $count, $incr);
