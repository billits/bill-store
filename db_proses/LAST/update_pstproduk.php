<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$kode_produk = $_POST['kode_produk'];
	$qty = $_POST['qty'];
	$nota = $_POST['nota'];
	$price = $_POST['price'];
	$jum_old = $_POST['jum_old'];
	$total=$qty*$price;

  if (empty($kode_produk)||empty($qty)||empty($nota)||empty($jum_old)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		$sqlre= "SELECT * FROM tb_beli WHERE id_beli = '$nota'";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$date_beli = $rowre['tgl_beli'];
		$date_app = $rowre['tgl_approv_beli'];
		$totjum=$rowre['total_beli'];
		$fix_jum=$totjum - $jum_old + $total;

		$sqll = "UPDATE tb_beli SET tgl_beli='$date_beli', tgl_approv_beli='$date_app', total_beli='$fix_jum' WHERE id_beli='$nota'";
		$res = mysqli_query($kon,$sqll);

		$sqlll = "UPDATE tb_detail_beli SET qty_detbeli='$qty', total_jumlah_detbeli='$total' WHERE nota_detbeli='$nota' AND produk_detbeli='$kode_produk'";
    $result = mysqli_query($kon,$sqlll);	  

		if(!$res) {    
			$cek=$cek+1;
		}
		if(!$result) {    
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Produk Berhasil Dirubah";
			$status['link']=$nota;
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Dirubah";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}

	echo json_encode($status);
?>
