<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
nocache;

//nilai
$filenya = "pegawai_qrcode.php";
$judul = "Data Pegawai";
$judulku = "$judul";
$judulx = $judul;
$kd = nosql($_REQUEST['kd']);

	
	


//bikin qrcode ///////////////////////////////////////////////////////////////////////////////////
include('../../inc/class/phpqrcode/qrlib.php');
include('../../inc/class/phpqrcode/qrconfig.php');

// how to save PNG codes to server

//$tempDir = EXAMPLE_TMP_SERVERPATH;
$tempDir = "../../filebox/qrcode/";

$codeContents = $kd;

// we need to generate filename somehow, 
// with md5 or with database ID used to obtains $codeContents...
//$fileName = '005_file_'.md5($codeContents).'.png';
$fileName = "$codeContents.png";

$pngAbsoluteFilePath = $tempDir.$fileName;
$urlRelativeFilePath = EXAMPLE_TMP_URLRELPATH.$fileName;

// generating
if (!file_exists($pngAbsoluteFilePath)) {
    QRcode::png($codeContents, $pngAbsoluteFilePath);
    //echo 'File generated!';
    //echo '<hr />';
} else {
    //echo 'File already generated! We can use this cached file to speed up site on common codes!';
    //echo '<hr />';
}


	

//re-direct
$ke = "pegawai_pdf.php?kd=$kd";
xloc($ke);
exit();
?>