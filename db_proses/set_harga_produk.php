<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - error data kosong

	$kode_produk = strtoupper($_POST['kode_produk']);
	$region = $_POST['region'];
	$harga = $_POST['harga'];

  if (empty($region)||empty($harga)){
		$valid=1;
	}

	$sql= "SELECT id_harga FROM tb_harga_produk ORDER BY id_harga DESC LIMIT 1";
	$rest = mysqli_query($kon,$sql);
	$row = mysqli_fetch_array($rest,MYSQLI_ASSOC);
	$count = mysqli_num_rows($rest);

	if($count < 1) {
		$id_harga = 1;
	}else{
		$id_harga = $row['id_harga']+1;
	}
				
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT id_harga FROM tb_harga_produk WHERE produk_harga='$kode_produk' AND region_harga='$region' AND status_harga='ON'";
		$resultre = mysqli_query($kon,$sqlre);
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);

		if($countre < 1) {		
			$sqlll = "INSERT INTO tb_harga_produk(id_harga, produk_harga, region_harga, harga_harian, status_harga, waktu_harga) 
								VALUES ('$id_harga', '$kode_produk', '$region', '$harga', 'ON', NOW())";
      $result = mysqli_query($kon,$sqlll);	  

			if (!$result) {
				$cek=$cek+1;
			}	 			
		}else{
			$id_temp=$rowre['id_harga'];
			$sqll = "UPDATE tb_harga_produk SET status_harga='OFF' WHERE id_harga='$id_temp'";
			$resullt = mysqli_query($kon,$sqll);	

			$sqlll = "INSERT INTO tb_harga_produk(id_harga, produk_harga, region_harga, harga_harian, status_harga, waktu_harga) 
								VALUES ('$id_harga', '$kode_produk', '$region', '$harga', 'ON', NOW())";
      $result = mysqli_query($kon,$sqlll);	  

			if (!$resullt) {
				$cek=$cek+1;
			}

			if (!$result) {
				$cek=$cek+1;
			}
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Harga Produk Berhasil Ditambahkan";
		}else{
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai benar
			$status['error']="Data Harga Produk Gagal Ditambah";
		}

		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}
	echo json_encode($status);
?>
