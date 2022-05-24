<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong

	$kode_events = strtoupper($_POST['kode_events']);
	$nama_events = ucwords(strtolower($_POST['nama_events']));
	$ket_events = ucwords(strtolower($_POST['ket_events']));
	$lvl_events = $_POST['lvl_events1'];

  if (empty($nama_events)||empty($kode_events)||empty($ket_events)){
		$valid=1;
	}

	if($lvl_events==""){
		$lvl_events = $_POST['lvl_events'];
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);
		
		$sqlll = "UPDATE tb_events SET nama_events='$nama_events', time_events=NOW(), keterangan_events='$ket_events', level_events='$lvl_events' WHERE id_events='$kode_events'";
    $result = mysqli_query($kon,$sqlll);	  

		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Event Berhasil Dirubah";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}
	echo json_encode($status);
?>
