<?
session_start();
	/**
	 *
	 * Mendeklarasikan librari-librari dasar
	 *
	 */	 
	require_once("../_lib/function/db.php");
	loadlib("function","variabel");
	loadlib("function","olah_tabel");
	loadlib("function","pilihan_list");
	//loadlib("function","variabel");
	loadlib("class","Paging");

	/**
	 *
	 * $sqlPlus, query tambahan untuk proses penelusuran
	 *
	 */
//cek_kiriman();
//$db->debug=true;
	
	if (isset($topik)) {
		switch ($topik) {
			case "nama" :
				$sqlX="AND nama_pasien LIKE '$filter%' ";
				break;
			case "mr" :
				//$filter = (int)$filter;
				$sqlX="AND no_mr = '$filter' ";
				break;
			default :
				$sqlX = "";
		}
	}


   $sql = "select * from ri_cari_pasien_v WHERE bag_pas not in (030901,030501,031001) $sqlX ORDER BY nama_pasien ";


		/**
			 *
			 * Proses pembuatan pagging
			 * $recperpage		: Berisikan jumlah baris untuk tiap halaman
			 *
			 */
			
			$recperpage = 20;

			$pagenya = new Paging($db, $sql, $recperpage);
			$rsPaging = $pagenya->ExecPage($hal);
			$NoAwal = ($hal == "" || $hal < 1) ? 0 : ($rsPaging->_currentPage - 1) * $recperpage;

			/**
			 *
			 * Akhir proses pembuatan pagging
			 *
			 */
?>
<html>

<head>
	<title>Averin Intranet Application Framework - Interface</title>
	<? include("../_inc/tpl_incHtmlHead.php"); ?>
</head>

<body scroll="no">
	<div id="topLayer" class="loading"></div>

	<!-- ========================================================================================= -->
	<div id="isiAtas">
		<div id="barJudul">Daftar Pasien Rawat Inap</div>
		<div id="barTools">
			<form method="post" action="<?= $PHP_SELF ?>">
			<table cellpadding="0" cellspacing="0" class="singleRow">
			<tr>
				<td><b>Cari&nbsp;&nbsp;</b></td>
				<td>
					<select name="topik">
						<option value="mr" <?= ($topik == "mr")?("selected"):("") ?>>MR</option>
						<option value="nama" <?= ($topik == "nama")?("selected"):("") ?>>Nama</option>
					</select>
				</td>
				<td><input type="text" size="20"  name="filter" id="idFilter"></td>
				<td><input type="submit" name="cari" value="Cari" class="submit01"></td>
			</tr>
			</table>
			</form>
		</div>

	</div>
	<!-- ========================================================================================= -->

	<!-- ========================================================================================= -->
	<div id="isiUtama">

		<table cellpadding="0" cellspacing="0" class="tblUtama">
		<thead>
		<tr>
			<th class="thno">No.</th>
			<th width="50">No. MR</th>
			<th>Nama Lengkap</th>
			<th>Nasabah</th>
			<th>Ruangan</th>
			<th>Kelas</th>
			<th>Kamar</th>	
		</tr>
		</thead>
		<tbody>
			<?
			$i=$pagenya->pagingVars["firstno"];
			while ($tampil=$rsPaging->FetchRow()) {
				

				$i++;
				$no_mr = $tampil["no_mr"];
				$nama_pasien = strtoupper(stripslashes($tampil["nama_pasien"]));
				$kode_kelompok = $tampil["kode_kelompok"];
				$bag_pas = $tampil["bag_pas"];
				$kelas_pas = $tampil["kelas_pas"];
				$kode_ruangan = $tampil["kode_ruangan"];
				$kode_ri = $tampil["kode_ri"];
				$no_registrasi = $tampil["no_registrasi"];

				$jum_bayar = read_tabel("ks_tc_trans_um","sum(jumlah) as jml_bayar","where no_registrasi = $no_registrasi");	
					 $j_bay = $jum_bayar->fields["jml_bayar"];
				 
				$sdh_bayar = read_tabel("tc_trans_pelayanan","sum(bill_rs) as biy_rs,sum(bill_dr1) as biy_dr1,sum(bill_dr2) as biy_dr2,sum(lain_lain) as biy_lain","where no_registrasi = $no_registrasi and status_selesai > 2");	
					 $biy_rs = $sdh_bayar->fields["biy_rs"] + $sdh_bayar->fields["biy_lain"];
					 $biy_dok = $sdh_bayar->fields["biy_dr1"] + $sdh_bayar->fields["biy_dr2"];
					 $s_bay = $biy_rs + $biy_dok;

			?>
		<tr>
			<td class="tdno"><?= $i ?>.</td>
			<td align="center"><?=$no_mr?>&nbsp;</td>
			<td>
				<a href="data_pasien_view.php?kode_ri=<?=$kode_ri?>&kode_bagian=<?=$bag_pas?>&kode_klas=<?=$kelas_pas?>" onclick="">
				<b><?=$nama_pasien?>&nbsp;</b>
				</a>
			</td>
			<td>
			<?  
				$kelompok = baca_tabel("mt_nasabah","nama_kelompok","where kode_kelompok=$kode_kelompok");
				echo $kelompok;
			?>&nbsp;
			</td>
			<td>
			<? 
				$bagian = baca_tabel("mt_bagian","nama_bagian","where kode_bagian = '$bag_pas'");
				echo $bagian;
			?>&nbsp;
			</td>
			<td>
			<? 
				$kelas = baca_tabel("mt_klas","nama_klas","where kode_klas = $kelas_pas");
				echo $kelas;
			?>&nbsp;
			</td>
			<td>
			 <? 
				$_kamar = read_tabel("mt_ruangan","no_kamar,no_bed","where kode_ruangan = '$kode_ruangan'");
				$kamar = $_kamar->fields["no_kamar"];
				$bed = $_kamar->fields["no_bed"];
				echo $kamar . "&nbsp;&nbsp;" . $bed;
			 ?>&nbsp;
			 </td>
		</tr>
			<? }?>
			
		</tbody>
		</table>

	</div>
	<!-- ========================================================================================= -->

	<!-- ========================================================================================= -->
		<div id="isiBawah">
		<?
			$pagenya->PageNav($pagenya); 
		?>
		</div>
	<!-- ========================================================================================= -->

<!-- ############################################################################################# -->
<script language="JavaScript" type="text/javascript">

var kelasElm;

window.onload = function() {
	initHalaman();
	kelasElm = document.getElementById("idKelas");
}

function rubahKelas(val) {
	var url;


	if (val != "") {
		url = "data_kelas_act.php?kode_bagian=" + val;
		retrieveData(url, "getData")
	} else {
		kelasElm.innerHTML = "<select><option value=\"\" selected>-- Pilih Kelas --</option></select>";
	}
}

function getData(obj) {
	kelasElm.innerHTML = obj.responseText;
}

</script>
</body>

</html>