<?php
//set_include_path('/home/user/Desktop/PhpServerSide/Assignment2/');
//echo phpinfo();
set_include_path('./');

require_once ('MySQLDB.php');
require_once ('User.php');
require_once ('login.php');
include_once ('myFunctions.php');
include_once ('db.php');
session_save_path("./");
session_start();
$_SESSION = array();
session_destroy();
session_start();
$_SESSION['time'] = time();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Theseus and the Minotaur | Login and Sign-up</title>
	<link rel="stylesheet" href="./stylesheets/login-stylesheet.css">
</head>
<body>
	<header>
		<h1>Theseus and the Minotaur</h1>
		<form action = "login.php" method="post">
			<label for="email">E-mail</label>
			<input type="text" name="email"/>
			<label for ="password">Password</label>

			<input type="password" name="password"/>
			<input id = "submit" type="submit" value="Login"/>
		</form>	
		<img id="logo" src="./img/bull-horns_large.png" alt="Horns of the Minotaur">
	</header>
	<div id="wrapper">
		<div id="main-image">
			<img src="./img/theseus-defeats-the-minotaur.jpg" alt="Theseus defeats the Minotaur">	
			</div>
		<div id="sign-up">
			<form id="new-member" action="newUser.php" method="post">
				<h2>Join Theseus and his friends in a maze of fun!</h2>
				<div class="labelled-input">			
					<label for="nickname">Nickname:</label>
		  			<input type="text" name="nickname"/>
				</div>
				<div class="labelled-input">			
					<label for="newEmail">E-mail:</label>
					<input type="text" name="newEmail"/>
				</div>
				<div class="labelled-input">			
					<label for="newPass">Password:</label>
					<input type="password" id = "pass" onkeyup = "verifyStrength()" name="newPass" />
				</div>
					<p id = "passwordStrength"></>				

				<div class="labelled-input">			
					<label for="newPassConf">Confirm:</label>
					<input type="password" name="newPassConf"/>
				</div>
				<div class="labelled-input">
					<label for="langChoice">Language:</label>
					<select name="langChoice" required>
						<option selected disabled = "blank">Choose language</option>
						<option>English</option>
						<option>Hindi</option>
<!--						<option>French</option>
						<option>Russian</option>
						<option>Spanish</option>
						<option>Mandarin</option>
-->					</select>
				</div>				
				<input type="submit" value="Join the club" id="formSubmit"/>	
			</form>
		</div>
	</div>
	<footer>
		<p>Copyright &copy; Peter Campbell, 2018</p>
		<p><a href="createDB.php" title="Load database">Load Database</a></p>
	</footer>
</body>
</html>
<script>

function verifyStrength(){
	showStrength(calculateStrength()	)
}


function calculateStrength(){
	let strength = 0	
	let x = document.getElementById('pass')
	let password = x.value
	//console.log ( password)
	strength += password.length	
	let test1 = new RegExp('/d');

	// Do testing
	if(test1.test(password))
		strength += 2
	let test2 = new RegExp('[a-z]')
	if(!test2.test(password)){
		strength += 2	
	}
	let test3 = new RegExp ('[!-*]')
	if(test3.test(password)){
		strength += 2	
	}
	let test4 =new RegExp('[A-Z]/i')
	if(test4.test(password)){
		strength += 2	
	}
	return strength
}


function showStrength(strength){
//provide feedback
	let y = document.getElementById('passwordStrength')
	if(y.innerHTML.length == 0)
		y.innerHTML = ''	
	y.style.color = 'black'
	if(strength > 0){
		y.innerHTML = 'weak'
		y.style.backgroundColor = 'red'
	}
	if(strength > 8){
		y.innerHTML = 'medium'
		y.style.backgroundColor = 'yellow'
	}
	if(strength > 12){
		y.innerHTML = 'good'
		y.style.backgroundColor = 'yellow'
	}
	if(strength >=14){
		y.innerHTML = 'strong'
		y.style.backgroundColor = 'green'
	
	}
}

</script>
