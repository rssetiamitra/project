<?
// logic layer ==========================================================================================================;
session_start();

include "_lib/function/db.php";

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

<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="_css/main.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="_images/icons/favicon.ico" />
	<script language="JavaScript" type="text/JavaScript" src="_js/jquery/jquery-1.8.1.min.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="_js/jquery.screwdefaultbuttonsV2.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="_js/aCore.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="_js/main.js"></script>

	<script src="js/jquery.screwdefaultbuttonsV2.js"></script>
	
	
	<script type="text/javascript">
		$(function(){
		
			$('input:radio').screwDefaultButtons({
				width: 43,
				height: 43
			});
		
		});
	</script>
	
	<style>
	
		body {
			font-family: tahoma, ariel, sans-serif;
			letter-spacing: 0.1em;
			color: #444;
		}
		
		.styledRadio {
			display: inline-block;
		}
		
		
		.example {
			padding: 50px 0 0 20px;
		}
		
		label {
			line-height: 43px;
			font-size: 20px;
			vertical-align: 14px;
			padding-right: 20px;
		}
		
		button{
			display: block;
		}
	

#clearCss td{}
	</style>
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
			<td class="tdJudul2"><img src="/_lib/_av/hls" border="0"></td>
		</tr>
		</table>
	</div>

	<div id="topmenu">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="right">
				<table cellpadding="0" cellspacing="0">
				<tr>
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
		<form method="post" action="/10_kasir/pilih_loket_act.php">
		<div class="example">
		<table cellpadding="0" cellspacing="0" align="center" id="modul" border="0">
		<tr>
			<td class="modulBagian"><div>PILIH LOKET</div></td>
			<td>
				<table id="clearCss">
				<tr>
<?					
					$rLoket=read_tabel("ks_mt_loket","*","ORDER BY nama_loket");
					
					$l=0;
					while ($resLoket=$rLoket->FetchRow()) {
						$l++;
						$nama_loket=$resLoket["nama_loket"];
						$kode_loket=$resLoket["kode_loket"];
?>

					<td>
						<input type="radio" name="loket" id="<?=$nama_loket?>" data-sdb-image="url('_images/icons/kasir1.gif')" value="<?=$kode_loket?>" <?=$l=='1'?'checked':''?>>
						<label for="<?=$nama_loket?>"><?=$nama_loket?></label>
					</td>

<?
					} //while ($resLoket=$rLoket->FetchRow()) {
?>
				</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td class="modulBagian"><div>PILIH SHIFT</div></td>
			<td>
				<table id="clearCss">
				<tr>
<?					
					$rShift=read_tabel("ks_mt_shift","*","ORDER BY nama_shift");
					
					$s=0;
					while ($resShift=$rShift->FetchRow()) {
						$s++;
						$nama_shift=$resShift["nama_shift"];
						$kode_shift=$resShift["kode_shift"];
?>

					<td>
						<input type="radio" name="shift" id="<?=$nama_shift?>" data-sdb-image="url('_images/icons/kasir1.gif')" value="<?=$kode_shift?>" <?=$s=='1'?'checked':''?>>
						<label for="<?=$nama_shift?>"><?=$nama_shift?></label>
					</td>

<?
					} //while ($resShift=$rShift->FetchRow()) {
?>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><br><br>
				<input type="submit" name="Submit" value="Submit" class="submit01" onclick="javascript: return validasiForm(this);">
				<input type="hidden" name="halAsal" value="<?= $halAsal ?>"/>
			</td>
		</tr>
		</table>
		</div>
		</form>
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