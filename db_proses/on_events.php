<?php
	include "koneksi.php";
	
	$cek=0;
	$id= $_REQUEST['mati'];;
	
  $sql = "UPDATE tb_detail_events SET status_det_event='ON', time_det_event=NOW() WHERE id_det_event='$id'";
	$result = mysqli_query($kon,$sql);

	if (!$result) {
		$cek=$cek+1;
	}

	if ($cek==0){
		mysqli_commit($kon);
		$status['nilai']=1; //bernilai benar
		$status['error']="Data Berhasil Dinonaktifkan";
	}else{
		mysqli_rollback($kon);
		$status['nilai']=0; //bernilai benar
		$status['error']="Data Gagal Dinonaktifkan";
	}
	
	mysqli_close($kon);
	echo json_encode($status);
?>
