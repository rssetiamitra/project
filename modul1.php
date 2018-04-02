<?
// logic layer ==========================================================================================================;
session_start();

////////////////////////
unset($_SESSION["pilihLoket"]);
////////////////////////

include "_lib/function/db1.php";

loadlib("function","function.variabel");
loadlib("function","function.olah_tabel");
loadlib("function","function.datetime");
loadlib("class","AvSecurity");

//$db->debug=true;
$modulnya=array();
$modularnya=array();
$sec=new AvSecurity($db);

if ($sec->isLoggedIn()) {
	$modularnya=$sec->hakModular();
	//show($modularnya,"modularnya");

	foreach ($modularnya as $k=>$id_dc_modular) {
		$modulnya[$id_dc_modular]=$sec->hakModul($id_dc_modular);
	}

	if (count($modulnya,COUNT_RECURSIVE)==1) {
		$lokasi="kerangka1.php";
	}
} else {
	$lokasi="login1.php";
}
if (isset($lokasi)) {
	header('Location:'.$lokasi);
}

//print_r($modulnya);
//show($sec);

$userInfo=$sec->get("userInfo");
$id_dd_user=$userInfo["id_dd_user"];
$username=$userInfo["username"];
$no_induk=$userInfo["npp"];
//show($userInfo);

// seharusnya pake login_time
$status_tgl=$userInfo["status_tgl"];
list($tanggal,$waktu)=split('[ ]',$status_tgl);
$halo=greeting(date("H"));
$npp=$userInfo["npp"];

// harusnya ngambil dari database..
//$nm_pegawai=baca_tabel("mt_karyawan","nama_pegawai","WHERE no_induk=".$no_induk);

// seharusnya pake ip log seblmnya
$ip=$REMOTE_ADDR;

//$=$userInfo[""];

$r=read_tabel("dd_konfigurasi","*");
while ($konf=$r->FetchRow()) {
	$nama_perusahaan=$konf["nama_perusahaan"];
	$nama_aplikasi=$konf["nama_aplikasi"];
	$alamat=$konf["alamat"];
	$kota=$konf["kota"];
	$kode_pos=$konf["kode_pos"];
	$telpon=$konf["telpon"];
	$fax=$konf["fax"];
	$logo_small=$konf["logo_small"];
	$html_title=$konf["html_title"];
}

// ------------------- sementara, buat mengakomodasi 'module grouping' ----------------
/*
foreach ($modulnya as $k=>$id_dc_modul) {
	$rModular=read_tabel("dc_modular","*","WHERE id_dc_modular=".$id_dc_modul);
	while ($resModular=$rModular->FetchRow()) {
		$icon=$resModular["logo"];
		$nama_modul=$resModular["nama_modul"];
		$id_dc_modul=$resModular["id_dc_modul"];
	}
} // end of foreach ($modulnya as $k=>$id_dc_modul)
reset($modulnya);
*/
// ---------------- end of sementara, buat mengakomodasi 'module grouping' ----------------


// end of logic layer ==========================================================================================================;
?>
<!-- presentation layer ------------------------------------------------------------------------------------------------------->
<html>

<head>
	<title><?=$html_title?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="_css/main.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" type="text/JavaScript" src="_js/aCore.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="_js/main.js"></script>
</head>

<body scroll="no" class="bodyModul">
	<div id="topLayer" class="loading"></div>

	<!-- Header ################################################################-->
	<div id="header">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="tdLogo"><img src="<?=$logo_small?>" border="0"></td>
			<td class="tdJudul1">
				<div class="judul1"><?=$nama_aplikasi?></div>
				<div class="judul2"><?=$nama_perusahaan?></div>
			</td>
			<td class="tdJudul2"><img src="/_images/header_logosirsrsud.gif" border="0"></td>
		</tr>
		</table>
	</div>

	<div id="topmenu">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="right">
				<table cellpadding="0" cellspacing="0">
				<tr>
					<td><a href="#">Informasi</a></td>
					<td><a href="#">Forum</a></td>
					<td><a href="#">Panduan</a></td>
					<td><a href="#" id="profilUser">Profil User</a></td>
					<td><a href="logout.php" id="logout"><span><?=$nm_pegawai?>,&nbsp;&nbsp;</span>Logout</a></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</div>

	<div id="modulHeader">
		<table cellpadding="0" cellspacing="0" width="100%" class="modulTable">
		<tr>
			<td class="left">
				<div class="atas"><?=$halo?></div>
				<div class="bawah"><?=$nm_pegawai?></div>
			</td>
			<td class="right">
				<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td>User ID</td>
					<td>:</td>
					<td><b><?=$username?></b>&nbsp;&nbsp;&nbsp;&nbsp;No Pegawai : <?=$npp?></td>
				</tr>
				<tr>
					<td>Log In sebelumnya</td>
					<td>:</td>
					<td>
						Tanggal : <b><?=$tanggal?></b><br>
						Jam : <b><?=$waktu?></b><br>
						IP Address : <b><?=$ip?></b>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</div>

	<div id="isiUtama">
		<table cellpadding="0" cellspacing="0" align="center" id="modul">

		<!-- Modified by YOE on 2006-06-19 08:03 AM --------------------------------------->
<?
		foreach ($modularnya as $k=>$id_dc_modular) {
			$nama_modular=baca_tabel("dc_modular","nama_modular","WHERE id_dc_modular=".$id_dc_modular);
?>
		<tr>
			<td class="modulBagian"><div><?=$nama_modular?></div></td>
			<td>
<?
				foreach ($modulnya[$id_dc_modular] as $k=>$id_dc_modul) {
					//$db->debug=true;
					$rModul=read_tabel("dc_modul","*","WHERE id_dc_modul=".$id_dc_modul);
					while ($resModul=$rModul->FetchRow()) {
						$icon=$resModul["logo"];
						$nama_modul=$resModul["nama_modul"];
						$id_dc_modul=$resModul["id_dc_modul"];
					}
?>
				<div><a href="kerangka.php?modul=<?=$id_dc_modul?>"><img src="<?=$icon?>"><?=$nama_modul?></a></div>
<?
				} // end of foreach ($modulnya as $k=>$id_dd_modul)
?>
			</td>
		</tr>
<?
		} // end of foreach ($modularnya as $k=>$id_dc_modular)
?>
		<!-- End of YOE's modification -------------------------------------------------------->

		</table>
	</div>



<!-- ######################################################################-->
<script language="JavaScript" type="text/javascript">

window.onload = function()
{
	initKerangka()
}

</script>
</body>

</html>