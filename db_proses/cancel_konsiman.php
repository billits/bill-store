<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	$count =0;
	// 1 - data kosong
	// 2 - sudah diproses

	$kode_nota= $_POST['nota'];
	$staff = $_COOKIE['idstaff_bill'];
	
  if (empty($kode_nota)||empty($staff)){
		$valid=1;
	}

	$query = "SELECT * FROM tb_man_konsi WHERE id_mk='$kode_nota'";
	$result = mysqli_query($kon, $query);
	$baris = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);

	$kantor = $baris['kantor_mk'];
	$tgl_order = $baris['tgl_order_mk'];
	$status_order = $baris['status_mk'];
	$udahntj = $baris['manual_mk'];

	if($status_order=='CANCEL'){
		$valid=2;
	}
	if($udahntj!='0'){
		$valid=2;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

  	$sql1 = "UPDATE tb_man_konsi SET tgl_order_mk='$tgl_order', tgl_approv_mk=NOW(), status_mk='CANCEL' WHERE id_mk='$kode_nota'";
		$result1 = mysqli_query($kon,$sql1);
	
		if(!$result1) {    
			$cek=$cek+1;
		}	
	
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Di Cancel";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Di Cancel";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
    $status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Sudah di Cancel"; 
	}
	echo json_encode($status);
?>
