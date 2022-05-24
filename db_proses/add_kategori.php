<?php
	include "koneksi.php";
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - id double

	$kode_kategori = strtoupper($_POST['kode_kategori']);
	$nama_kategori = ucwords(strtolower($_POST['nama_kategori']));

  if (empty($kode_kategori)||empty($nama_kategori)){
		$valid=1;
	}

	$sqlre= "SELECT * FROM tb_kategori WHERE id_kategori= '$kode_kategori'";
	$resultre = mysqli_query($kon,$sqlre);
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);
      
	if($countre >= 1) {			
		$valid=2;	         
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlll = "INSERT INTO tb_kategori(id_kategori, nama_kategori) VALUES ('$kode_kategori', '$nama_kategori')";
    $result = mysqli_query($kon,$sqlll);	  

		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Kategori Berhasil Ditambahkan";
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
		$status['error']="Kode Kategori Sudah Tersedia"; 
	}
	echo json_encode($status);
?>
