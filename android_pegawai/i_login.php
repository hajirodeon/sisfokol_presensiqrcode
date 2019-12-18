<?php
session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");



$filenyax = "$sumber/android_pegawai/i_login.php";





//jika form
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'form'))
	{
	//ambil nilai
	$euser = cegah($_GET['userku']);

	//cek
	$qku = mysql_query("SELECT * FROM m_orang ".
							"WHERE kd = '$euser'");
	$rku = mysql_fetch_assoc($qku);
	$tku = mysql_num_rows($qku);
	
	//jika null
	if (empty($tku))
		{
		echo '<h3>
		<font color="red">
		TIDAK DITEMUKAN. <br>SILAHKAN ULANGI LAGI...!!
		</font>
		</h3>';
		}
	else
		{
		//lanjut
		$ku_kd = nosql($rku['kd']);
		$ku_kode = balikin($rku['kode']);
		$ku_nama = balikin($rku['nama']);
		$ku_passx = md5($ku_kode);
		
		//bikin sesi
		$_SESSION['sesiku'] = $ku_kd;
		$_SESSION['sesinama'] = $ku_nama;
		$_SESSION['passx'] = $ku_passx;
		
		?>
		
		
		
		<script language='javascript'>
		//membuat document jquery
		$(document).ready(function(){
				window.location.href = "main.html"; 
		
		});
		
		</script>
		
		<?php

		}	

	
	exit();
	}













//jika error
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'error'))
	{
	echo '<h3>
	<font color="red">
	SCAN GAGAL. . .
	</font>
	</h3>';
	
	exit();
	}


















//jika logout
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'logout'))
	{
	//habisi
	session_unset();
	session_destroy();
	
	?>
	
	
	
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
			window.location.href = "main.html"; 
	
	});
	
	</script>
	
	<?php
	
	exit();
	}






exit();
?>
