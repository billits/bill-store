<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$nama = $_POST['nama'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$total_final = $_POST['bayar'];

  if (empty($total_final)||empty($nota)||empty($ketsup)||empty($nama)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
	
		$sqlre= "SELECT * FROM tb_jual_konsi WHERE id_jk='$nota'";
		$resultre = mysqli_query($kon,$sqlre);
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$tgl_order = $rowre['tgl_order_jk'];		
		$tgl_approv = $rowre['tgl_approv_jk'];

		$sl = "UPDATE tb_jual_konsi SET tgl_order_jk='$tgl_order', total_jk='$total_final', tgl_approv_jk='$tgl_approv', cs_jk='$nama', keterangan_jk='$ketsup' WHERE id_jk='$nota'";
		$reslt = mysqli_query($kon,$sl);

		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Transaksi Berhasil Diproses";
			$status['nott']=$nota; 
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
