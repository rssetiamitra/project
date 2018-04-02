<?
// logic layer ==========================================================================================================;
session_start();
include "_lib/function/db.php";
include "_lib/function/function.olah_tabel.php";

loadlib("function","function.variabel");
loadlib("function","function.olah_tabel");
loadlib("class","Security");

$menunya=array();
$submenunya=array();
$sec=new Security($db);

if ($sec->isLoggedIn(session_id()) && $sec->isValidUser()) {
	
} else {
	$lokasi="login.php";
}
if (isset($lokasi)) {
	header('Location:'.$lokasi);
}
//print_r($modulnya);
//show($sec);

$userInfo=$sec->get("userInfo");
$id_dd_user=$userInfo["id_dd_user"];
$username=$userInfo["username"];
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

//show($menunya,"menunya");
//show($submenunya,"submenunya");
//die();

// end of logic layer ==========================================================================================================;
?>
<!-- presentation layer ------------------------------------------------------------------------------------------------------->
<html>

<head>
	<title>Averin Intranet Application Framework - Interface</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="_css/main.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" type="text/JavaScript" src="_js/aCore.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="_js/main.js"></script>
</head>

<body scroll="no" class="bodyKerangka">
	<div id="topLayer" class="loading"></div>

	<!-- Header ################################################################-->
	<div id="header">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="tdLogo"><img src="/_images/logo_rssm_small_default.png" border="0"></td>
			<td class="tdJudul1">
				<div class="judul1">Sistem Informasi Rumah Sakit</div>
				<div class="judul2">Rumah Sakit Setia Mitra</div>
			</td>
			<td class="tdJudul2"><img src="/_images/header_logosirsrsud.gif" border="0"></td>
		</tr>
		</table>
	</div>

	<div id="topmenu">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="left">
				<table cellpadding="0" cellspacing="0">
				<tr>
<?
			if (count($sec->hakModul())>1) {
?>
					<td><a href="kerangka.php?modul=<?=$modul?>">Modul</a></td>
<?
			} else {
				echo "&nbsp;";
			} // end of if (count($sec->hakModul())>1)
?>
				</tr>
				</table>
			</td>
			<td class="right">
				<table cellpadding="0" cellspacing="0">
				<tr>
					<?if($AV_CONF["etc"]["development"]==true){?>
					<td><a href="tools.php">Tools</a></td>
					<?}?>
					<td><a href="#">Informasi</a></td>
					<td><a href="#">Panduan</a></td>
					<td><a href="#" id="profilUser">Profil User</a></td>
					<td><a href="#" id="logout"><span>Freddy Krueger,&nbsp;&nbsp;</span>Logout</a></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</div>

	<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td valign="top" id="mainmenu">

			<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="tdlogomodul"><img src="/_images/temp_logomodul.gif" border="0"></td>
				<td class="tdjudulmodul">Template</td>
			</tr>
			<tr>
				<td colspan="2"><img src="/_images/mainmenu_part.gif" border="0" width="142" height="3"></td>
			</tr>
			</table>

			<ul id="mnuUtama">

				<li>
					<a class="mnuOrtu" href="#">FORM</a>
					<ul class="mnuAnak">
						<li><a href="_tools/form/formInputManual.php" target="frmIsiUtama">Form Input Manual</a></li>
						<li><a href="_tools/form/formInputDB.php" target="frmIsiUtama">Form Input DB</a></li>
						<li><a href="_tools/form/formEditDB.php" target="frmIsiUtama">Form Edit DB</a></li>
						<li><a href="_tools/form/formLaporanUtama.php" target="frmIsiUtama">Form Laporan Utama</a></li>
						<li><a href="_tools/form/formLaporanInclude.php" target="frmIsiUtama">Form Laporan Include</a></li>
					</ul>
				</li>
				<li>
					<a class="mnuOrtu" href="#">SUBMIT</a>
					<ul class="mnuAnak">
						<li><a href="_tools/submit/input.php" target="frmIsiUtama">Input Submit</a></li>
						<li><a href="_tools/submit/edit.php" target="frmIsiUtama">Edit Submit</a></li>
						<li><a href="_tools/submit/delete.php" target="frmIsiUtama">Delete Submit</a></li>						
					</ul>
				</li>
				<li>
					<a class="mnuOrtu" href="#">TAMPILAN</a>
					<ul class="mnuAnak">
						<li><a href="_tools/tampilan/sederhana.php" target="frmIsiUtama">Tampilan Sederhana</a></li>
						<li><a href="_tools/tampilan/biasa.php" target="frmIsiUtama">Tampilan Biasa</a></li>
						<li><a href="_tools/tampilan/pagging.php" target="frmIsiUtama">Tampilan Paging</a></li>						
					</ul>
				</li>
				<li>
					<a class="mnuOrtu" href="#">CETAKAN</a>
					<ul class="mnuAnak">
						<!-- <li><a href="_tools/cetakan/formCetakanPHP.php" target="frmIsiUtama">Cetakan HTML (PHP)</a></li> -->
						<li><a href="_tools/cetakan/formCetakanJS.php" target="frmIsiUtama">Cetakan HTML(JS)</a></li>
						<li><a href="_tools/cetakan/formCetakanPDF.php" target="frmIsiUtama">Cetakan PDF</a></li>	
						<li><a href="_tools/cetakan/formCetakanXLS.php" target="frmIsiUtama">Cetakan Excel</a></li>	
						<li><a href="_tools/cetakan/formCetakanWORD.php" target="frmIsiUtama">Cetakan MS Word</a></li>	
					</ul>
				</li>
				<li>
					<a class="mnuOrtu" href="#">TEMPLATE</a>
					<ul class="mnuAnak">
						<li><a href="_template/general/" target="frmIsiUtama">Template General</a></li>	
						<li><a href="_template/spesifik/" target="frmIsiUtama">Template Spesifik</a></li>	
					</ul>
				</li>
				<li>
					<a class="mnuOrtu" href="#">UJICOBA FILE</a>
					<ul class="mnuAnak">
						<li><a href="_ujicoba/php/" target="frmIsiUtama">Ujicoba File PHP</a></li>	
						<li><a href="_ujicoba/html/" target="frmIsiUtama">Ujicoba File HTML</a></li>
						<li><a href="_ujicoba/js/" target="frmIsiUtama">Ujicoba File JavaScript</a></li>
					</ul>
				</li>
				<li>
					<a class="mnuOrtu" href="#">JAVASCRIPT</a>
					<ul class="mnuAnak">
						<li><a href="_tools/javascript/contoh/" target="frmIsiUtama">Contoh Source</a></li>
						<li><a href="_tools/javascript/lain_lain/" target="frmIsiUtama">Lain-Lain</a></li>	
					</ul>
				</li>
				<li>
					<a class="mnuOrtu" href="#">EKSEKUSI SQL</a>
					<ul class="mnuAnak">
						<li><a href="_tools/eksekusi/" target="frmIsiUtama">Eksekusi SQL</a></li>
					</ul>
				</li>
			</ul>

		</td>
		<td width="100%" valign="top">
			<iframe style="width:100%;" id="isiUtama" src="home.php" frameborder="0" name="frmIsiUtama" ></iframe>
		</td>
	</tr>
	</table>

<!-- ######################################################################-->
<script language="JavaScript" type="text/javascript">

window.onload = function()
{
	initKerangka()
}

</script>
</body>

</html>