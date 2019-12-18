<?php
session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");



$filenyax = "$sumber/android_pegawai/i_barang.php";

//nilai session
$sesiku = $_SESSION['sesiku'];
$sesinama = $_SESSION['sesinama'];




//jika pinjam
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'pinjam'))
	{
	//ambil nilai
	$euser = cegah($_GET['userku']);

	//cek
	$qku = mysql_query("SELECT * FROM m_item ".
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

		
		$xyz = md5("$sesiku$ku_kd$tahun$bulan$tanggal$jam$menit$detik");
		
		
		
		
		//cek, sudah dipinjam ato belum
		$qcc = mysql_query("SELECT * FROM item_pinjam ".
								"WHERE item_kd = '$ku_kd' ".
								"AND status = 'PINJAM' ".
								"ORDER BY postdate DESC");
		$tcc = mysql_num_rows($qcc);
		
		//jika iya
		if (!empty($tcc))
			{
			echo '<h3>
			<font color=red>
			ITEM BARANG SUDAH ADA YANG PINJAM. Silahkan Coba Lainnya....
			</font>
			</h3>';
			
			exit();
			}
		
		else
			{
			//cek, jika aq pinjam
			$qcc = mysql_query("SELECT * FROM item_pinjam ".
									"WHERE item_kd = '$ku_kd' ".
									"AND orang_kd = '$sesiku' ".
									"AND status = 'PINJAM' ".
									"ORDER BY postdate DESC");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
			$cc_kd = nosql($rcc['kd']);
			
			//jika iya, 
			if (!empty($tcc))
				{
				echo '<h3>
				<font color=red>
				SEDANG SAYA PINJAM...
				</font>
				</h3>';
				
				exit();
				}
			else
				{
				//insert
				mysql_query("INSERT INTO item_pinjam(kd, orang_kd, item_kd, postdate, ".
								"postdate_pinjam, status) VALUES ".
								"('$xyz', '$sesiku', '$ku_kd', '$today', ".
								"'$today', 'PINJAM')");
								
				
				echo '<p>
				Kode Barang : '.$ku_kode.'.
				<br>
				'.$ku_nama.'
				</p>
				
				<hr>
				
				<h3>
				<font color=green>
				Berhasil Dipinjam.
				</font>
				</h3>
				<hr>
				'.$today.'';	
				}
			
			exit();		
			}
		
		
		exit();
		}	

	
	exit();
	}












//jika kembali
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'kembali'))
	{
	//ambil nilai
	$euser = cegah($_GET['userku']);

	//cek
	$qku = mysql_query("SELECT * FROM m_item ".
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

		
		$xyz = md5("$sesiku$ku_kd$tahun$bulan$tanggal");
		
		
		
		
		//cek, jika aq pinjam
		$qcc = mysql_query("SELECT * FROM item_pinjam ".
								"WHERE item_kd = '$ku_kd' ".
								"AND orang_kd = '$sesiku' ".
								"AND status = 'PINJAM' ".
								"ORDER BY postdate DESC");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_kd = nosql($rcc['kd']);
		
		//jika iya, update kembali...
		if (!empty($tcc))
			{
			//update
			mysql_query("UPDATE item_pinjam SET status = 'KEMBALI', ".
							"postdate_kembali = '$today' ".
							"WHERE kd = '$cc_kd'");
				
			echo '<h3>
			<font color=green>
			ITEM BARANG BERHASIL DIKEMBALIKAN. Terima Kasih.
			</font>
			</h3>
			<hr>
			'.$today.'';
			
			exit();
			}
		
		else
			{
			echo '<h3>
			<font color=red>
			TIDAK PINJAM ITEM BARANG INI...
			</font>
			</h3>';
			
			exit();		
			}
		
		
		exit();
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










exit();
?>
