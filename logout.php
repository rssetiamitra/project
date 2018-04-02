<?
require_once "_lib/function/db_login.php";
loadlib("function","function.olah_tabel");

$v["logoff_time"]=date("Y-m-d H:i:s");
update_tabel("log_user_login",$v,"WHERE session_id='".session_id()."' AND logoff_time IS NULL");
session_destroy();
?>
<HTML><HEAD><TITLE> PASIEN SELESAI</TITLE></HEAD>
<BODY onload="javascript:location.href='login.php'">
</body>
</html>