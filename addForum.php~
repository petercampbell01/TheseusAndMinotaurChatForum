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
$newForumName = '';
$newForumSubject = '';
$newForum = null;

if (isset($_POST[ 'forname' ]) && isset($_POST[ 'forsubj' ])){
	$forumName = filter_var($_POST[ 'forname' ], FILTER_SANITIZE_STRING);
	$newForumName = $db->escapeString($forumName);	
	$forumSubject = filter_var($_POST[ 'forsubj' ], FILTER_SANITIZE_STRING);
	$newForumSubject = $db->escapeString($forumSubject);	
	$newForumID = $currentUser->addNewForum($db, $newForumName, $newForumSubject);
	$location = "location: addMessage.php?$newForumID";	
	if($newForumID){	
		header($location);
	}
	else{
		echo "Something went wrong here. Try logging in and coming back here again.";	
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Theseus and the Minotaur | Add Forum</title>
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
		<?php echo "Hello $name, please enter information about the new forum"; ?>
		<form action="addForum.php" method = "post">
				<div class="labelled-input">			
					<label for="forname">Forum name:</label><br>
		  			<input type="text" name="forname"/>
				</div>
				<div class="labelled-input">			
					<label for="forsubj">Subject:</label><br>
					<input type="text" name="forsubj"/>
					<input type="submit" value="Create new forum"/>
				</div>
			</form>		
		</div>
	</div>
	
	<footer>
		<p>Copyright &copy; Peter Campbell, 2018</p>
	</footer>
</body>
</html>
