<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admin.html");

nocache;

//nilai
$filenya = "lap_hari.php";
$judul = "Laporan per Tanggal";
$judulku = "$judul";
$judulx = $judul;
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);



//jika null, kasi hari ini
if (empty($utgl))
	{
	//re-direct
	$ke = "$filenya?utgl=$tanggal&ubln=$bulan&uthn=$tahun";
	xloc($ke);
	exit();
	}


$lokd = nosql($_REQUEST['lokd']);
$kd = nosql($_REQUEST['kd']);
$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika export
if ($_POST['btnEXPORT'])
	{
	//nilai
	$utgl = cegah($_POST['utgl']);
	$ubln = cegah($_POST['ubln']);
	$uthn = cegah($_POST['uthn']);
		

	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//nama file e...
	$i_filename = "lap-hari-$uthn-$ubln-$utgl.xls";
	$i_judul = "LapHarian";
	



	//header file
	function HeaderingExcel($i_filename)
		{
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=$i_filename");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		}

	
	
	
	//bikin...
	HeaderingExcel($i_filename);
	$workbook = new Workbook("-");
	$worksheet1 =& $workbook->add_worksheet($i_judul);
	$worksheet1->write_string(0,0,"NO.");
	$worksheet1->write_string(0,1,"KODE");
	$worksheet1->write_string(0,2,"NAMA");
	$worksheet1->write_string(0,3,"JABATAN");
	$worksheet1->write_string(0,4,"MASUK");
	$worksheet1->write_string(0,5,"PULANG");
	$worksheet1->write_string(0,6,"JUMLAH");



	//data
	$qdt = mysql_query("SELECT * FROM m_orang ".
							"ORDER BY nama ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_kd = balikin($rdt['kd']);
		$dt_nip = balikin($rdt['kode']);
		$dt_nama = balikin($rdt['nama']);
		$dt_jabatan = balikin($rdt['jabatan']);


		//ketahui postdate masuk paling awal
		$qyuk = mysql_query("SELECT * FROM orang_presensi ".
								"WHERE orang_kd = '$dt_kd' ".
								"AND round(DATE_FORMAT(postdate, '%d')) = '$utgl' ".
								"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
								"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
								"AND status = 'MASUK' ".
								"ORDER BY postdate ASC");
		$ryuk = mysql_fetch_assoc($qyuk);
		$masuk_lokd = nosql($ryuk['kd']);
		$yuk_masuk = balikin($ryuk['postdate']);
		
		
		
		
		//ketahui postdate pulang paling akhir
		$qyuk = mysql_query("SELECT * FROM orang_presensi ".
								"WHERE orang_kd = '$dt_kd' ".
								"AND round(DATE_FORMAT(postdate, '%d')) = '$utgl' ".
								"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
								"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
								"AND status = 'PULANG' ".
								"ORDER BY postdate DESC");
		$ryuk = mysql_fetch_assoc($qyuk);
		$pulang_lokd = nosql($ryuk['kd']);
		$yuk_pulang = balikin($ryuk['postdate']);



		//total menit masuk
		$yuk_masuk2 = strtotime($yuk_masuk);
		$masuk_jam = date('H', $yuk_masuk2);
		$masuk_menit = date('i', $yuk_masuk2);
		$jml_menit_masuk = (60 * $masuk_jam) + $masuk_menit;
		
		
		
		//total menit pulang
		$yuk_pulang2 = strtotime($yuk_pulang);
		$pulang_jam = date('H', $yuk_pulang2);
		$pulang_menit = date('i', $yuk_pulang2);
		$jml_menit_pulang = (60 * $pulang_jam) + $pulang_menit;
		
		$yuk_selisih = $jml_menit_pulang - $jml_menit_masuk;
		
		
		//jadikan jam
		$jml_jam = floor($yuk_selisih / 60);
		$jml_menit = $yuk_selisih % 60;
		$yuk_selisihx = "$jml_jam Jam, $jml_menit Menit";



		//tgl masuk
		$masuknya = explode(" ", $yuk_masuk);
		$tglnya = trim($masuknya[0]);
		
		$masuknya2 = explode("-", $tglnya);
		$tglnya_thn = trim($masuknya2[0]);
		$tglnya_bln = trim($masuknya2[1]);
		$tglnya_tgl = trim($masuknya2[2]);
		$tglnyax = "$tglnya_thn:$tglnya_bln:$tglnya_tgl";
		
				
		



		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_nip);
		$worksheet1->write_string($dt_nox,2,$dt_nama);
		$worksheet1->write_string($dt_nox,3,$dt_jabatan);
		$worksheet1->write_string($dt_nox,4,$yuk_masuk);
		$worksheet1->write_string($dt_nox,5,$yuk_pulang);
		$worksheet1->write_string($dt_nox,6,$yuk_selisihx);
		}
	while ($rdt = mysql_fetch_assoc($qdt));


	//close
	$workbook->close();

	
	
	//re-direct
	xloc($filenya);
	exit();
	}











