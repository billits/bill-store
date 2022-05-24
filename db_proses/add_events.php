<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - id double
	// 3 - karakter lebih

	$kode_events = strtoupper($_POST['kode_events']);
	$nama_events = ucwords(strtolower($_POST['nama_events']));
	$ket_events = ucwords(strtolower($_POST['ket_events']));
	$level_evt = $_POST['level_evt'];

  if (empty($kode_events)||empty($nama_events)||empty($ket_events)){
		$valid=1;
	}
	
	$sqlre= "SELECT * FROM tb_events WHERE id_events= '$kode_events'";
	$resultre = mysqli_query($kon,$sqlre);
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);
		
	if($countre == 1) {				     
		$valid=2; 
	}

	$jml_karakter = strlen($kode_events);
	if ($jml_karakter>3){			
		$valid=3;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlll = "INSERT INTO tb_events(id_events, nama_events, level_events, time_events, keterangan_events) VALUES ('$kode_events', '$nama_events', '$level_evt',NOW(), '$ket_events')";
		$result = mysqli_query($kon,$sqlll);	  

		if($result) {    
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Events Berhasil Ditambahkan";
		}else{          
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Events Ditambah";
		}

		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Events Berhasil Ditambahkan";
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
		$status['error']="Kode Events Sudah Digunakan";
	}elseif($valid==3){
		$status['nilai']=0; //bernilai salah
		$status['error']="Jumlah Huruf Tidak Boleh Lebih Dari 3";
	}
	echo json_encode($status);
?>
