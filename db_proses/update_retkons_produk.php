<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	$count =0;
	// 1 - data kosong
	// 2 - lebih batas
	// 3 - sudah ada di list
	
	$kode_produk = $_POST['kode_produk'];
	$qty = $_POST['qty'];
	$nota = $_POST['nota'];
	$total = $_POST['total'];
	$evt = $_POST['evt'];
	$ret = $_POST['ret'];
	$pc = $_POST['pc'];
	
  if (empty($nota)||empty($kode_produk)){
		$valid=1;
	}

	if ($qty>$total){
		$valid=2;
	}

	$sqlre1= "SELECT * FROM tb_detail_retur_transaksi WHERE id_detrettrans = '$nota' AND produk_detrettrans='$kode_produk'";
	$resultre1 = mysqli_query($kon,$sqlre1);	  
	$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
	$countre1 = mysqli_num_rows($resultre1);

	if($countre1 >= 1) {	
		$valid=3;		
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT * FROM tb_harga_produk WHERE id_harga = '$pc'";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$subtotal=$qty*$rowre['harga_harian'];
	
		$sql = "INSERT INTO tb_detail_retur_transaksi(id_detrettrans, produk_detrettrans, jumret_detrettrans, harga_detrettrans, totjum_detrettrans) 
			VALUES ('$nota', '$kode_produk', '$qty', '$pc', '$subtotal')";
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
		$status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Jumlah Retur Melebihi Stok";
	}elseif($valid==3){
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Sudah Ada Di List";	
	}

	echo json_encode($status);
?>
