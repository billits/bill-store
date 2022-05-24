<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$id=$_COOKIE["idstaff_bill"];
	$off=$_COOKIE["office_bill"];

  if (empty($id)||empty($off)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT max(id_mt) as maxKode FROM tb_man_trans WHERE acara_mt = 'OFFICE' AND kantor_mt = '$off' 
		AND MONTH(tgl_order_mt) = MONTH(CURRENT_DATE()) AND YEAR(tgl_order_mt) = YEAR(CURRENT_DATE()) ";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
		
		$kodeRan = $rowre['maxKode'];
		$noUrut = (int) substr($kodeRan, 14, 20);
		$noUrut++;
		$kode_temp = "MNJ-".date("m")."-".date("y")."-".$off."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);
	
		$sql = "INSERT INTO tb_man_trans
		(id_mt, tgl_order_mt, acara_mt, total_mt, cara_bayar_mt, status_mt, tgl_approv_mt, counter_mt, gudang_mt, keterangan_mt, jenis_mt, cs_mt, tlp_mt, checking_mt, kantor_mt, voucher_mt, dibayar_mt, kembalian_mt, manual_mt) 
		VALUES ('$kode', NOW(), 'OFFICE', '0', '0', 'PENDING', NOW(), '$id', '0', '0', '0', '0', '0', '0', '$off', '0', '0', '0', '0')";
		$result = mysqli_query($kon,$sql);	  
			
		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Ditambahkan";		
			$status['nota']= $kode;
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
