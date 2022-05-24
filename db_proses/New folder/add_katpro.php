<?php
	include "koneksi.php";
	session_start();
	
	$kode_kategori = strtoupper($_POST['kode_kategori']);
	$nama_kategori = ucwords(strtolower($_POST['nama_kategori']));

  if (empty($kode_kategori)||empty($nama_kategori)){
		$status['nilai']=0; //bernilai salah
    $status['error']="Inputan Tidak Boleh Kosong";
	}else {
		$sqlre= "SELECT * FROM kategori WHERE id_kategori= '$kode_kategori'";
		$resultre = mysqli_query($kon,$sqlre);
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
      
		// If result matched $myusername and $mypassword, table row must be 1 row
		if($countre == 1) {				     
			$status['nilai']=0; //bernilai salah
			$status['error']="ID Kategori Sudah Tersedia";     
		}
		else{
			$sqlll = "INSERT INTO kategori(id_kategori, nama_kategori) VALUES ('$kode_kategori', '$nama_kategori')";
      $result = mysqli_query($kon,$sqlll);	  

			if($result) {    
				$status['nilai']=1; //bernilai benar
				$status['error']="Data Kategori Berhasil Ditambahkan";
			}else{          
				$status['nilai']=0; //bernilai salah
				$status['error']="Data Gagal Ditambah";
      }
		}
	}
	echo json_encode($status);
?>
