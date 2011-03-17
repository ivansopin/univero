<?php
	session_start();

	include_once("../components/php/links.php");
	include_once("../components/php/settings.php");

	if (!isset($_POST["login"]) || !isset($_POST["password"]) || $_POST["login"] == "" || $_POST["password"] == "") {
		$_SESSION["error"] = "Please enter both login and password";
		header("Location: ".$LOGIN."/");
		return;
	} else if (!is_string($_POST["login"]) || !is_string($_POST["password"])) {
		$_SESSION["error"] = "Invalid format";
		header("Location: ".$LOGIN."/");
		return;
	} else if (strlen($_POST["login"]) > 15 || strlen($_POST["password"]) > 15 ||
			$_POST["login"] != $APP_LOGIN || $_POST["password"] != $APP_PASSWORD) {
		$_SESSION["error"] = "Incorrect login and/or password:";
		header("Location: ".$LOGIN."/");
		return;
	} else {
		$_SESSION["logged_as_".$APP_LOGIN] = true;
		header("Location: ".$INDEX."/");
		return;
	}
?>