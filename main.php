<?php
//set_include_path('/home/user/Desktop/PhpServerSide/Assignment2/');
//echo phpinfo();
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
$allMyLanguagesArr  = parse_ini_file('languages.ini', true);
$curLanArr = $allMyLanguagesArr[$lang];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Theseus and the Minotaur | Forum</title>
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
	<div id="wrapper">
		<div id="groups">
			<div class="info">
				<?php
					$forums = $currentUser->getAllMyForums();	
					if(count($forums) > 0 ){
						echo	"<h3>$curLanArr[myforums]</h3>";
						echo "<ul>";
						$forums = $currentUser->getAllMyForums();
						if($forums != false){
							displayForums($forums);
						}
					}					
				 ?>

			</ul>
			<?php
				echo "<h3><a href = 'main.php' title='Show all forums'>$curLanArr[allforums]</a></h3><ul>"; 
					$allForums = getAllForums($db, $user_id);
					if($allForums != false){
						displayForums($allForums);
					}	
				?>
				</ul>
				<form action ="addForum.php" method="post">
					<input type="submit" value="Create forum" />
				</form>
			</div>

		</div>
		<div id= "currentDiscussion">
		<div class="content">
						<?php 
				$query = '';
				if (isset( $_SERVER[ 'QUERY_STRING' ] )){
					$filtered = $page = filter_var( $_SERVER[ 'QUERY_STRING' ], FILTER_SANITIZE_NUMBER_INT);
					$query = intval($filtered);

				}
				if($query == ''){
					foreach($forums as $currentForum){
						displayChatForum($db, $currentForum, $user_id);
					}
					foreach($allForums as $currentForum){
						displayChatForum($db, $currentForum, $user_id);
					}
				}
				else {
					$newForumArr = array_merge($forums, $allForums);
					foreach($newForumArr as $currentForum){
						if($currentForum['forum_id'] == $query){
							displayChatForum($db, $currentForum, $user_id);
						}					
					}
									
				}
			?>

		</div>
		
		</div>		
		<div id= "myMessages">
			<p style="text-align: right; padding: .03rem 2rem">Language <a href="changeLanguage.php?en" title="Change to English">En</a>/<a href="changeLanguage.php?hi" title = "Change to Hindi">Hi</a> </p>
		<div class="info">
			<?php $name =$currentUser->getNickname(); echo '<h3>'.$name."'s messages:</h3> " ?>
			<ul>
				<?php displayMessages(array_reverse( $currentUser->getAllMyMessages())); ?>
  		</ul>
		</div>
		</div>
	</div>
	<footer>
		<p>Copyright &copy; Peter Campbell, 2018</p>
	</footer>
</body>
  <script>
  function doCount(count, incr, counterID, msgID, user_id){
    xhttp = new XMLHttpRequest()
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
      document.getElementById(counterID).innerHTML = this.responseText
      }
    }
    let fileQuery = 'counter.php?q=' + count + ',' + incr + ',' + msgID + ',' + user_id
    xhttp.open('GET', fileQuery, true)
    xhttp.send()
}
</script>

</html>
