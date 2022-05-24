<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong

	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = "Konsi Dari Pusat";
	$kantor_lama = $_POST['office'];
	$staff = $_POST['pegawai'];
		
  if (empty($total)||empty($nota)||empty($ketsup)||empty($staff)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlrr = "UPDATE tb_po SET total_po='$total', keterangan_po='$ketsup', status_po='SUCCESS', supplier_po='$staff' WHERE id_po='$nota'";
		$resltrr = mysqli_query($kon,$sqlrr);

		if(!$resltrr) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Orderan Berhasil Dikirim";
			$status['kode_nota']=$nota;
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
