<?php
	include "koneksi.php";
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - id double
	
	$nota = $_POST['nota'];
	$produk = $_POST['kode_produk'];
	$price = $_POST['price'];
	$qty = $_POST['qty'];
	$hh_pro = $_POST['hh_pro'];

  if (empty($nota)||empty($produk)||empty($price)||empty($qty)||empty($hh_pro)){
		$valid=1;
	}

	$tot = $qty*$price;

	$sqlre= "SELECT * FROM tb_detail_restok WHERE nota_detrestok= '$nota' AND produk_detrestok='$produk'";
	$resultre = mysqli_query($kon,$sqlre);
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);

	if($countre >= 1) { 
		$valid=2;	         
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		$sql = "INSERT INTO tb_detail_restok(nota_detrestok, produk_detrestok, harga_detrestok, qty_detrestok, diskon_detrestok, total_jumlah_detrestok) 
					VALUES ('$nota', '$produk', '$hh_pro', '$qty', '0', '$tot')";
		$result = mysqli_query($kon,$sql);	  
		
		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);  
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Ditambahkan";	
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
		}
	
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Produk Sudah Tersedia"; 
	}

	echo json_encode($status);
?>
