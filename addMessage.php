<?php
set_include_path('./');
require_once ('MySQLDB.php');
require_once ('User.php');
include_once ('myFunctions.php');
include_once ('db.php');
session_save_path("./");
session_start();
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
$allMyLanguagesArr  = parse_ini_file('languages.ini', true);
$curLanArr = $allMyLanguagesArr[$lang];
$forum_id = null;
$message = '';

if(isset($_SERVER['QUERY_STRING'])){
	// ADD SECURITY HERE
	$forum_id = intval($_SERVER['QUERY_STRING']);
	$_SESSION['forum_id'] = $forum_id;
	if(!$currentForum = getForum($db, $forum_id)){
		echo "There's a problem accessing this forum. Please leave the page and come back later";	
	} 
}

if (isset($_POST[ 'message' ]) ){
	if (!$forum_id){
		$forum_id = $_SESSION['forum_id'];	
	}
	$message =  filter_var($_POST[ 'message' ], FILTER_SANITIZE_STRING);
	$messagetxt = $db->escapeString($message);
	$message_id = $currentUser->addMessage($db, $forum_id, $messagetxt);
	if($message_id){
		$location = "location: main.php?$forum_id";
		header($location);	
	}
	echo "There's a problem here. Try coming back a little later.";

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Theseus and the Minotaur | Add Message</title>
	<link rel="stylesheet" href="./stylesheets/stylesheet.css">
</head>
<body>
	<header>
		<?php 
			echo "<h1>$curLanArr[heading]</h1>";
			echo "<a id = 'logout' href ='./index.php' title='$curLanArr[exit]'>$curLanArr[exit]</a>";
		?>		
		<img id="logo" src="./img/bull-horns_large.png" alt="Horns of the Minotaur">
	</header>
<body>
	<div class ="content">
	<?php
	if(isset($currentForum)){ 
		echo "<h2>Write message to $currentForum[name] </h2>";
		echo "<p>About: $currentForum[subject]</p>";
	}
	?>
	<form id= "messageForm"action ="addMessage.php" method="post">
		<!-- <input type = "textarea" cols="25" rows="7" />
-->
		<textarea id = "messageArea" name = "message"></textarea>
		<br>
		<input id = "submitMessage" type = "submit" value="Post message"/>

	</div>
	<footer>
		<p>Copyright &copy; Peter Campbell, 2018</p>
	</footer>
</body>
</html>

