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
	$staff = $_COOKIE['idstaff_bill'];
	$kantor = $_POST['kantor'];

  if (empty($staff)||empty($nota)||empty($kantor)||empty($total)){
		$valid=1;
	}

  if ($cont!=0){
		$valid=2;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sql="SELECT * FROM tb_detail_po WHERE nota_detpo='$nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){
			$pro=$data['produk_detpo'];
			$jum=$data['qty_detpo'];			

			$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang-'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
			tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='PST' AND event_gudang='OFFICE'";
			$resltt = mysqli_query($kon,$sli);
			if(!$resltt) {    
				$cek=$cek+1;
			}
		}	

		$sqlr1= "SELECT *  FROM tb_po WHERE id_po='$nota'";
		$resultr1 = mysqli_query($kon,$sqlr1);	  
		$rowr1 = mysqli_fetch_array($resultr1,MYSQLI_ASSOC);
		$date_beli = $rowr1['tgl_po'];

		$sqlrr = "UPDATE tb_po SET tgl_po='$date_beli', tgl_approv_po=NOW(), status_po='SUCCESS', total_po='$total', supplier_po='$staff' WHERE id_po='$nota'";
		$resltrr = mysqli_query($kon,$sqlrr);

		if(!$resltrr) {    
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data PO Berhasil Di Approve";
			$status['kode_nota']=$nota;
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
