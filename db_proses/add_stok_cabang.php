<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong

	$id=$_COOKIE["idstaff_bill"];
	$off=$_COOKIE["office_bill"];

  if (empty($off)||empty($id)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT max(id_po) as maxKode FROM tb_po WHERE jenis_po = 'SUPPLY' AND kantor_po = '$off' AND MONTH(tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(tgl_po) = YEAR(CURRENT_DATE()) ";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
		
		$kodeRan = $rowre['maxKode'];
		$noUrut = (int) substr($kodeRan, 14, 20);
		$noUrut++;
		$kode_temp = "NPO-".date("m")."-".date("y")."-".$off."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);  

		$sql = "INSERT INTO tb_po(id_po, tgl_po, total_po, status_po, cara_bayar_po, jenis_po, event_po, staff_po, supplier_po, tgl_approv_po, counter_po, kantor_po, keterangan_po, beli_po) 
		VALUES ('$kode', NOW(), '0', 'REQUEST', 'KONSI', 'SUPPLY', 'OFFICE', '$id', '0', NOW(), '0', '$off', '0', '0')";
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
