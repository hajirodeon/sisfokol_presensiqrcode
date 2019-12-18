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
$filenya = "lap_bulan.php";
$judul = "Laporan per Bulan";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$pegkd = nosql($_REQUEST['pegkd']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);



//jika null, kasi hari ini
if (empty($ubln))
	{
	//re-direct
	$ke = "$filenya?ubln=$bulan&uthn=$tahun";
	xloc($ke);
	exit();
	}


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
	$ubln = cegah($_POST['ubln']);
	$uthn = cegah($_POST['uthn']);
		

	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//nama file e...
	$i_filename = "lap-bulan-$uthn-$ubln.xls";
	$i_judul = "LapBulanan";
	



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
	$worksheet1->write_string(0,4,"JUMLAH");



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


		
				
		
		//hitung jumlah hadir
		$qyuk = mysql_query("SELECT SUM(jml_jam) AS tjam, ".
								"SUM(jml_menit) AS tmenit ".
								"FROM orang_rekap ".
								"WHERE orang_kd = '$dt_kd' ".
								"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
								"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn'");
		$ryuk = mysql_fetch_assoc($qyuk);
		$yuk_jam = balikin($ryuk['tjam']);
		$yuk_menit = balikin($ryuk['tmenit']);
		
		$yuk_jam_menit = $yuk_jam * 60;
		$yuk_total = $yuk_jam_menit + $yuk_menit;
		
		//jadikan jam
		$jml_jam = floor($yuk_total / 60);
		$jml_menit = $yuk_total % 60;
		$yuk_selisihx = "$jml_jam Jam, $jml_menit Menit";



		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_nip);
		$worksheet1->write_string($dt_nox,2,$dt_nama);
		$worksheet1->write_string($dt_nox,3,$dt_jabatan);
		$worksheet1->write_string($dt_nox,4,$yuk_selisihx);
		}
	while ($rdt = mysql_fetch_assoc($qdt));


	//close
	$workbook->close();

	
	
	//re-direct
	xloc($filenya);
	exit();
	}






//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//jika cari
if ($_POST['btnCARI'])
	{
	//nilai
	$ubln = cegah($_POST['ubln']);
	$uthn = cegah($_POST['uthn']);
	$kunci = cegah($_POST['kunci']);


	//re-direct
	$ke = "$filenya?ubln=$ubln&uthn=$uthn&kunci=$kunci";
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
						"WHERE kode LIKE '%$kunci%' ".
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
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);



echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln1[$ubln].' '.$uthn.'</option>';
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;
		$ithn = $tahun;

		echo '<option value="'.$filenya.'?ubln='.$ibln.'&uthn='.$ithn.'">'.$arrbln[$ibln].' '.$ithn.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;
		$ithn = $tahun + 1;


		echo '<option value="'.$filenya.'?ubln='.$ibln.'&uthn='.$ithn.'">'.$arrbln[$ibln].' '.$ithn.'</option>';
		}
	}

echo '</select>



<input name="ubln" type="hidden" value="'.$ubln.'">
<input name="uthn" type="hidden" value="'.$uthn.'">
<input name="btnEXPORT" type="submit" value="EXPORT EXCEL" class="btn btn-danger">

</td>
</tr>
</table>
<br>';



if (empty($ubln))
	{
	echo '<p>
	<font color="#FF0000"><strong>BULAN Belum Dipilih...!</strong></font>
	</p>';
	}
else
	{
	//jika rincian
	if ($s == "rincian")
		{
		//detail
		$qyuk1 = mysql_query("SELECT * FROM m_orang ".
								"WHERE kd = '$pegkd'");
		$ryuk1 = mysql_fetch_assoc($qyuk1);
		$yuk1_nip = balikin($ryuk1['nip']);
		$yuk1_nama = balikin($ryuk1['nama']);	
		
		
		echo "<a href='$filenya' class='btn btn-danger'><< DAFTAR LAINNYA</a>
		<hr>
		<h3>$yuk1_nip. $yuk1_nama</h3>";
		
		
		//detail presensi bulan ini
		$qyuk = mysql_query("SELECT * FROM orang_presensi ".
								"WHERE orang_kd = '$pegkd' ".
								"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
								"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
								"ORDER BY postdate ASC");
		$ryuk = mysql_fetch_assoc($qyuk);
		
		do
			{
			$yuk_postdate = balikin($ryuk['postdate']);
			$yuk_alamat = balikin($ryuk['alamat']);
			$yuk_status = balikin($ryuk['status']);
			
			
			echo "<b>$yuk_postdate</b>. PRESENSI $yuk_status.  
			<hr>";
			}
		while ($ryuk = mysql_fetch_assoc($qyuk));
		
			
		}


	else
		{
		echo '<p>
		<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
		<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
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
		<td width="150"><strong><font color="'.$warnatext.'">JML. HADIR</font></strong></td>
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
				$i_filex1 = balikin($data['filex1']);
				$i_akses = $i_kode;
		
		
				$nil_foto1 = "$sumber/filebox/pegawai/$i_kd/$i_filex1";
		
		
				//hitung jumlah hadir
				$qyuk = mysql_query("SELECT SUM(jml_jam) AS tjam, ".
										"SUM(jml_menit) AS tmenit ".
										"FROM orang_rekap ".
										"WHERE orang_kd = '$i_kd' ".
										"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn'");
				$ryuk = mysql_fetch_assoc($qyuk);
				$yuk_jam = balikin($ryuk['tjam']);
				$yuk_menit = balikin($ryuk['tmenit']);
				
				$yuk_jam_menit = $yuk_jam * 60;
				$yuk_total = $yuk_jam_menit + $yuk_menit;
				
				//jadikan jam
				$jml_jam = floor($yuk_total / 60);
				$jml_menit = $yuk_total % 60;
				$yuk_selisihx = "$jml_jam Jam, $jml_menit Menit";
				
				
				 
				
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td><img src="'.$nil_foto1.'" width="150"></td>
				<td>'.$i_kode.'</td>
				<td>
				'.$i_nama.'
				</td>
				<td>'.$i_jabatan.'</td>
				<td>
				'.$yuk_selisihx.'
				<hr>
				<a href="'.$filenya.'?s=rincian&ubln='.$ubln.'&uthn='.$uthn.'&pegkd='.$i_kd.'" class="btn btn-primary">RINCIAN >></a>
				</td>
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