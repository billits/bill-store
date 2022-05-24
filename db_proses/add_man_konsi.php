<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - uang kurang
	
	$nama = $_POST['nama'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$total_final = $_POST['bayar'];

	if (empty($nama)||empty($nota)||empty($ketsup)||empty($total_final)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT * FROM tb_man_konsi WHERE id_mk='$nota'";
		$resultre = mysqli_query($kon,$sqlre);
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$tgl_order = $rowre['tgl_order_mk'];		
		$tgl_approv = $rowre['tgl_approv_mk'];

		$sl = "UPDATE tb_man_konsi SET tgl_order_mk='$tgl_order', total_mk='$total_final', tgl_approv_mk='$tgl_approv', cs_mk='$nama', keterangan_mk='$ketsup' WHERE id_mk='$nota'";
		$reslt = mysqli_query($kon,$sl);
		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['nott']=$nota; 
			$status['error']="Data Transaksi Berhasil Diproses";
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
