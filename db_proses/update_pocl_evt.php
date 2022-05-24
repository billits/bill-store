<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong

	$nota = $_POST['nota'];
	$event = $_POST['evn'];
	$kantor = $_POST['off'];
	$staff = $_POST['staff'];

  if (empty($nota)||empty($staff)||empty($kantor)||empty($event)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre1= "SELECT * FROM tb_beli_event WHERE id_beli_event='$nota'";
		$resultre1 = mysqli_query($kon,$sqlre1);
		$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
		$tgl=$rowre1['tgl_beli_event'];

		$sl = "UPDATE tb_beli_event SET tgl_beli_event='$tgl', stat_beli_event='APPROVE' WHERE id_beli_event='$nota'";
		$reslt = mysqli_query($kon,$sl);
		if(!$reslt) {    
			$cek=$cek+1;
		}

		$sql="SELECT * FROM tb_detail_beli_event WHERE nota_detbelev='$nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){

			$pro=$data['produk_detbelev'];
			$jum=$data['qty_detbelev'];
			$sqlre= "SELECT * FROM tb_gudang WHERE kode_office_gudang='$kantor' AND kode_produk_gudang='$pro' AND event_gudang='$event'";
      $resultre = mysqli_query($kon,$sqlre);
      $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
    	$countre = mysqli_num_rows($resultre);
            
      if($countre == 1) {  
				$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
				tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='$kantor' AND event_gudang='$event'";
				$resltt = mysqli_query($kon,$sli);
				if(!$resltt) {    
					$cek=$cek+1;
				}
      }else{
        $squl = "INSERT INTO tb_gudang (kode_produk_gudang, kode_office_gudang, jml_produk_gudang, supplier_gudang, staff_gudang, tgl_update_gudang, event_gudang) 
			  VALUES ('$pro','$kantor','$jum', '$staff', '$staff', NOW(), '$event')";
        $resuult = mysqli_query($kon,$squl);
				if(!$resuult) {    
					$cek=$cek+1;
				}
      }
		}		
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Invoice Diterima";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Diproses";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}
	
	echo json_encode($status);
?>
