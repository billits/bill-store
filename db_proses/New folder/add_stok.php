<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$id=$_COOKIE["id_pegawai"];
	$off=$_COOKIE["id_office"];

	$sqlre= "SELECT * FROM beli WHERE jenis_beli = 'SUPPLY' AND kantor_beli = '$off' AND MONTH(tgl_beli) = MONTH(CURRENT_DATE()) AND YEAR(tgl_beli) = YEAR(CURRENT_DATE()) ";
	$resultre = mysqli_query($kon,$sqlre);	  
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);
	
	$kode1=$countre+1;
	$kode = "BTB-".date("m")."-".date("y")."-".$off."-".$kode1;
	
	$sql = "INSERT INTO beli(id_beli, tgl_beli, status_beli, cara_bayar_beli, jenis_beli, event_beli, staff_beli, kantor_beli) VALUES ('$kode', NOW(), 'APPROVE', 'KONSI', 'SUPPLY', 'OFFICE', '$id', '$off')";
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
