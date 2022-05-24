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

		$sqlre= "SELECT * FROM tb_po WHERE id_po = '$nota'";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		
		$date_beli = $rowre['tgl_po'];
		$date_app = $rowre['tgl_approv_po'];
		$totjum=$rowre['total_po'];

		$fix_jum=$totjum - $jum_old + $total;

		$sqll = "UPDATE tb_po SET tgl_po='$date_beli', tgl_approv_po='$date_app', total_po='$fix_jum' WHERE id_po='$nota'";
		$res = mysqli_query($kon,$sqll);

		$sqlll = "UPDATE tb_detail_po SET qty_detpo='$qty', total_jumlah_detpo='$total' WHERE nota_detpo='$nota' AND produk_detpo='$kode_produk'";
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
