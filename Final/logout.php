<?php
include_once("includes/connection.php");
include_once("includes/functions.php");

unset($_SESSION["logged_user_id"]);
unset($_SESSION["logged_user_name"]);
unset($_SESSION["logged_user_email_address"]);

myFormMsg("index.php","logout","");
exit;