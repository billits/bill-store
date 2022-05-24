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
		$sqlre= "SELECT max(tb_free_produk.id_fp) as maxKode FROM tb_free_produk WHERE event_fp = 'OFFICE' AND kantor_fp = '$off' 
		AND MONTH(waktu_fp) = MONTH(CURRENT_DATE()) AND YEAR(waktu_fp) = YEAR(CURRENT_DATE()) ";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
		
		$kodeRan = $rowre['maxKode'];
		$noUrut = (int) substr($kodeRan, 14, 20);
		$noUrut++;
		$kode_temp = "NFB-".date("m")."-".date("y")."-".$off."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);
		
		$sql = "INSERT INTO tb_free_produk (id_fp, waktu_fp, event_fp, status_fp, staff_fp, kantor_fp, keterangan_fp) 
						VALUES ('$kode', NOW(), 'OFFICE', 'PENDING', '$id', '$off', '0')";
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
