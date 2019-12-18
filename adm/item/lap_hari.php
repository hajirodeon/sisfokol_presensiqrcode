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
$judul = "[ITEM]. Laporan Peminjaman per Tanggal";
$judulku = "$judul";
$judulx = $judul;
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);


$tglnow = "$tahun-$bulan-$tanggal";


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
	$worksheet1->write_string(0,3,"PINJAM");
	$worksheet1->write_string(0,4,"KEMBALI");
	$worksheet1->write_string(0,5,"JUMLAH");



	//data
	$qdt = mysql_query("SELECT * FROM m_item ".
							"ORDER BY nama ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_kd = balikin($rdt['kd']);
		$dt_nip = balikin($rdt['kode']);
		$dt_nama = balikin($rdt['nama']);


		//ketahui postdate masuk paling awal
		$qyuk = mysql_query("SELECT * FROM item_pinjam ".
								"WHERE item_kd = '$dt_kd' ".
								"AND round(DATE_FORMAT(postdate_pinjam, '%d')) = '$utgl' ".
								"AND round(DATE_FORMAT(postdate_pinjam, '%m')) = '$ubln' ".
								"AND round(DATE_FORMAT(postdate_pinjam, '%Y')) = '$uthn' ".
								"AND status = 'MASUK' ".
								"ORDER BY postdate ASC");
		$ryuk = mysql_fetch_assoc($qyuk);
		$masuk_lokd = nosql($ryuk['kd']);
		$yuk_masuk = balikin($ryuk['postdate']);
		
		
		
		
		//ketahui postdate pulang paling akhir
		$qyuk = mysql_query("SELECT * FROM item_pinjam ".
								"WHERE item_kd = '$dt_kd' ".
								"AND round(DATE_FORMAT(postdate_kembali, '%d')) = '$utgl' ".
								"AND round(DATE_FORMAT(postdate_kembali, '%m')) = '$ubln' ".
								"AND round(DATE_FORMAT(postdate_kembali, '%Y')) = '$uthn' ".
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
		$worksheet1->write_string($dt_nox,3,$yuk_masuk);
		$worksheet1->write_string($dt_nox,4,$yuk_pulang);
		$worksheet1->write_string($dt_nox,5,$yuk_selisihx);
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
	$sqlcount = "SELECT * FROM item_pinjam ".
					"WHERE postdate_pinjam LIKE '$tglnow%' ".
					"OR postdate_kembali LIKE '$tglnow%' ".
					"ORDER BY postdate_kembali DESC, ".
					"postdate_pinjam DESC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM item_pinjam ".
					"WHERE (postdate_pinjam LIKE '$tglnow%' ".
					"OR postdate_kembali LIKE '$tglnow%') ".
					"OR orang_kode LIKE '%$kunci%' ".
					"OR orang_nama LIKE '%$kunci%' ".
					"OR item_kode LIKE '%$kunci%' ".
					"OR item_nama LIKE '%$kunci%' ".
					"ORDER BY postdate_kembali DESC, ".
					"postdate_pinjam DESC";
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
	<td width="50"><strong><font color="'.$warnatext.'">PINJAM</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">KEMBALI</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">IMAGE</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">KODE</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">PEMINJAM</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">LAMA</font></strong></td>
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
			$i_item_kd = nosql($data['item_kd']);
			$i_orang_kd = nosql($data['orang_kd']);
			$i_status = balikin($data['status']);
			$yuk_masuk = balikin($data['postdate_pinjam']);
			$yuk_pulang = balikin($data['postdate_kembali']);
			

			//detail item
			$qmboh = mysql_query("SELECT * FROM m_item ".
									"WHERE kd = '$i_item_kd'");
			$rmboh = mysql_fetch_assoc($qmboh);
			$i_item_qrcode = cegah($rmboh['qrcode']);
			$i_item_kode = cegah($rmboh['kode']);
			$i_item_nama = cegah($rmboh['nama']);
			$i_filex1 = balikin($rmboh['filex1']);
			$nil_foto1 = "$sumber/filebox/item/$i_item_kd/$i_filex1";
	
	
	
			//detail orang
			$qmboh2 = mysql_query("SELECT * FROM m_orang ".
									"WHERE kd = '$i_orang_kd'");
			$rmboh2 = mysql_fetch_assoc($qmboh2);
			$i_orang_qrcode = cegah($rmboh2['qrcode']);
			$i_orang_kode = cegah($rmboh2['kode']);
			$i_orang_nama = cegah($rmboh2['nama']);
			$i_filex12 = balikin($rmboh2['filex1']);
			$nil_foto12 = "$sumber/filebox/orang/$i_orang_kd/$i_filex12";
	
	
	
	
			//update
			mysql_query("UPDATE item_pinjam SET item_qrcode = '$i_item_qrcode', ".
							"item_kode = '$i_item_kode', ".
							"item_nama = '$i_item_nama', ".
							"orang_qrcode = '$i_orang_qrcode', ".
							"orang_kode = '$i_orang_kode', ".
							"orang_nama = '$i_orang_nama' ".
							"WHERE kd = '$i_kd'");	
	
	
	
	


			//ketahui peminjam terakhir...
			$qyuk = mysql_query("SELECT * FROM item_pinjam ".
									"WHERE item_kd = '$i_item_kd'");	
			$ryuk = mysql_fetch_assoc($qyuk);
			$i_orang_kd = balikin($ryuk['orang_kd']);
			$i_orang_qrcode = balikin($ryuk['orang_qrcode']);
			$i_orang_kode = balikin($ryuk['orang_kode']);
			$i_orang_nama = balikin($ryuk['orang_nama']);
	
	
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
			mysql_query("INSERT INTO item_rekap(kd, item_kd, item_kode, item_nama, ".
							"tglnya, postdate_pinjam, postdate_kembali, postdate, jml_jam, jml_menit) VALUES ".
							"('$i_xyz', '$i_kd', '$i_kode', '$i_nama', ".
							"'$tglnyax', '$yuk_masuk', '$yuk_pulang', '$today', '$jml_jam', $jml_menit)");







			//update
			$pinjam_nama = cegah("$i_orang_kode. $i_orang_nama");
			$pinjam_masuk = $yuk_masuk;
			$pinjam_pulang = $yuk_pulang;
			$pinjam_lama = $yuk_selisihx;
			
			mysql_query("UPDATE m_item SET pinjam_nama = '$pinjam_nama', ".
							"pinjam_masuk = '$pinjam_masuk', ".
							"pinjam_pulang = '$pinjam_pulang', ".
							"pinjam_lama = '$pinjam_lama' ".
							"WHERE kd = '$i_kd'");
			 
			 
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			'.$yuk_masuk.'
			</td>
			<td>
			'.$yuk_pulang.'
			</td>
			<td><img src="'.$nil_foto1.'" width="150"></td>
			<td>'.$i_item_kode.'</td>
			<td>
			'.$i_item_nama.'
			</td>
			<td>
			'.$i_orang_kode.'. 
			'.$i_orang_nama.'
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