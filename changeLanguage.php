<?php
set_include_path('./');
require_once ('MySQLDB.php');
require_once ('User.php');
include_once ('myFunctions.php');
include_once ('db.php');
session_save_path("./");
session_start();
if(!isset($_SESSION['currentUser'])){
	header('location: index.php');
}

if(isset($_SESSION['time'])){
	if(!checkSessionActive($_SESSION['time'])){
		header('location: index.php');
	}
}
$_SESSION['time'] = time();
$user_id = $_SESSION['user_id'];
$currentUser = $_SESSION['currentUser'];
$name = $currentUser->getNickname();
$lang = $currentUser->lang;
if(isset($_SERVER['QUERY_STRING'])){
	$filtered = filter_var( $_SERVER[ 'QUERY_STRING' ], FILTER_SANITIZE_STRING);
	if($filtered == 'hi'){
		$lang = 'hi';
		$currentUser->lang = $lang;	
	}
	else if($filtered == 'en'){
		$lang = 'en';
		$currentUser->lang = $lang;	
	}
}
header('location: main.php');