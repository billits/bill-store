<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$nama_events = $_POST['nama_events'];
	$jenis_events = $_POST['jenis_events'];
	$kantor = $_POST['kantor'];
	$ket_events = ucwords(strtolower($_POST['ket_events']));

	$cek=0;
	$valid=0;
	// 1 - error data kosong

  if (empty($jenis_events)||empty($nama_events)||empty($kantor)||empty($ket_events)){
		$valid=1;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);

		//insert detail event
		$sqlll = "INSERT INTO tb_detail_events(nama_det_event, event_det_event, status_det_event, keterangan_det_event, time_det_event, office_det_event) VALUES 
		('$nama_events', '$jenis_events', 'ON', '$ket_events', NOW(), '$kantor')";
    $result = mysqli_query($kon,$sqlll);	  

		if (!$result) {
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Ditambahkan";
		}else{
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai benar
			$status['error']="Data Gagal Ditambahkan";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}
	
	echo json_encode($status);
?>
