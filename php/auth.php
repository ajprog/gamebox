<?php
	//Start session
	session_start();
	
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_PLAYER_ID']) || 
          (trim($_SESSION['SESS_PLAYER_ID']) == '')) {
		header("location: access-denied.html");
		exit();
	} else {
    $welcome = $_SESSION['SESS_FIRST_NAME'];
  }
?>