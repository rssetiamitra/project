<?
// logic layer ==========================================================================================================;
session_start();
include "_lib/function/db.php";
loadlib("function","function.datetime");

// harusnya ngambil dari database..
//$nm_pegawai="Freddy Krueger";
$nm_pegawai = $loginInfo["nama_user"];
$halo=greeting(date("H"));


// end of logic layer ==========================================================================================================;
?>
<!-- presentation layer ------------------------------------------------------------------------------------------------------->
<html>

<head>
	<title>Averin Intranet Application Framework - Interface</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="_css/main.css" rel="stylesheet" type="text/css">
	<script language="JavaScript" type="text/JavaScript" src="_js/aCore.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="_js/main.js"></script>
</head>

<body scroll="no">
	
	<div id="barJudul"><span class="normal"><?=$halo?>,</span> <?=$nm_pegawai?></div>
	
</body>

</html>