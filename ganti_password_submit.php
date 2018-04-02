<?
include "_lib/function/db.php";
loadlib("function","function.olah_tabel");
//loadlib("function","max_kode_number");
//loadlib("function","max_kode_text");
//loadlib("function","isi_kirim");
//loadlib("function","isi_hidden");

if($password_asli!=md5($password_lama)):

//$lempar="";
$comment="<CENTER>Maaf Data Password Lama salah !</CENTER>";
$balik="<CENTER><A HREF='ganti_password.php?".isi_kirim()."'>Kembali</A></CENTER>";

else:
$edit_dd_user["password"]=md5($password_baru);
update_tabel("dd_user",$edit_dd_user,"Where id_dd_user=$id");

//$lempar="onload=".'"'."javascript:window.location.href='lihat.php';".'"';
$comment="<CENTER>Password Sudah berubah !</CENTER>";
$balik="<CENTER><A HREF='javascript:window.close()'>Tutup</A></CENTER>";
endif;
?>
<html>
	<head>
		<title>Konfirmasi</title>
	</head>
	<body <?= $lempar?>>
	<BR><BR>
	<?=$comment;?>
	<?=$balik?>
	</body>
</html>