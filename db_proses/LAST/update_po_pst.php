<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - lebih stok
	
	$total = $_POST['total'];
	$nota = $_POST['nota'];
	$cont = $_POST['cont'];
	$staff = $_POST['staff'];
	$kantor = $_POST['kantor'];

  if (empty($staff)||empty($nota)||empty($kantor)||empty($total)){
		$valid=1;
	}

  if ($cont!=0){
		$valid=2;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);
		$sql="SELECT * FROM tb_detail_beli WHERE nota_detbeli='$nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){
			$pro=$data['produk_detbeli'];
			$jum=$data['qty_detbeli'];			
			$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang-'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
			tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='PST' AND event_gudang='OFFICE'";
			$resltt = mysqli_query($kon,$sli);
			if(!$resltt) {    
				$cek=$cek+1;
			}
		}	

		$sqlr1= "SELECT *  FROM tb_beli WHERE id_beli='$nota'";
		$resultr1 = mysqli_query($kon,$sqlr1);	  
		$rowr1 = mysqli_fetch_array($resultr1,MYSQLI_ASSOC);
		$date_beli = $rowr1['tgl_beli'];
		$ket = $nota;

		$sqlr= "SELECT max(id_beli) as maxKode FROM tb_beli WHERE jenis_beli = 'SUPPLY' AND status_beli != 'REQUEST' AND kantor_beli = '$kantor' AND MONTH(tgl_beli) = MONTH(CURRENT_DATE()) AND YEAR(tgl_beli) = YEAR(CURRENT_DATE())";
		$resultr = mysqli_query($kon,$sqlr);	  
		$rowr = mysqli_fetch_array($resultr,MYSQLI_ASSOC);
		$countr = mysqli_num_rows($resultr);
		
		$kodeRan = $rowr['maxKode'];
		$noUrut = (int) substr($kodeRan, 14, 20);
		$noUrut++;
		$kode_temp = "BTB-".date("m")."-".date("y")."-".$kantor."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);

		$sqlrr = "UPDATE tb_beli SET id_beli='$kode', tgl_beli='$date_beli', tgl_approv_beli=NOW(), keterangan_beli='$ket', status_beli='SUCCESS', total_beli='$total', supplier_beli='$staff'
		WHERE id_beli='$nota'";
		$resltrr = mysqli_query($kon,$sqlrr);

		$sqlrr1 = "UPDATE tb_detail_beli SET nota_detbeli='$kode' WHERE nota_detbeli='$nota'";
		$resltrr1 = mysqli_query($kon,$sqlrr1);

		if(!$resltrr) {    
			$cek=$cek+1;
			$cok="b";
		}
		if(!$resltrr1) {    
			$cek=$cek+1;
			$cok="c";
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data PO Berhasil Di Approve";
			$status['kode_nota']=$kode;
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Di Approve".$kodeRan;
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
    $status['error']="Jumlah Order Produk Melebihi Stok Gudang";
	}
	
	echo json_encode($status);
?>