//hapus masuk
if ($s == "hapusmasuk")
	{	
	//hapus
	mysql_query("DELETE FROM orang_presensi ".
					"WHERE kd = '$lokd'");
		
	
	//re-direct
	$ke = "$filenya?utgl=$utgl&ubln=$ubln&uthn=$uthn";
	xloc($ke);
	exit();		
	}
	

	
	
	
//hapus pulang
if ($s == "hapuspulang")
	{	
	//hapus
	mysql_query("DELETE FROM orang_presensi ".
					"WHERE kd = '$lokd'");
		
	
	//re-direct
	$ke = "$filenya?utgl=$utgl&ubln=$ubln&uthn=$uthn";
	xloc($ke);
	exit();		
	}
	
	
	
		
	
	
	
//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}




//nek masuk
if ($_POST['btnMASUK'])
	{
	//nilai
	$utgl = cegah($_POST['utgl']);
	$ubln = cegah($_POST['ubln']);
	$uthn = cegah($_POST['uthn']);
	
	
	//re-direct
	$ke = "$filenya?utgl=$utgl&ubln=$ubln&uthn=$uthn&s=petamasuk";
	xloc($ke);
	exit();
	}







//nek pulang
if ($_POST['btnPULANG'])
	{
	//nilai
	$utgl = cegah($_POST['utgl']);
	$ubln = cegah($_POST['ubln']);
	$uthn = cegah($_POST['uthn']);
	
	
	//re-direct
	$ke = "$filenya?utgl=$utgl&ubln=$ubln&uthn=$uthn&s=petapulang";
	xloc($ke);
	exit();
	}

	
	
		
	
	



//jika cari
if ($_POST['btnCARI'])
	{
	//nilai
	$utgl = cegah($_POST['utgl']);
	$ubln = cegah($_POST['ubln']);
	$uthn = cegah($_POST['uthn']);
	$kunci = cegah($_POST['kunci']);


	//re-direct
	$ke = "$filenya?utgl=$utgl&ubln=$ubln&uthn=$uthn&kunci=$kunci";
	xloc($ke);
	exit();
	}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


//require
require("../../template/js/jumpmenu.js");
require("../../template/js/checkall.js");
require("../../template/js/swap.js");
?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika null
	if (empty($kunci))
		{
		$sqlcount = "SELECT * FROM m_orang ".
						"ORDER BY nama ASC";
		}
		
	else
		{
		$sqlcount = "SELECT * FROM m_orang ".
						"WHERE nip LIKE '%$kunci%' ".
						"OR nama LIKE '%$kunci%' ".
						"ORDER BY nama ASC";
		}
	
	
	

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?utgl=$utgl&ubln=$ubln&uthn=$uthn";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);



echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
echo "<select name=\"utglx\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
echo '<option value="'.$utgl.'">'.$utgl.'</option>';
for ($itgl=1;$itgl<=31;$itgl++)
	{
	echo '<option value="'.$filenya.'?utgl='.$itgl.'">'.$itgl.'</option>';
	}
echo '</select>';

echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln1[$ubln].' '.$uthn.'</option>';
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;
		$ithn = $tahun;

		echo '<option value="'.$filenya.'?utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$ithn.'">'.$arrbln[$ibln].' '.$ithn.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;
		$ithn = $tahun + 1;


		echo '<option value="'.$filenya.'?utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$ithn.'">'.$arrbln[$ibln].' '.$ithn.'</option>';
		}
	}

echo '</select>


<input name="utgl" type="hidden" value="'.$utgl.'">
<input name="ubln" type="hidden" value="'.$ubln.'">
<input name="uthn" type="hidden" value="'.$uthn.'">
<input name="btnEXPORT" type="submit" value="EXPORT EXCEL" class="btn btn-danger">
		
</td>
</tr>
</table>
<br>';



if ((empty($utgl)) OR (empty($ubln)))
	{
	echo '<p>
	<font color="#FF0000"><strong>TANGGAL Belum Dipilih...!</strong></font>
	</p>';
	}
