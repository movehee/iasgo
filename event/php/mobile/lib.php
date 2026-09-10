<?
header("Content-Type: text/html; charset=UTF-8");
@error_reporting(E_ALL ^ E_NOTICE);
@extract($HTTP_GET_VARS);
@extract($HTTP_POST_VARS);
@extract($HTTP_SERVER_VARS);
@extract($HTTP_ENV_VARS);
$HTTP_SESSION_VARS = $_SESSION;
@extract($HTTP_SESSION_VARS);
@extract($_FILES);

if(is_file($_SERVER['DOCUMENT_ROOT'] . "/php/mobile/func/include.function.php")) include_once $_SERVER['DOCUMENT_ROOT'] . "/php/mobile/func/include.function.php";
if(is_file($_SERVER['DOCUMENT_ROOT'] . "/php/mobile/func/include.connect.php")) include_once $_SERVER['DOCUMENT_ROOT'] . "/php/mobile/func/include.connect.php";
if(is_file($_SERVER['DOCUMENT_ROOT'] . "/php/mobile/func/config.php")) include_once $_SERVER['DOCUMENT_ROOT'] . "/php/mobile/func/config.php";
?>
