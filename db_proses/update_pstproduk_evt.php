<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	
	$kode_produk = $_POST['kode_produk'];
	$qty = $_POST['qty'];
	$nota = $_POST['nota'];
	$price = $_POST['price'];
	$jum_old = $_POST['jum_old'];
	$total=$qty*$price;

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT * FROM tb_beli_event WHERE id_beli_event = '$nota'";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		
		$totjum=$rowre['total_beli_event'];
		$tgl=$rowre['tgl_beli_event'];
		$fix_jum=$totjum - $jum_old + $total;

		$sqll = "UPDATE tb_beli_event SET total_beli_event='$fix_jum', tgl_beli_event='$tgl' WHERE id_beli_event='$nota'";
		$res = mysqli_query($kon,$sqll);

		$sqlll = "UPDATE tb_detail_beli_event SET qty_detbelev='$qty', total_jumlah_detbelev='$total' WHERE nota_detbelev='$nota' AND produk_detbelev='$kode_produk'";
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
		$status['link']=$nota;
	}

	echo json_encode($status);
?>