else
	{
	echo '<p>
	<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
	<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
	<input name="utgl" type="hidden" value="'.$utgl.'">
	<input name="ubln" type="hidden" value="'.$ubln.'">
	<input name="uthn" type="hidden" value="'.$uthn.'">
	<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
	</p>
		
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="150"><strong><font color="'.$warnatext.'">IMAGE</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">KODE</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">JABATAN</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">MASUK</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">PULANG</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">JUMLAH JAM KEHADIRAN</font></strong></td>
	</tr>
	</thead>
	<tbody>';
	
	if ($count != 0)
		{
		do 
			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}
	
			$nomer = $nomer + 1;
			$i_kd = nosql($data['kd']);
			$i_kode = balikin($data['kode']);
			$i_nama = balikin($data['nama']);
			$i_jabatan = balikin($data['jabatan']);
			$i_status = balikin($data['status']);
			$i_haid = balikin($data['hardware_kode']);
			$i_filex1 = balikin($data['filex1']);
			$i_akses = $i_kode;
	
	
			$nil_foto1 = "$sumber/filebox/pegawai/$i_kd/$i_filex1";
	
	
			//ketahui postdate masuk paling awal
			$qyuk = mysql_query("SELECT * FROM orang_presensi ".
									"WHERE orang_kd = '$i_kd' ".
									"AND round(DATE_FORMAT(postdate, '%d')) = '$utgl' ".
									"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
									"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
									"AND status = 'MASUK' ".
									"ORDER BY postdate ASC");
			$ryuk = mysql_fetch_assoc($qyuk);
			$masuk_lokd = nosql($ryuk['kd']);
			$yuk_masuk = balikin($ryuk['postdate']);
			
			
			
			
			//ketahui postdate pulang paling akhir
			$qyuk = mysql_query("SELECT * FROM orang_presensi ".
									"WHERE orang_kd = '$i_kd' ".
									"AND round(DATE_FORMAT(postdate, '%d')) = '$utgl' ".
									"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
									"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
									"AND status = 'PULANG' ".
									"ORDER BY postdate DESC");
			$ryuk = mysql_fetch_assoc($qyuk);
			$pulang_lokd = nosql($ryuk['kd']);
			$yuk_pulang = balikin($ryuk['postdate']);
	
	
	
			//total menit masuk
			$yuk_masuk2 = strtotime($yuk_masuk);
			$masuk_jam = date('H', $yuk_masuk2);
			$masuk_menit = date('i', $yuk_masuk2);
			$jml_menit_masuk = (60 * $masuk_jam) + $masuk_menit;
			
			
			
			//total menit pulang
			$yuk_pulang2 = strtotime($yuk_pulang);
			$pulang_jam = date('H', $yuk_pulang2);
			$pulang_menit = date('i', $yuk_pulang2);
			$jml_menit_pulang = (60 * $pulang_jam) + $pulang_menit;
			
			$yuk_selisih = $jml_menit_pulang - $jml_menit_masuk;
			
			
			//jadikan jam
			$jml_jam = floor($yuk_selisih / 60);
			$jml_menit = $yuk_selisih % 60;
			$yuk_selisihx = "$jml_jam Jam, $jml_menit Menit";
	
	
	
			//tgl masuk
			$masuknya = explode(" ", $yuk_masuk);
			$tglnya = trim($masuknya[0]);
			
			$masuknya2 = explode("-", $tglnya);
			$tglnya_thn = trim($masuknya2[0]);
			$tglnya_bln = trim($masuknya2[1]);
			$tglnya_tgl = trim($masuknya2[2]);
			$tglnyax = "$tglnya_thn:$tglnya_bln:$tglnya_tgl";
	
			
			$i_xyz = md5("$i_kd$tglnyax");
	
	
	
			//masukin ke rekap
			mysql_query("INSERT INTO orang_rekap(kd, orang_kd, orang_kode, orang_nama, ".
							"tglnya, postdate_masuk, postdate_pulang, postdate, jml_jam, jml_menit) VALUES ".
							"('$i_xyz', '$i_kd', '$i_kode', '$i_nama', ".
							"'$tglnyax', '$yuk_masuk', '$yuk_pulang', '$today', '$jml_jam', $jml_menit)");





			 
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><img src="'.$nil_foto1.'" width="150"></td>
			<td>'.$i_kode.'</td>
			<td>
			'.$i_nama.'
			</td>
			<td>'.$i_jabatan.'</td>
			<td>
			'.$yuk_masuk.'
			<hr>
			<a href="'.$filenya.'?s=hapusmasuk&lokd='.$masuk_lokd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'" class="btn btn-danger">HAPUS >></a>
			</td>
			<td>
			'.$yuk_pulang.'
			<hr>
			<a href="'.$filenya.'?s=hapuspulang&lokd='.$pulang_lokd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'" class="btn btn-danger">HAPUS >></a>
			</td>
			<td>'.$yuk_selisihx.'</td>
	        </tr>';
			}
		while ($data = mysql_fetch_assoc($result));
		}
	
	
	echo '</tbody>
	  </table>
	  </div>
	
	
	<table width="500" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
	<br>
	
	<input name="jml" type="hidden" value="'.$count.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	<input name="page" type="hidden" value="'.$page.'">
	</td>
	</tr>
	</table>';
	}	
	
echo '</form>';



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>