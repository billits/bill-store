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

	$sqlre= "SELECT * FROM gudang WHERE kode_office_gudang='$office' AND kode_produk_gudang='$produk' AND event_gudang='OFFICE'";
    $resultre = mysqli_query($kon,$sqlre);
    $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
    $countre = mysqli_num_rows($resultre);

    $temp = $rowre['jml_produk_gudang'];

    if($countre == 1) {  
        if($temp >= $qty){
			$sql = "INSERT INTO detail_beli_event(nota_detbelev, produk_detbelev, harga_detbelev, qty_detbelev, diskon_detbelev, total_jumlah_detbelev) VALUES ('$nota', '$produk', '$hh_pro', '$qty', '0', '$tot')";
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
			$status['error']="Stok Produk di Gudang Tidak Mencukupi";
        }
    }else{   		
		$status['nilai']=0; //bernilai salah
		$status['error']="Stok Produk di Gudang Tidak Ada";
    }

	echo json_encode($status);
?>
