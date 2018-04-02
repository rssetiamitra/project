<?
// logic layer ==========================================================================================================;
session_start();

////////////////////////
unset($_SESSION["pilihLoket"]);
////////////////////////

include "_lib/function/db_login.php";

loadlib("function","function.variabel");
loadlib("function","function.olah_tabel");
loadlib("function","function.datetime");
loadlib("class","Security");

$modulnya=array();
$modularnya=array();
$sec=new Security($db);

if ($sec->isLoggedIn(session_id())) {
	if ($sec->isValidUser()) {
		$modularnya=$sec->hakModular();

		foreach ($modularnya as $k=>$id_dc_modular) {
			$modulnya[$id_dc_modular]=$sec->hakModul($id_dc_modular);
		}

		if (count($modulnya,COUNT_RECURSIVE)==1) {
			$lokasi="kerangka.php";
		}

	} else {
		$lokasi="login.php";
	}
} else {
	$lokasi="login.php";
}
if (isset($lokasi)) {
	header('Location:'.$lokasi);
}

$userInfo=$sec->get("userInfo");
$id_dd_user=$userInfo["id_dd_user"];
$username=$userInfo["username"];
$no_induk=$userInfo["npp"];
$id_dd_jenis_user = $userInfo["id_dd_jenis_user"];
$no_id_jenis = $userInfo["no_id_jenis"];
if ($id_dd_jenis_user!="1"){
	$hasil_admin = read_tabel("mt_karyawan","*","WHERE no_induk='".$userInfo["no_induk"]."'");
	$nama_user = $hasil_admin ->fields["nama_pegawai"];
} else {
	$nama_user = "Administrator";
}

// seharusnya pake login_time

//$status_tgl=$userInfo["status_tgl"];

// backdoor :D
$q=read_tabel("log_user_login","logoff_time,ip_address","WHERE logoff_time IS NOT NULL AND session_id='".session_id()."' ORDER BY logoff_time DESC");
while ($w=$q->FetchRow()) {
	$status_tgl=$w["logoff_time"];
	$ip=$w["ip_address"];
}
list($tanggal,$waktu)=split('[ ]',$status_tgl);
$halo=greeting(date("H"));
$npp=$userInfo["npp"];

// harusnya ngambil dari database..
$nm_pegawai=baca_tabel("mt_karyawan","nama_pegawai","WHERE no_induk='".$no_induk."'");
$kd_bagian=baca_tabel("mt_karyawan","kode_bagian","WHERE no_induk='".$no_induk."'");

// seharusnya pake ip log seblmnya
//$ip=$REMOTE_ADDR;

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


// end of logic layer ==========================================================================================================;
?>
<!-- presentation layer ------------------------------------------------------------------------------------------------------->
<html>

<head>
	<title><?=$html_title?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="_css/main.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="_images/icons/favicon.ico" />
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
				<div class="judul2" ><?=$nama_perusahaan?></div>
			</td>
			<td class="tdJudul2">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div id="topmenu">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="right">
				<table cellpadding="0" cellspacing="0">
				<tr>
					<?if($AV_CONF["etc"]["development"]==true){?>
					<!-- <td><a href="tools.php?modul=1">Tools</a></td> -->
					<?}?>
					<!--<td><a href="#">Informasi</a></td>
					<td><a href="#">Forum</a></td>
					<td><a href="#">Panduan</a></td>
					<td><a href="#" id="profilUser">Profil User</a></td>-->
					<td><a href="logout.php" id="logout"><span><?=$nama_user?>,&nbsp;&nbsp;</span>Logout</a></td>
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
			<td class="right" >
				<table cellpadding="0" cellspacing="0" width="100%" >
				<tr>
					<td>User ID</td>
					<td>:</td>
					<td><b><?=$username?></b>&nbsp;&nbsp;&nbsp;&nbsp;No Pegawai : <?=$npp?></td>
				</tr>
				<tr>
					<td>Log In sebelumnya</td>
					<td>:</td>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" width="50%" >
						<tr>
							<td>Tanggal</td>
							<td>:</td>
							<td><b><?=date2str($tanggal)?></b></td>
						</tr>
						<tr>
							<td>Jam</td>
							<td>:</td>
							<td><b><?=$waktu?></b></td>
						</tr>
						<tr>
							<td>IP Address</td>
							<td>:</td>
							<td><b><?=$ip?></b></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</div>

	<div id="isiUtama" style="background:#F2F5FA url('../_images/login_gradback.gif') repeat-x left top;">
		<table cellpadding="0" cellspacing="0" align="center" id="modul" border="0" >

		<!-- Modified by YOE on 2006-06-19 08:03 AM --------------------------------------->
<?
		foreach ($modularnya as $k=>$id_dc_modular) {
			$nama_modular=baca_tabel("dc_modular","nama_modular","WHERE id_dc_modular=".$id_dc_modular);
?>
		<tr>
			<td class="modulBagian"><div><?=$nama_modular?></div></td>
			<td >
<?
				foreach ($modulnya[$id_dc_modular] as $k=>$id_dc_modul) {
					
					$rModul=read_tabel("dc_modul","*","WHERE id_dc_modul=".$id_dc_modul);
					
					while ($resModul=$rModul->FetchRow()) {
						$icon=$resModul["logo"];
						$arrIcon = explode(".",$icon);
						$icon_hover = $arrIcon[0]."_hover.".$arrIcon[1];
						$nama_modul=$resModul["nama_modul"];
						$id_dc_modul=$resModul["id_dc_modul"];
					}
?>
				<div style="text-align:center;"><a href="kerangka.php?modul=<?=$id_dc_modul?>" onMouseOver="rollover('<?=$nama_modul?>', '<?=$icon_hover?>'); return false" onMouseOut="rollover('<?=$nama_modul?>', '<?=$icon?>'); return false"><img src="<?=$icon?>" name="<?=$nama_modul?>" alt="<?=$nama_modul?>" style="text-shadow: 2px 2px 2px #B2B1AF;filter: progid:DXImageTransform.Microsoft.Shadow(direction=135,strength=3,color=B2B1AF);"><br/><?=$nama_modul?></a></div>
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
function rollover(imgName, imgSrc) {
    if (document.images) {
        document.images[imgName].src = imgSrc;
    }
}
</script>
</body>

</html>