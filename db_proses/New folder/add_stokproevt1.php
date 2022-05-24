<?php
	include "koneksi.php";
	
	$nota = $_POST['nota'];
	$produk = $_POST['kode_produk'];
	$price = $_POST['price'];
	$qty = $_POST['qty'];
	$hh_pro = $_POST['hh_pro'];
	$acara = $_POST['acara'];
	$office = $_POST['office'];

	$tot = $qty*$price;

	$sqlre1= "SELECT * FROM detail_beli_event WHERE nota_detbelev='$nota' AND produk_detbelev='$produk'";
    $resultre1 = mysqli_query($kon,$sqlre1);
	$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
    $countre1 = mysqli_num_rows($resultre1);

    if($countre1 < 1) {  

		$sql = "INSERT INTO detail_beli_event(nota_detbelev, produk_detbelev, harga_detbelev, qty_detbelev, diskon_detbelev, total_jumlah_detbelev)
		VALUES ('$nota', '$produk', '$hh_pro', '$qty', '0', '$tot')";
		$result = mysqli_query($kon,$sql);	  
		
			if($result) {       
				$status['nilai']=1; //bernilai benar
				$status['error']="Data Berhasil Ditambahkan";	
			}else{          
				$status['nilai']=0; //bernilai salah
				$status['error']="Data Gagal Ditambah";
			}
    }else{
		$status['nilai']=0; //bernilai salah
		$status['error']="Sudah Ada di List";
	}

	echo json_encode($status);
?>
