<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
nocache;

//nilai
$filenya = "item_pdf.php";
$judul = "Data Item";
$judulku = "$judul";
$judulx = $judul;
$kd = nosql($_REQUEST['kd']);

	
	
//re-direct, bikin pdf-nya...
require("../../inc/class/booking.php");	



//start class
$pdf=new PDF('P','mm','F8');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);





//detail
$qku = mysql_query("SELECT * FROM m_item ".
						"WHERE kd = '$kd'");
$rku = mysql_fetch_assoc($qku);
$ku_kode = nosql($rku['kode']);
$ku_nama = balikin($rku['nama']);



//kotak
$pdf->SetX(10);
$pdf->Cell(80,40,'',1,0,'L');



//qrcode
$pdf-> Image('../../filebox/qrcode/'.$kd.'.png',35,12,30);


$pdf->SetY(40);
$pdf->SetFont('Times','B',12);
$pdf->Cell(80,12,''.$ku_kode.'',0,0,'C');






//output-kan ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->Output("item_$kd.pdf",I);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	

//null-kan
exit();
?>