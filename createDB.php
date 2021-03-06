<?php
set_include_path('./');
require_once ('MySQLDB.php');
require_once ('User.php');
require_once ('login.php');
include_once ('myFunctions.php');
include_once ('db.php');

//  create the database again
$db->createDatabase();
// select the database
$db->selectDatabase();

// drop the tables
$sql = "drop table if exists rating";
$result = $db->query($sql);

$sql = "drop table if exists message";
$result = $db->query($sql);

$sql = "drop table if exists forum";
$result = $db->query($sql);

$sql = "drop table if exists user";
$result = $db->query($sql);


//create tables

$sql = "create table user
	(user_id INT not null auto_increment,
	email CHAR(72) UNIQUE,
	nickname CHAR (30),
	password CHAR(80),
	language CHAR(2),
	primary key (user_id));";
$result = $db->query($sql);

$sql = "create table forum
	(forum_id INT not null auto_increment,
	user_id INT,
	name CHAR(40),
	subject CHAR(64),
	primary key (forum_id),
	foreign key (user_id) references user(user_id)
	);";
$result = $db->query($sql);

$sql ="create table message 
	(message_id INT not null auto_increment,
	maintxt TEXT,
	user_id INT,
	forum_id INT,
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
	primary key (message_id),
	foreign key (user_id) references user(user_id),
	foreign key (forum_id) references forum(forum_id)
	);";
$result = $db->query($sql);

$sql = "create table rating
	(like_id int not null auto_increment,
	likes INT(9),
	dislikes INT(9),
	message_id int,
	user_id int,
	primary key (like_id),
	foreign key (message_id) references message(message_id) 
	);";
$result = $db->query($sql);
//encode passwords
function makePassword($password){
	$time = (string)time();
	$salt = '$5$round=5000$Onanex'.$time.'CeptioNally58201eninGearlyin$';
	return crypt($password, $salt);
}

//add users

$password = makePassword('password');
$email = 'John@argos.net';
$newUser = new User($db, 'John', $email, $password, 0, 'en', true);
$forum_id = $newUser->addNewForum($db, 'Help me', 'Please help me' );
$newMessage = $newUser->addMessage($db, $forum_id, 'Hi team Theseus, Im new here and dont know what Im doing. Can someone help me?');
echo $newUser->toString();


$password = makePassword('password');
$newUser = new User($db, 'Josh', 'josh@argos.net', $password , 0,'en', true);
$forum_id = $newUser->addNewForum($db, 'Easy as', 'Hints to win');
$newMessage = $newUser->addMessage($db, $forum_id, 'Hi the minotaur is easy to outsmart. you just need to know how');

$password = makePassword('password');
$newUser = new User($db, 'Jason', 'jason@argos.net', $password , 0,'en', true);
$forum_id = $newUser->addNewForum($db, 'Level 2', 'Show me' );
$newMessage = $newUser->addMessage($db, $forum_id, 'Whats with level two. I don;t get it?');

$password = makePassword('password');
$newUser = new User($db, 'Jo', 'jo@argos.net', $password , 0,'en', true);
$forum_id = $newUser->addNewForum($db, 'Dinner', 'What do minotaurs eat?');
$newMessage = $newUser->addMessage($db, $forum_id, 'I mean think about it, what do they eat. people dont just end up in the maze every day!!');

$password = makePassword('password');
$newUser = new User($db, 'James', 'james@argos.net', $password , 0,'en', true);
$forum_id = $newUser->addNewForum($db, 'Vegetarians', 'Minotaurs' );
$newMessage = $newUser->addMessage($db, $forum_id, 'Someone told me there arent any minotaurs and they are cows but thats stupid');

$password = makePassword('password');
$newUser = new User($db, 'Jon', 'jon@argos.net', $password , 0,'en', true);
$forum_id = $newUser->addNewForum($db, 'Lan party', 'Lan party');
$newMessage = $newUser->addMessage($db, $forum_id, 'Can we organise a lan party. I think if there are more of us we can confuse him');

$password = makePassword('password');
$newUser = new User($db, 'Jonnah', 'jonnah@argos.net', $password , 0,'en', true);
$forum_id = $newUser->addNewForum($db, 'Hungry', 'BBQ this saturday' );
$newMessage = $newUser->addMessage($db, $forum_id, 'I just won so to celebrate I want all of you to turn up at a bbq where we can all eat steak');

$password = makePassword('password');
$newUser = new User($db, 'Jim', 'jim@argos.net', $password , 0,'en', true);
$forum_id = $newUser->addNewForum($db, 'Confused', 'Maze maps');
$newMessage = $newUser->addMessage($db, $forum_id, 'I keep getting lost in the maze. Does anyone have maze maps they can give me?');

$password = makePassword('password');
$newUser = new User($db, 'Frank', 'frank@argos.net', $password , 0,'hi', true);
$forum_id = $newUser->addNewForum($db, 'Hindi?', 'Practice hindi people' );
$newMessage = $newUser->addMessage($db, $forum_id, 'I want to talk about the minotaur in hindi');

$password = makePassword('password');
$newUser = new User($db, 'Fran', 'fran@argos.net', $password , 0,'hi', true);
$forum_id = $newUser->addNewForum($db, 'Confused', 'hindi');
$newMessage = $newUser->addMessage($db, $forum_id, 'How do I say Im lost in hindi?');

header('location: index.php');

