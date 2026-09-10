<?
	
	if ($_COOKIE['admin']=="N" || $_COOKIE['admin']==""  || !$_COOKIE['admin']){
		RefreshURL("/admin/php/login.php");
	}
