<?
// logic layer ==========================================================================================================;
session_start();
session_register("loginInfo");

include "_lib/function/db.php";
include "_lib/function/function.olah_tabel.php";

loadlib("function","function.variabel");
loadlib("function","function.olah_tabel");
loadlib("class","Security");


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

if (isset($lokasi)) {
	header('Location:'.$lokasi);
}
//print_r($modulnya);
//show($sec);

$userInfo=$sec->get("userInfo");
$id_dd_user=$userInfo["id_dd_user"];
$username=$userInfo["username"];
$no_induk=$userInfo["no_induk"];
$id_dd_jenis_user = $userInfo["id_dd_jenis_user"];
$no_id_jenis = $userInfo["no_id_jenis"];
$id_dd_puskesmas = $userInfo["id_dd_puskesmas"];
//$=$userInfo[""];

switch ($id_dd_jenis_user){
	case "1" :
		$hasil_admin = read_tabel("mt_karyawan","*","WHERE no_induk = $no_id_jenis");
		$nama_user = $hasil_admin ->fields["nama_pegawai"];
		//$id_dd_sekolah = $hasil_guru ->fields["id_dd_sekolah"];
		break;
	case "2":
		$hasil_dokter = read_tabel("mt_karyawan","*","WHERE no_induk = $no_id_jenis");
		$nama_user = $hasil_dokter ->fields["nama_pegawai"];
		break;
	case "3":
		$hasil_karyawan = read_tabel("mt_karyawan","*","WHERE no_induk = $no_id_jenis");
		$nama_user = $hasil_karyawan->fields["nama_pegawai"];
		break;
	default :
		$nama_user = "Administrator";
}

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

if ($id_dd_puskesmas!=""){
$s=read_tabel("dd_puskesmas","*", "WHERE id_dd_puskesmas=$id_dd_puskesmas");
while ($resPuskesmas=$s->FetchRow()) {
	$id_dd_puskesmas = $resPuskesmas["id_dd_puskesmas"];
	$kode_puskesmas = $resPuskesmas["kode_puskesmas"];
	$kode_level_puskesmas = $resPuskesmas["kode_level_puskesmas"];
	$nama_puskesmas = $resPuskesmas["nama_puskesmas"];
	$alamat_puskesmas = $resPuskesmas["alamat"];
	$id_dc_kelurahan_puskesmas = $resPuskesmas["id_dc_kelurahan"];
	$id_dc_kecamatan_puskesmas = $resPuskesmas["id_dc_kecamatan"];
	$id_dc_kota_puskesmas = $resPuskesmas["id_dc_kota"];
	$id_dc_propinsi_puskesmas = $resPuskesmas["id_dc_propinsi"];
	$telepon_puskesmas = $resPuskesmas["telepon"];
	$fax_puskesmas = $resPuskesmas["fax"];
	$kode_pos_puskesmas = $resPuskesmas["kode_pos"];
	$kode_jenis_puskesmas = $resPuskesmas["kode_jenis_puskesmas"];
	$kode_status_puskesmas = $resPuskesmas["kode_status_puskesmas"];
	$logo_puskesmas = $resPuskesmas["logo"];
	$foto_puskesmas = $resPuskesmas["foto_puskesmas"];
	$peta_lokasi_puskesmas = $resPuskesmas["peta_lokasi"];
	$keterangan_puskesmas = $resPuskesmas["keterangan"];
}
}

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
	//$loginInfo["nama_pegawai"]=baca_tabel("mt_karyawan","nama_pegawai","WHERE no_induk='".$no_induk."'");
	$loginInfo["nama_pegawai"]="Budi";
	$loginInfo["kode_puskesmas"]=$kode_puskesmas;
	$loginInfo["ip_address"]=$REMOTE_ADDR;
	$loginInfo["id_dc_modul"] = $id_dc_modul;
}

	$loginInfo["nama_puskesmas"] = $nama_puskesmas;
	$loginInfo["id_dd_jenis_user"] = $id_dd_jenis_user;
	$loginInfo["no_id_jenis"] = $no_id_jenis;
	$loginInfo["id_dd_puskesmas"] = $id_dd_puskesmas;
	$loginInfo["nama_user"]	= $nama_user;

	$nm_pegawai=$nama_user;


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
			<td class="tdLogo"><img src="<?=$logo_small?>" border="0"></td>
			<td class="tdJudul1">
				<div class="judul1"><?=$nama_aplikasi?></div>
				<div class="judul2"><?=$nama_perusahaan?></div>
			</td>
			<td class="tdJudul2"><img src="/_images/header_logosirs.gif" border="0"></td>
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
			//if (count($sec->hakModul())>1) {
?>
					<td><a href="kerangka.php?modul=<?=$loginInfo["id_dc_modul"]?>">Modul</a></td>
<?
			//} else {
				//echo "&nbsp;";
			//} // end of if (count($sec->hakModul())>1)
?>
				</tr>
				</table>
			</td>
			<td class="right">
				<table cellpadding="0" cellspacing="0">
				<tr>
					<?if($AV_CONF["etc"]["development"]==true){?>
					<td><a href="tools.php">Tools</a></td>
					<td><a href="#" onclick="openPop('averin_view.php','500','300');">Panduan</a></td>
					<?}?>
					<?if(true){?>
					<td><a href="profil.php">Informasi</a></td>
					<td><a href="#" id="profilUser">Profil User</a></td>
					<?}?>
					<td><a href="logout.php" id="logout"><span><?=ucwords($nm_pegawai)?>,&nbsp;&nbsp;</span>Logout</a></td>
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
				<td class="tdjudulmodul">Profil</td>
			</tr>
			<tr>
				<td colspan="2"><img src="/_images/mainmenu_part.gif" border="0" width="142" height="3"></td>
			</tr>
			</table>

			<ul id="mnuUtama">
				<li>
					<a class="mnuOrtu" href="#">PROFIL</a>
					<ul class="mnuAnak">
						<li><a href="99_averin/sekilas.php" target="frmIsiUtama">Sekilas Averin</a></li>
						<li><a href="99_averin/visimisi.php" target="frmIsiUtama">Visi Misi</a></li>
						<li><a href="99_averin/sdm.php" target="frmIsiUtama">Sumber Daya Manusia</a></li>
						<li><a href="99_averin/callus.php" target="frmIsiUtama">Hubungi Kami</a></li>
					</ul>
				</li>
				<li>
					<a class="mnuOrtu" href="#">PRODUK</a>
					<ul class="mnuAnak">
						<li><a href="99_averin/sirs.php" target="frmIsiUtama">Averin SIRs</a></li>
						<li><a href="99_averin/klinik.php" target="frmIsiUtama">Averin Klinik</a></li>
						<li><a href="99_averin/icd10.php" target="frmIsiUtama">Averin ICD-10</a></li>
						<li><a href="99_averin/arms.php" target="frmIsiUtama">Averin ARMs</a></li>	
						<li><a href="99_averin/imc.php" target="frmIsiUtama">IMC</a></li>	
						<li><a href="99_averin/mgedung.php" target="frmIsiUtama">Management Gedung</a></li>	
						<li><a href="99_averin/sitda.php" target="frmIsiUtama">SITDA</a></li>	
					</ul>
				</li>
				<li>
					<a class="mnuOrtu" href="#">Developer Team</a>
					<ul class="mnuAnak">
						<li><a href="99_averin/dev_team.php" target="frmIsiUtama">Averin SIRs</a></li>
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