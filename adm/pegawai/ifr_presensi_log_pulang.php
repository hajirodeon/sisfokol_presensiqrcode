<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");

nocache;

//nilai
$filenya = "ifr_presensi_log_pulang.php";
$judul = "Display PULANG";
$judulku = "$judul";
$judulx = $judul;


$jml_detik = "15000";
$ke = "$filenya";





//detail
$qdatai = mysql_query("SELECT * FROM orang_presensi ".
							"WHERE status = 'PULANG' ".
							"AND round(DATE_FORMAT(postdate, '%d')) = '$tanggal' ".
							"AND round(DATE_FORMAT(postdate, '%m')) = '$bulan' ".
							"AND round(DATE_FORMAT(postdate, '%Y')) = '$tahun' ".
							"ORDER BY postdate DESC");
$rdatai = mysql_fetch_assoc($qdatai);

do
	{
	$ikdi = $ikdi + 1;

	//tiap orang
	$yuk_postdate = balikin($rdatai['postdate']);
	$yuk_status = balikin($rdatai['status']);
	$yuk_kode = balikin($rdatai['orang_kode']);
	$yuk_jamnama = balikin($rdatai['orang_nama']);

	echo "<font color=red>$yuk_postdate. PRESENSI $yuk_status.</font>
	<br>
	$yuk_kode. 
	$yuk_jamnama
	<hr>";
	}
while ($rdatai = mysql_fetch_assoc($qdatai));

?>


<script>setTimeout("location.href='<?php echo $ke;?>'", <?php echo $jml_detik;?>);</script>

<?php
exit();
?>
