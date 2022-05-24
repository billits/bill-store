<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$kode_produk = strtoupper($_POST['kode_produk']);
	$region = $_POST['region'];
	$harga = $_POST['harga'];

  if (empty($region)||empty($harga)){
		$status['nilai']=0; //bernilai salah
    $status['error']="Inputan Tidak Boleh Kosong";
	}else {
		$sqlre= "SELECT * FROM paket_produk WHERE produk_harga='$kode_produk' AND region_harga='$region' AND status_harga='ON'";
		$resultre = mysqli_query($kon,$sqlre);
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
      
		// If result matched $myusername and $mypassword, table row must be 1 row
		if($countre == 1) {				     
			$id_temp=$rowre['id_harga'];
			$sqll = "UPDATE harga_produk SET status_harga='OFF' WHERE id_harga='$id_temp'";
			$resullt = mysqli_query($kon,$sqll);	

			$sql= "SELECT * FROM harga_produk ORDER BY id_harga DESC LIMIT 1";
			$rest = mysqli_query($kon,$sql);
			$row = mysqli_fetch_array($rest,MYSQLI_ASSOC);
			$count = mysqli_num_rows($rest);
      
			// If result matched $myusername and $mypassword, table row must be 1 row
			$id_harga = $row['id_harga']+1;

			$sqlll = "INSERT INTO harga_produk(id_harga, produk_harga, region_harga, harga_harian, status_harga, waktu_harga) 
			VALUES ('$id_harga', '$kode_produk', '$region', '$harga', 'ON', NOW())";
      $result = mysqli_query($kon,$sqlll);	  

			if($result) {    
				$status['nilai']=1; //bernilai benar
				$status['error']="Harga Produk Berhasil Ditambahkan";
			}else{          
				$status['nilai']=0; //bernilai salah
				$status['error']="Data Harga Produk Gagal Ditambah";
      }
		}
		else{

			$sql= "SELECT * FROM harga_produk ORDER BY id_harga DESC LIMIT 1";
			$rest = mysqli_query($kon,$sql);
			$row = mysqli_fetch_array($rest,MYSQLI_ASSOC);
			$count = mysqli_num_rows($rest);
      
			// If result matched $myusername and $mypassword, table row must be 1 row
			$id_harga = $row['id_harga']+1;

			$sqlll = "INSERT INTO harga_produk(id_harga, produk_harga, region_harga, harga_harian, status_harga, waktu_harga) 
			VALUES ('$id_harga', '$kode_produk', '$region', '$harga', 'ON', NOW())";
      $result = mysqli_query($kon,$sqlll);	  

			if($result) {    
				$status['nilai']=1; //bernilai benar
				$status['error']="Harga Produk Berhasil Ditambahkan";
			}else{          
				$status['nilai']=0; //bernilai salah
				$status['error']="Data Harga Produk Gagal Ditambah";
      }
		}
	}
	echo json_encode($status);
?>
