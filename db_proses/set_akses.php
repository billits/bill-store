<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - error data kosong

	$id_pegawai = $_POST['id_pegawai'];
	$akses = $_POST['akses'];
	$myid = $_COOKIE['idstaff_bill'];

  if (empty($akses)||empty($id_pegawai)||empty($myid)){
		$valid=1;
	}

	$sql= "SELECT * FROM tb_akses WHERE staff_akses='$id_pegawai' AND status_akses='$akses'";
	$rest = mysqli_query($kon,$sql);
	$row = mysqli_fetch_array($rest,MYSQLI_ASSOC);
	$count = mysqli_num_rows($rest);

	if($count>=1) {
		$valid=2;
	}
				
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlll = "INSERT INTO tb_akses(staff_akses, status_akses, admin_akses, waktu_akses) 
						VALUES ('$id_pegawai', '$akses', '$myid', NOW())";
    $result = mysqli_query($kon,$sqlll);	  

		if (!$result) {
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Akses Berhasil Ditambahkan";
		}else{
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai benar
			$status['error']="Data Gagal Ditambah";
		}

		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Akses Sudah Ada";
	}
	echo json_encode($status);
?>
