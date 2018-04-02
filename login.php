<?
// logic layer ==========================================================================================================;
include "_lib/function/db_login.php";
//include "_lib/function/db.php";
include "_lib/function/function.olah_tabel.php";


$r=read_tabel("dd_konfigurasi","*");
while ($konf=$r->FetchRow()) {
	$nama_perusahaan=$konf["nama_perusahaan"];
	$nama_aplikasi=$konf["nama_aplikasi"];
	$alamat=$konf["alamat"];
	$kota=$konf["kota"];
	$kode_pos=$konf["kode_pos"];
	$telpon=$konf["telpon"];
	$fax=$konf["fax"];
	$logo=$konf["logo"];
	$html_title=$konf["html_title"];
}

// end of logic layer ==========================================================================================================;
?>
<!-- presentation layer ------------------------------------------------------------------------------------------------------->
<html>

<head>
	<title><?=$html_title?><?=$alert==1 ? "Intruder !" : ""?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<? include("_inc/tpl_incHtmlHead.php"); ?>
	<link rel="shortcut icon" href="_images/icons/favicon.ico" />
</head>

<body scroll="no" class="bodyLogin">
	<div id="topLayer" class="loading"></div>
	<? if ($AV_CONF["etc"]["development"]==true){?>
	<div style="position:absolute;left:400px;padding:10px;background:white;width:250px;text-align:center"><b>Perhatian</b> :<br/>
Server Ini Adalah Server untuk Development<br/><span style="color:blue">(<?="DATABASE: ".$AV_CONF['db']['type']?>)</span></div>
	<?}?>
	<? if ($err==1): ?>
	<div style="position:absolute;left:400px;padding:10px;background:white;width:250px;text-align:center"><b>ERROR !</b> :<br/>
Username/Password Salah.<br/><span style="color:blue">(<?=strtoupper($u)?>)</span></div>
	<? endif; //if ($err==1): ?>
	<table cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td align="center">
		
		<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="loginFrame">
				<div class="top"></div>
				<div class="yellow">&nbsp;</div>
				<div class="login">
					<form name="loginform" method="post" action="login_act.php" class="statusoff"> <!-- target="login" modul.php -->
						<table cellpadding="0" cellspacing="0" align="right">
						<tr>
							<td align="right">User ID</td>
							<td><input type="text" name="txt_name" style="width:140px "></td>
						</tr>
						<tr>
							<td align="right">Password</td>
							<td><input type="password" name="txt_pass" style="width:140px "></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input name="Submit2" type="reset" class="login01" value="Reset" style="width:60px">
								<input name="submit" type="submit" class="login01" value="Submit" style="width:76px">
							</td>
						</tr>
						</table>
						<div></div><!-- Status Login -->
					</form>

				</div>
				<div class="white">
				
					<table cellpadding="0" cellspacing="0" style="background-image:url(<?=$logo?>);">
					<tr>
						<td class="alamat">
							<div class="sirs"><?=$nama_aplikasi?></div>
							<div class="rs"><?=$nama_perusahaan?></div>
							<?=$alamat?><br>
							<?=$kota?> - <?=$kode_pos?><br>
							Telp. <?=$telpon?><br>
							Fax. <?=$fax?><br>
						</td>
						<td>&nbsp;</td>
					</tr>
					</table>

				</div>
			</td>
			<td class="loginShadow"><img src="/_images/login_spacer.gif" border="0" width="3" height="5"></td>
		</tr>
		<tr>
			<td colspan="2" class="loginShadow"><img src="/_images/login_spacer.gif" border="0" width="5" height="3"></td>
		</tr>
		</table>
		
		</td>
	</tr>
	</table>
	<div id="isiBawahindex" >
	<TABLE WIDTH='100%'>
	<TR>
		<TD style='font:10px/normal verdana;color:white;text-align:right;padding-right:10px;'> <?=date("Y")?><!---->&nbsp;</TD>
	</TR>
	</TABLE>
	</div> 

<!-- ######################################################################-->
<script language="JavaScript" type="text/javascript">
window.onload = function()
{
	document.loginform.txt_name.focus()
}
</script>
</body>

</html>