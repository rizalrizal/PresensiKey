<?php 
function tglindonesia($tanggal){
	$splitTGL = explode('-', $tanggal);
	$bulan    = array ('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$penentuBulan = (int)$splitTGL[1]-1;
	$newTgl   = substr($splitTGL[2], 0, 2);
	$newBulan = $bulan[$penentuBulan];
	$newTahun = $splitTGL[0];
	
	$result   = $newTgl .' '. $newBulan .' '. $newTahun;
	
	
	return $result;
}
 ?>