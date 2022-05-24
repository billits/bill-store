<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - nota gak ada
	// 2 - wes retur
	
	$notantj = $_POST['notantj'];
	$kantor = $_COOKIE['office_bill'];    
	$id=$_COOKIE["idstaff_bill"];
	$kantor2 = 0;    
	$evt2 = 0;
		
  if (empty($kantor)||empty($id)||empty($notantj)){
		$valid=1;
	}

	$sqlre2= "SELECT * FROM tb_jual WHERE id_jual='$notantj' AND kantor_jual='$kantor' AND status_jual='SUCCESS'";
	$resultre2 = mysqli_query($kon,$sqlre2);
	$rowre2 = mysqli_fetch_array($resultre2,MYSQLI_ASSOC);
	$countre2 = mysqli_num_rows($resultre2);

  if ($countre2 < 1){
		$valid=2;
	}else{
		$kantor2 = $rowre2['kantor_jual'];    
		$evt2 = $rowre2["acara_jual"];
	}

	$sqlre3= "SELECT * FROM tb_jual WHERE id_jual='$notantj' AND kantor_jual='$kantor' AND status_jual!='SUCCESS'";
	$resultre3 = mysqli_query($kon,$sqlre3);
	$countre3 = mysqli_num_rows($resultre3);

  if ($countre3 >= 1){
		$valid=2;
	}
	
	$sqlre= "SELECT * FROM tb_retur_transaksi WHERE notajual_retur='$notantj'";
	$resultre = mysqli_query($kon,$sqlre);
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);
		
	if($countre >= 1) {  
		$valid=3;			
	}
		
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlr= "SELECT max(id_retur) as maxKode FROM tb_retur_transaksi 
			WHERE kantor_retur = '$kantor2' AND jenis_retur='NTJ' AND event_retur='$evt2'
			AND MONTH(waktu_retur) = MONTH(CURRENT_DATE()) AND YEAR(waktu_retur) = YEAR(CURRENT_DATE()) ";
		$resultr = mysqli_query($kon,$sqlr);	  
		$rowr = mysqli_fetch_array($resultr,MYSQLI_ASSOC);
		$countr = mysqli_num_rows($resultr);
			
		if($evt2=="OFFICE"){
			$kodeRan = $rowr['maxKode'];
			$noUrut = (int) substr($kodeRan, 15, 21);
			$noUrut++;
			$kode_temp = "NTJR-".date("m")."-".date("y")."-".$kantor."-";
			$kode = $kode_temp . sprintf("%05s", $noUrut);
		}else{
			
			$sqlr1= "SELECT * FROM tb_detail_events WHERE id_det_event = '$evt2' ";
			$resultr1 = mysqli_query($kon,$sqlr1);	  
			$rowr1 = mysqli_fetch_array($resultr1,MYSQLI_ASSOC);		
			$evtnya = $rowr1['event_det_event'];

			$kodeRan = $rowr['maxKode'];
			$noUrut = (int) substr($kodeRan, 19, 25);
			$noUrut++;
			$kode_temp = "NTJR-".$evtnya."-".date("m")."-".date("y")."-".$kantor."-";
			$kode = $kode_temp . sprintf("%05s", $noUrut);
		}

		$sql = "INSERT INTO tb_retur_transaksi (id_retur, event_retur, staff_retur, waktu_retur, 
			kantor_retur, total_retur, keterangan_retur, status_retur, jenis_retur, notajual_retur) 
			VALUES ('$kode', '$evt2', '$id', NOW(), '$kantor2', '0', '0', 'PENDING', 'NTJ', '$notantj')";
		$result = mysqli_query($kon,$sql);

		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Retur Berhasil Ditambahkan";
			$status['nota_id']=$kode;
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah".$evt2;
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
    $status['error']="Nota Jual Tidak Tersedia";
	}elseif($valid==3){
		$status['nilai']=0; //bernilai salah
		$status['error']="Nota Jual Sudah Pernah Di Retur";
	}
	echo json_encode($status);
?>
