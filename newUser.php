<?php
set_include_path('./');
require_once ('MySQLDB.php');
require_once ('User.php');
require_once ('login.php');
include_once ('myFunctions.php');
include_once ('db.php');

$email = '';
$password = '';
$user_id = '';
$nickname ='';
$lang ='';
$newUserAllFieldsCheck = 0;
$currentUser = NULL;
$passwordsMatch = false;

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
	  $nickname = filter_var($_POST[ 'nickname' ], FILTER_SANITIZE_STRING);  
		if(!empty($nickname)){
			$newUserAllFieldsCheck ++;
		}     
     $sanEmail = filter_var($_POST[ 'newEmail' ], FILTER_SANITIZE_EMAIL);
     $email = filter_var($sanEmail, FILTER_VALIDATE_EMAIL);
		if (!filter_var($sanEmail, FILTER_VALIDATE_EMAIL)){
			echo '<h2>Email could not be validated. Please check email address or use different address</h2>';		
		}

		if(!empty($email)){
			$newUserAllFieldsCheck ++;     
		}
		
     $newPass = filter_var($_POST[ 'newPass' ], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
 		if(!empty($newPass)){
			$newUserAllFieldsCheck ++;  
		}   
    $newPassConf = filter_var($_POST[ 'newPassConf' ], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		//echo "password: $newPass Confirm pass: $newPassConf";		
		if(!empty($newPassConf)){
			$newUserAllFieldsCheck ++;
		}		     
      if($newPass == $newPassConf){
       $time = (string)time();	
		 $salt = '$5$round=5000$Onanex'.$time.'CeptioNally58201eninGearlyin$';
		 $password = crypt($newPass, $salt);
		 $passwordsMatch = true;
   	}else{
		echo '<h2>Passwords do not match. Please try again</h2>';	   	
   	
   	}
    if ($_POST['langChoice'] == 'Hindi'){
    	$lang = 'hi';
    }
    else {
		$lang = 'en';    
    }		
    if(!empty($lang)){
		$newUserAllFieldsCheck ++;
	}

	if($newUserAllFieldsCheck == 5 && $passwordsMatch){
	 $currentUser = new User($db, $nickname, $email, $password, 0, $lang, true);
	 $user_id = $currentUser->setUserID($db);
		//echo "<br><br>USER ID : $user_id <br>";
    $_SESSION['user_id'] = $user_id;
    $_SESSION['currentUser'] = $currentUser;	
    header('location: main.php');

	} else{
		echo '<h2> All fields need to be completed and passwords need to match</h2>'; 		
		echo '<a href = "index.php" title="Return to homepage">Return to homepage</a>';           
		//header('location: index.php');
	} 
}
  
?>