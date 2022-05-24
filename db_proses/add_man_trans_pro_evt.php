<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - id double di list
	
	$staff = $_COOKIE["idstaff_bill"];
	$nota = $_POST['nota'];
	$produk = $_POST['kode_produk'];
	$price = $_POST['price'];
	$qty = $_POST['qty'];
	$hh_pro = $_POST['hh_pro'];
	$office = $_POST['office'];
	$diskon = $_POST['diskon'];
	$kategori = $_POST['cate'];

  if (empty($staff)||empty($nota)||empty($produk)||empty($price)||empty($qty)||empty($hh_pro)||empty($office)||empty($kategori)){
		$valid=1;
	}

	$hrg_diskon=$diskon;
	$hrg_pdk=$price-$hrg_diskon;
	$tot = $qty*$hrg_pdk;  

	$sqlre1= "SELECT * FROM tb_detail_mantrans WHERE nota_detmt='$nota' AND produk_detmt='$produk'";
  $resultre1 = mysqli_query($kon,$sqlre1);
	$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
  $countre1 = mysqli_num_rows($resultre1);

	if($countre1 >= 1) {  
		$valid=2;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sql = "INSERT INTO tb_detail_mantrans(nota_detmt, produk_detmt, harga_detmt, qty_detmt, diskon_detmt, total_jumlah_detmt) VALUES 
			('$nota', '$produk', '$hh_pro', '$qty', '$diskon', '$tot')";
		$result = mysqli_query($kon,$sql);	 

		if(!$result) {    
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data  Berhasil Ditambahkan";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Sudah Ada di List";
	}

	echo json_encode($status);
?>
