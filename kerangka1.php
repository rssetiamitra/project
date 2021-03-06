<?
// logic layer ==========================================================================================================;
session_start();
session_register("loginInfo");

include "_lib/function/db.php";
include "_lib/function/function.olah_tabel.php";

loadlib("function","function.variabel");
loadlib("function","function.olah_tabel");
loadlib("class","Security");

//$db->debug=true;
$menunya=array();
$submenunya=array();
$sec=new Security($db);

if ($sec->isLoggedIn(session_id()) && $sec->isValidUser() && $sec->isModulAllowed($modul)) {
	$menunya=$sec->hakMenu($modul);
	foreach ($menunya as $k=>$id_dc_menu) {
		$submenunya[$id_dc_menu]=$sec->hakSubMenu($modul,$id_dc_menu);
	}
	
} else {
	$lokasi="login.php";
}

/*
var_dump($sec->isLoggedIn(session_id()));
var_dump($sec->isValidUser());
var_dump($sec->isModulAllowed($modul));
echo "'".$modul."'";
//show($sec);
die();
*/

if (isset($lokasi)) {
	header('Location:'.$lokasi);
}
//print_r($modulnya);
//show($sec);

$userInfo=$sec->get("userInfo");
$id_dd_user=$userInfo["id_dd_user"];
$username=$userInfo["username"];
$no_induk=$userInfo["no_induk"];
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

//$db->debug=true;
$rModul=read_tabel("dc_modul","*","WHERE id_dc_modul=".$modul);
while ($resModul=$rModul->FetchRow()) {
	$icon=$resModul["logo"];
	$nama_modul=$resModul["nama_modul"];
	$id_dc_modul=$resModul["id_dc_modul"];
	$folder = $resModul["folder"];

	$loginInfo["kode_bagian"]=baca_tabel("dc_modul","kode_bagian","WHERE id_dc_modul=".$modul);
	$loginInfo["modul"]=$modul;
	$loginInfo["username"]=$username;
	$loginInfo["id_dd_user"]=$id_dd_user;
	$loginInfo["no_induk"]=$no_induk;
	$loginInfo["nama_pegawai"]=baca_tabel("mt_karyawan","nama_pegawai","WHERE no_induk='".$no_induk."'");
}

// harusnya ngambil dari database..
$nm_pegawai=baca_tabel("mt_karyawan","nama_pegawai","WHERE no_induk=".$no_induk);

//show($menunya,"menunya");
//show($submenunya,"submenunya");
//die();

// end of logic layer ==========================================================================================================;
?>
<!-- presentation layer ------------------------------------------------------------------------------------------------------->
<html>

<head>
	<title><?=$html_title?></title>
	<? include("_inc/tpl_incHtmlHead.php"); ?>
</head>

<body scroll="no" class="bodyKerangka">
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
			<td class="left">
				<table cellpadding="0" cellspacing="0">
				<tr>
<?
			if (count($sec->hakModul())>1) {
?>
					<td><a href="modul.php">Modul</a></td>
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
					<td><a href="tools.php?modul=1">Tools</a></td>
					<?}?>
					<td><a href="#">Informasi</a></td>
					<td><a href="#">Panduan</a></td>
					<td><a href="#" id="profilUser">Profil User</a></td>
					<td><a href="logout.php" id="logout"><span><?=$nm_pegawai?>,&nbsp;&nbsp;</span>Logout</a></td>
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
				<td class="tdlogomodul"><img src="<?=$icon?>" border="0"></td>
				<td class="tdjudulmodul"><?=$nama_modul?></td>
			</tr>
			<tr>
				<td colspan="2"><img src="/_images/mainmenu_part.gif" border="0" width="142" height="3"></td>
			</tr>
			</table>

			<ul id="mnuUtama">
<?
				foreach ($menunya as $k=>$id_dc_menu) {
					$nama_menu=baca_tabel("dc_menu","nama_menu","where id_dc_menu=".$id_dc_menu);
?>
				<li>
					<a class="mnuOrtu" href="#"><?=$nama_menu?></a>
<?
					$byk_submenu=count($submenunya[$id_dc_menu]);
					if ($byk_submenu>0) {
?>
					<ul class="mnuAnak">
<?
						foreach ($submenunya[$id_dc_menu] as $k=>$id_dc_sub_menu) {
							$rSubMenu=read_tabel("dc_sub_menu","url_sub_menu,nama_sub_menu","where id_dc_sub_menu=".$id_dc_sub_menu);
							while ($resSubMenu=$rSubMenu->FetchRow()) {
								$namaSubMenu=$resSubMenu["nama_sub_menu"];
								$urlSubMenu=$resSubMenu["url_sub_menu"];
							}
?>
						<li><a href="<?=$urlSubMenu?>" target="frmIsiUtama"><?=$namaSubMenu?></a></li>
<?
						} // end of foreach ($submenunya[$id_dc_menu] as $k=>$id_dc_sub_menu)
?>
					</ul>
<?
					} // end of if ($byk_submenu>0)
?>
				</li>
<?
				} // end of foreach ($menunya as $k=>$id_dc_menu)
?>
				<!-- 
				<li>
					<a class="mnuOrtu" href="#">MODEL LAYOUT</a>
					<ul class="mnuAnak">
						<li><a href="template_table.php" target="frmIsiUtama">Layout Tabel</a></li>
						<li><a href="#" target="frmIsiUtama">Layout Tab</a></li>
					</ul>
				</li>
				-->
			</ul>

		</td>
		<td width="100%" valign="top">
			<iframe id="isiUtama" src="<?= isset($folder) ? "{$folder}/" : "home.php" ?>" frameborder="0" name="frmIsiUtama" ></iframe>
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