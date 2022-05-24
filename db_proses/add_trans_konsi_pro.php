<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - lebihi stok
	// 3 - sudah ada di list

	$nota = $_POST['nota'];
	$produk = $_POST['kode_produk'];
	$price = $_POST['price'];
	$qty = $_POST['qty'];
	$hh_pro = $_POST['hh_pro'];	
	$diskon = $_POST['diskon'];
	$topro = $_POST['topro'];

  if (empty($nota)||empty($produk)||empty($price)||empty($qty)||empty($hh_pro)||empty($topro)){
		$valid=1;
	}

	$hrg_diskon=$diskon;
	$hrg_pdk=$price-$hrg_diskon;
	$tot = $qty*$hrg_pdk;  

	if ($qty<=$topro){
		$sqlre1= "SELECT * FROM tb_detail_jual WHERE nota_detjual='$nota' AND produk_detjual='$produk'";
		$resultre1 = mysqli_query($kon,$sqlre1);
		$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
		$countre1 = mysqli_num_rows($resultre1);
	
		if($countre1 >= 1) {  
			$valid=3;
		}
	}else{
		$valid=2;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		$sql2 = "INSERT INTO tb_detail_jual(nota_detjual, produk_detjual, harga_detjual, qty_detjual, diskon_detjual, total_jumlah_detjual) VALUES 
				('$nota', '$produk', '$hh_pro', '$qty', '$diskon', '$tot')";
		$result2 = mysqli_query($kon,$sql2);
		
		if(!$result2) {    
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
    $status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Jumlah Melebih Batas Stok Konsi";
	}elseif($valid==3){
		$status['nilai']=0; //bernilai salah
		$status['error']="Sudah Ada di List";
	}

	echo json_encode($status);
?>
