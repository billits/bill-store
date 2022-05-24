<?php
	include "koneksi.php";
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - id double
	
	$id_office = strtoupper($_POST['kode_office']);
	$nama = ucwords(strtolower($_POST['nama_office']));
	$kota = strtoupper($_POST['kota_office']);
	$region = $_POST['region_office'];

  if (empty($id_office)||empty($nama)||empty($kota)||empty($region)){
		$valid=1;
	}

	$sqlre= "SELECT * FROM tb_office WHERE id_office= '$id_office'";
	$resultre = mysqli_query($kon,$sqlre);
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);

	if($countre == 1) {				     	
		$valid=2;    
	}
	
	$jml_karakter = strlen($id_office);
	if ($jml_karakter>3){			
		$valid=3;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);
		$sqlll = "INSERT INTO tb_office(id_office, nama_office, kota_office, region_office) VALUES ('$id_office', '$nama', '$kota', '$region')";
		$result = mysqli_query($kon,$sqlll);	  

		if($result) {    
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Office Berhasil Ditambahkan";
		}else{          
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
		}

		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Office Berhasil Ditambahkan";
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
		$status['error']="Kode Office Sudah Tersedia"; 
	}elseif($valid==3){
		$status['nilai']=0; //bernilai salah
		$status['error']="Jumlah Huruf Tidak Boleh Lebih Dari 3";
	}
	echo json_encode($status);
?>
