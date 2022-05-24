<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$id=$_COOKIE["idstaff_bill"];
	$evt = $_POST['event'];
	$off=$_COOKIE["office_bill"];

  if (empty($id)||empty($evt)||empty($off)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre1= "SELECT * FROM tb_detail_events WHERE id_det_event = '$evt'";
		$resultre1 = mysqli_query($kon,$sqlre1);	  
		$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
		$event = $rowre1['event_det_event'];

		$sqlre= "SELECT max(id_beli_event) as maxKode FROM tb_beli_event 
		INNER JOIN tb_detail_events ON tb_detail_events.id_det_event=tb_beli_event.event_beli_event
		INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event
		WHERE tb_detail_events.event_det_event = '$event' AND tb_beli_event.jenis_beli_event = 'SUPPLY' AND tb_beli_event.kantor_beli_event = '$off' 
		AND MONTH(tb_beli_event.tgl_beli_event) = MONTH(CURRENT_DATE()) AND YEAR(tb_beli_event.tgl_beli_event) = YEAR(CURRENT_DATE()) ";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);

		$kodeRan = $rowre['maxKode'];
		$noUrut = (int) substr($kodeRan, 19, 25);
		$noUrut++;
		$kode_temp = "NTJK-".$event."-".date("m")."-".date("y")."-".$off."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);  

	
		$sql = "INSERT INTO tb_beli_event 
		(id_beli_event, tgl_beli_event, total_beli_event, cara_bayar_beli_event, jenis_beli_event, event_beli_event, staff_beli_event, kantor_beli_event, keterangan_beli_event, stat_beli_event, supplier_beli_event) 
		VALUES ('$kode', NOW(), '0', 'KONSI', 'SUPPLY', '$evt', '$id', '$off', '0', 'REQUEST', '$id')";
		$result = mysqli_query($kon,$sql);	  

		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Ditambahkan";		
			$status['nota']= $kode;
			$status['acara']= $evt;
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
