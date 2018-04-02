<?
// logic layer ==========================================================================================================;
session_start();
if (!defined("LOGIN_PAGE")) define("LOGIN_PAGE",true);

include "_lib/function/db_login.php";
include "_lib/function/function.olah_tabel.php";

$txt_name=$_POST["txt_name"];
$txt_pass=$_POST["txt_pass"];
loadlib("class","Security");
loadlib("function","function.variabel");
//$db->debug=true;


	
$modulnya=array();
$sec=new Security($db,$txt_name,$txt_pass);

if ($sec->isValidUser()) {
	$modulnya=$sec->hakModul();

	if (count($modulnya)==1) {
		$lokasi="kerangka.php?modul=".$modulnya[0];
	
	} else {
		$lokasi="modul.php";
	}

	if (!session_is_registered("loginInfo")) {
		session_register("loginInfo");
	}
	
} else {
	$lokasi="login.php";
}

// end of logic layer ==========================================================================================================;
?>
<!-- presentation layer ------------------------------------------------------------------------------------------------------->
<html>
<head>
<title></title>
</head>
<body onLoad="window.location.href='<?=$lokasi?>';"> <!--  -->
</body>
</html>