<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong

	$kode_produk = strtoupper($_POST['kode_produk']);
	$pdk = $_POST['pdk'];
	$seq = $_POST['seq'];
	$jum = $_POST['jum_produk'];

  if (empty($pdk)||empty($seq)||empty($jum)){
		$valid=1;
	}

	$sql= "SELECT id_paket FROM tb_paket_produk ORDER BY id_paket DESC LIMIT 1";
	$rest = mysqli_query($kon,$sql);
	$row = mysqli_fetch_array($rest,MYSQLI_ASSOC);
	$count = mysqli_num_rows($rest);

	if($count < 1) {
		$id_paket = 1;
	}else{
		$id_paket = $row['id_paket']+1;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT id_paket FROM tb_paket_produk WHERE produk_paket='$kode_produk' AND seq_paket='$seq' AND status_paket='ON'";
		$resultre = mysqli_query($kon,$sqlre);
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
      
		if($countre < 1) {
			$sqlll = "INSERT INTO tb_paket_produk(id_paket, produk_paket, seq_paket, det_produk, jum_pro_paket, status_paket, waktu_paket) 
				VALUES ('$id_paket', '$kode_produk', '$seq', '$pdk', '$jum', 'ON', NOW())";
      $result = mysqli_query($kon,$sqlll);	  

			if(!$result) {    
				$cek=$cek+1;
			}				

		}else{     
			$id_temp=$rowre['id_paket'];

			$sqll = "UPDATE tb_paket_produk SET status_paket='OFF' WHERE id_paket='$id_temp'";
			$resullt = mysqli_query($kon,$sqll);	

			$sqlll = "INSERT INTO tb_paket_produk(id_paket, produk_paket, seq_paket, det_produk, jum_pro_paket, status_paket, waktu_paket) 
								VALUES ('$id_paket', '$kode_produk', '$seq', '$pdk', '$jum', 'ON', NOW())";
      $result = mysqli_query($kon,$sqlll);	 

			if(!$resullt) {    
				$cek=$cek+1;
			}
			if(!$result) {    
				$cek=$cek+1;
			}
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Paket Produk Berhasil Ditambahkan";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Paket Produk Gagal Ditambah";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
    $status['error']="Inputan Tidak Boleh Kosong";
	}
	echo json_encode($status);
?>
