<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - uang kurang
	
	$jenis = $_POST['jenis'];
	$buy = $_POST['buy'];
	$nama = $_POST['nama'];
	$tlp = $_POST['tlp'];
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$kantor = $_POST['office'];
	$staff = $_POST['pegawai'];
	$vou = $_POST['Voucher'];
	$dibayar = $_POST['Dibayar'];

	$total_final=$total-$vou;
	$kembalian=$dibayar-$total_final;

  if (empty($jenis)||empty($buy)||empty($dibayar)||empty($nama)||empty($tlp)||empty($total)||empty($nota)||empty($ketsup)||empty($kantor)||empty($staff)){
		$valid=1;
	}

	if($total_final>$dibayar){
		$valid=2;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
	
		$sqlre= "SELECT * FROM tb_man_trans WHERE id_mt='$nota'";
		$resultre = mysqli_query($kon,$sqlre);
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$evt_jual = $rowre['acara_mt'];

		$sl = "UPDATE tb_man_trans SET tgl_order_mt=NOW(), total_mt='$total_final', tgl_approv_mt=NOW(), cara_bayar_mt='$buy', jenis_mt='$jenis', 
		cs_mt='$nama', tlp_mt='$tlp', checking_mt='AUTO', keterangan_mt='$ketsup', voucher_mt='$vou', dibayar_mt='$dibayar', kembalian_mt='$kembalian' 
		WHERE id_mt='$nota'";
		$reslt = mysqli_query($kon,$sl);

		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['nott']=$nota; 
			$status['evtt']=$evt_jual; 
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
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
    $status['error']="Total Dibayarkan Kurang, Tidak Dapat Diproses";
	}
	
	echo json_encode($status);
?>
