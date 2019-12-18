<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
nocache;

//nilai
$filenya = "pegawai_pdf.php";
$judul = "Data Pegawai";
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
$qku = mysql_query("SELECT * FROM m_orang ".
						"WHERE kd = '$kd'");
$rku = mysql_fetch_assoc($qku);
$ku_kode = nosql($rku['kode']);
$ku_nama = balikin($rku['nama']);
$ku_jabatan = balikin($rku['jabatan']);
$ku_filex1 = balikin($rku['filex1']);



//kotak
$pdf->Cell(80,55,'',1,0,'L');







$pdf->SetY(10);
$pdf->SetFont('Times','B',12);
$pdf->Cell(80,12,'KARTU PEGAWAI',1,0,'L');


//set posisi
$pdf->SetY(22);
$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'NOMOR INDUK : ',0,0,'L');
$pdf->Ln();
$pdf->SetFont('Times','B',10);
$pdf->Cell(30,5,''.$ku_kode.'',0,0,'L');
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'NAMA : ',0,0,'L');
$pdf->Ln();
$pdf->SetFont('Times','B',10);
$pdf->Cell(30,5,''.$ku_nama.'',0,0,'L');
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Times','',10);
$pdf->Cell(20,5,'Jabatan : ',0,0,'L');
$pdf->Ln();
$pdf->SetFont('Times','B',10);
$pdf->Cell(30,5,''.$ku_jabatan.'',0,0,'L');
$pdf->Ln();
$pdf->Ln();





//foto
//$pdf-> Image('../../filebox/pegawai/'.$kd.'/'.$ku_filex1.'',58,25,30);



//qrcode
//$pdf-> Image('../../filebox/qrcode/'.$kd.'.png',77,11,10);
$pdf-> Image('../../filebox/qrcode/'.$kd.'.png',58,25,30);






//output-kan ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->Output("pegawai_$kd.pdf",I);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	

//null-kan
exit();
?>