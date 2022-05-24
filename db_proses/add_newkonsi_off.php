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

		$sqlre= "SELECT max(tb_jual_konsi.id_jk) as maxKode FROM tb_jual_konsi WHERE kantor_jk = '$off' 
		AND MONTH(tgl_order_jk) = MONTH(CURRENT_DATE()) AND YEAR(tgl_order_jk) = YEAR(CURRENT_DATE()) ";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
		
		$kodeRan = $rowre['maxKode'];
		$noUrut = (int) substr($kodeRan, 15, 21);
		$noUrut++;
		$kode_temp = "NTJK-".date("m")."-".date("y")."-".$off."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);
		
		$sql = "INSERT INTO tb_jual_konsi
		(id_jk, tgl_order_jk, total_jk, cara_bayar_jk, status_jk, tgl_approv_jk, counter_jk, gudang_jk, keterangan_jk, jenis_jk, cs_jk, kantor_jk, retur_jk) 
		VALUES ('$kode', NOW(), '0', 'KONSI', 'PENDING', NOW(), '$id', '0', '0', 'KONSI LEADER', '0', '$off', '0')";
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
