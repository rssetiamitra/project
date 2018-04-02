<?
session_start();
include "_lib/function/db.php";
loadlib("function","function.variabel");

?>

<html>
<head>
	<title>Ganti Password</title>
	<? 
	include "_inc/tpl_incHtmlHead.php";
	?>
</head>

<body scroll="no">
<div id="topLayer" class="loading"></div>
<!-- ========================================================================================= -->

<div id="isiAtas">
<div id="barJudul">Ganti Password</div>
</div>
<!-- isi ################################################################-->

<?

$sql="select * from dd_user where id_dd_user=$id";
$hasil=&$db->Execute($sql);
$id_dd_user=$hasil->fields["id_dd_user"];
$username=$hasil->fields["username"];
$password=$hasil->fields["password"];
$npp=$hasil->fields["npp"];
$id_dd_group=$hasil->fields["id_dd_group"];
$id_dd_user_group=$hasil->fields["id_dd_user_group"];
$status=$hasil->fields["status"];
$ko_wil=$hasil->fields["ko_wil"];
$input_id=$hasil->fields["input_id"];
$input_tgl=$hasil->fields["input_tgl"];
$status_tgl=$hasil->fields["status_tgl"];
	
?>

<div id="isiUtama">

<!-- --------------------------------------------------------------------- -->


<form id="dewasa" name="xxx" method="post" action="ganti_password_submit.php">
<!-- <table id="isiDataInputPop" class="formInput" cellpadding="0" cellspacing="0" align="left" width="100%"> -->
<table cellpadding="0" cellspacing="0" class="formInput" <? if(!$id_dd_user){ ?>style="width:400px; height:250px;"<? } ?>>
<tr>	
<!-- --------------------------------------------------------------------------------- -->
<td class="kiri">
	<table cellpadding="0" cellspacing="0">
	 <tr>
		<td class="field">Username </td>
		<td class="input"><?= $username ?></td>
	 </tr>
	 </tr>
     <tr>
		<td class="field">Password Lama</td>
		<td class="input"><input type="password" name="password_lama" size="35" value="<?= $password_lama ?>"></td>
	 </tr>
    </tr>
        <td class="field" >Password Baru</td>
        <td class="input"><input name="password_baru" type="password" size="35" value="<?=$password_baru?>"></td>
     </tr>
       <td class="field" >Konfirmasi Password Baru</td>
       <td class="input"><input name="repassword_baru" type="password" size="35" value="<?=$repassword_baru?>"></td>
     </tr>
	 <tr>
		<td class="field"> </td>
		<td class="input" ><span class="brd03">
		<INPUT TYPE="hidden" name="password_asli" value="<?=$password?>">
		<INPUT TYPE="hidden" name="id" value="<?=$id?>">
		<input type="submit" name="Submit" value="Submit" class="submit01" onclick="javascript: if(document.xxx.password_baru.value!=document.xxx.repassword_baru.value){alert('Password Baru tidak sama dengan Konfirmasi Password Baru !');return false;}"><input type="button" name="Submit2" value="Batal" onclick="javascript:window.close()"  class="submit01"></span></td>
		<!-- return if(document.xxx.password_baru.value==document.xxx.repassword_baru.value){return true;}else{alert('Password Baru tidak sama dengan Konfirmasi Password Baru !');return false;} -->
	</tr> 
	</table>
			</td>
<!-- --------------------------------------------------------------------------------- -->
	</table>
</form>

	<!-- --------------------------------------------------------------------- -->

</div> <!-- end id="isi" -->


<!-- ############################################################################-->
<script language="JavaScript" type="text/javascript">
window.onload = function()
{
	//xAddEventListener(window, 'resize', adjustLayoutHalaman, true);
	initHalaman();
}
</script>
</body>
</html>