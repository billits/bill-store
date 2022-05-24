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

	$query = "SELECT * FROM tb_man_trans WHERE id_mt='$kode_nota'";
	$result = mysqli_query($kon, $query);
	$baris = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);

	$acara = $baris['acara_mt'];
	$kantor = $baris['kantor_mt'];
	$tgl_order = $baris['tgl_order_mt'];
	$status_order = $baris['status_mt'];
	$udahntj = $baris['manual_mt'];

	if($status_order=='CANCEL'){
		$valid=2;
	}
	if($udahntj!='0'){
		$valid=2;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

  	$sql1 = "UPDATE tb_man_trans SET tgl_order_mt='$tgl_order', tgl_approv_mt=NOW(), status_mt='CANCEL' WHERE id_mt='$kode_nota'";
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
