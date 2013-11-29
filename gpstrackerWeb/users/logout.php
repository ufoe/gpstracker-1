<?php
ob_start();
session_start();

unset ($_SESSION['session_id']);
require_once("settings.inc.php");
session_destroy();

header("Location: login.php?action=login");
