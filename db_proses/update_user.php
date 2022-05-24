<?php
	include "koneksi.php";

	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - id double

	$create_by = $_COOKIE['idstaff_bill'];
	$id_pegawai = $_POST['id_pegawai'];
	$nama_pegawai = ucwords(strtolower($_POST['nama_pegawai']));
	$username_pegawai = $_POST['username_pegawai'];
	$passwd_pegawai = $_POST['passwd_pegawai'];
	$office_pegawai = $_POST['office_pegawai1'];
	$active_pegawai = $_POST['active_pegawai1'];

	if ($office_pegawai == ""){
		$office_pegawai = $_POST['office_pegawai'];
	}

	if ($active_pegawai == ""){
		$active_pegawai = $_POST['active_pegawai'];
	}
	
  if (empty($create_by)||empty($id_pegawai)||empty($nama_pegawai)||empty($username_pegawai)||empty($passwd_pegawai)){
		$valid=1;
	}

	$sqlr = "SELECT * FROM tb_staff WHERE uname_staff='$username_pegawai' AND kode_staff!='$id_pegawai'";
	$resultr = mysqli_query($kon,$sqlr);
	$rowr = mysqli_fetch_array($resultr,MYSQLI_ASSOC);
	$countr = mysqli_num_rows($resultr);

	if ($countr>=1){
		$valid=2;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlll = "UPDATE tb_staff SET nama_staff='$nama_pegawai', office_staff='$office_pegawai', uname_staff='$username_pegawai', pass_staff='$passwd_pegawai', create_staff='$create_by', active_staff='$active_pegawai' WHERE kode_staff='$id_pegawai'";
		$result = mysqli_query($kon,$sqlll);	  
	
		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Pegawai Berhasil Dirubah";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Dirubah";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Username Sudah Digunakan";
	}
	echo json_encode($status);
?>
