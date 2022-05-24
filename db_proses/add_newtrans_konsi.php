<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$id=$_COOKIE["idstaff_bill"];
	$off=$_COOKIE["office_bill"];
	$ntj = $_REQUEST['ntj'];

  if (empty($id)||empty($off)||empty($ntj)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT max(tb_jual.id_jual) as maxKode FROM tb_jual WHERE acara_jual = 'OFFICE' AND kantor_jual = '$off' 
		AND MONTH(tgl_order_jual) = MONTH(CURRENT_DATE()) AND YEAR(tgl_order_jual) = YEAR(CURRENT_DATE()) ";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
		
		$kodeRan = $rowre['maxKode'];
		$noUrut = (int) substr($kodeRan, 14, 20);
		$noUrut++;
		$kode_temp = "NTJ-".date("m")."-".date("y")."-".$off."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);
		
		$sql = "INSERT INTO tb_jual
		(id_jual, tgl_order_jual, acara_jual, total_jual, cara_bayar_jual, status_jual, tgl_approv_jual, counter_jual, gudang_jual, keterangan_jual, jenis_jual, nama_customer, tlp_customer, checking_by, kantor_jual, voucher_jual, dibayar_jual, kembalian_jual) 
		VALUES ('$kode', NOW(), 'OFFICE', '0', '0', 'PENDING', NOW(), '$id', '0', '$ntj', '0', '0', '0', '0', '$off', '0', '0', '0')";
		$result = mysqli_query($kon,$sql);	  
		
		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Ditambahkan";	
			$status['nota']= $kode;
			$status['ntjk']= $ntj;
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
