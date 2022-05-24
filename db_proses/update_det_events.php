<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$id_evt = $_POST['id_evt'];
	$nama_evt = ucwords(strtolower($_POST['nama_evt']));
	$ket_evt = ucwords(strtolower($_POST['ket_evt']));
	$statevt = $_POST['statevt1'];

	if ($statevt==""){
		$statevt = $_POST['statevt'];
	}

	$cek=0;
	$valid=0;
	// 1 - error data kosong

  if (empty($nama_evt)||empty($ket_evt)){
		$valid=1;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlll = "UPDATE tb_detail_events SET nama_det_event='$nama_evt', keterangan_det_event='$ket_evt', time_det_event=NOW(), status_det_event='$statevt'
		WHERE id_det_event='$id_evt'";
    $result = mysqli_query($kon,$sqlll);	  

		if (!$result) {
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Dirubah";
		}else{
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai benar
			$status['error']="Data Gagal Dirubah";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}
	
	echo json_encode($status);
?>
