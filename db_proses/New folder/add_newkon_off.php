<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$id=$_COOKIE["id_pegawai"];
	$off=$_COOKIE["id_office"];

	$sqlre= "SELECT max(jual.id_jual) as maxKode FROM jual WHERE acara_jual = 'OFFICE' AND kantor_jual = '$off' 
	AND MONTH(tgl_order_jual) = MONTH(CURRENT_DATE()) AND YEAR(tgl_order_jual) = YEAR(CURRENT_DATE()) ";
	$resultre = mysqli_query($kon,$sqlre);	  
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);
	
	$kodeRan = $rowre['maxKode'];
	$noUrut = (int) substr($kodeRan, 14, 20);
	$noUrut++;
	$kode_temp = "NTJ-".date("m")."-".date("y")."-".$off."-";
	$kode = $kode_temp . sprintf("%05s", $noUrut);
	
	$sql = "INSERT INTO jual
	(id_jual, tgl_order_jual, acara_jual, status_jual, counter_jual, kantor_jual) 
	VALUES ('$kode', NOW(), 'OFFICE', 'PENDING', '$id', '$off')";
	$result = mysqli_query($kon,$sql);	  
   	  

	if($result) {    
		$status['nilai']=1; //bernilai benar
		$status['error']="Data Berhasil Ditambahkan";		
		$status['nota']= $kode;
	}else{          
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Gagal Ditambah";
	}

	echo json_encode($status);
?>
