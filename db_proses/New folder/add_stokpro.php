<?php
	include "koneksi.php";
	session_start();
	
	$nota = $_POST['nota'];
	$produk = $_POST['kode_produk'];
	$price = $_POST['price'];
	$qty = $_POST['qty'];
	$hh_pro = $_POST['hh_pro'];

	$tot = $qty*$price;

	$sql = "INSERT INTO detail_beli(nota_detbeli, produk_detbeli, harga_detbeli, qty_detbeli, diskon_detbeli, total_jumlah_detbeli) VALUES ('$nota', '$produk', '$hh_pro', '$qty', '0', '$tot')";
  	$result = mysqli_query($kon,$sql);	  
   	  

	if($result) {    
		$status['nilai']=1; //bernilai benar
		$status['error']="Data Berhasil Ditambahkan";	
	}else{          
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Gagal Ditambah";
	}

	echo json_encode($status);
?>
