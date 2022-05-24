<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - data po tidak tersedia
	
	$nota = $_POST['nota'];
	$staff = $_COOKIE['idstaff_bill'];
	$kantor = $_POST['kantor'];
	$tgl = $_POST['tgl'];

  if (empty($nota)||empty($staff)||empty($kantor)||empty($tgl)){
		$valid=1;
	}

	$sqlre1= "SELECT * FROM tb_po WHERE id_po='$nota'";
	$resultre1 = mysqli_query($kon,$sqlre1);
	$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
	$countre1 = mysqli_num_rows($resultre1);
					
	if($countre1 >= 1) { 
		$total_po=$rowre1['total_po'];
		$event_po=$rowre1['event_po'];
		$staff_po=$rowre1['staff_po'];
		$supp_po=$rowre1['supplier_po'];
		$kantor_po=$rowre1['kantor_po'];
		$ket = $rowre1['keterangan_po'];
	}else{
		$valid=2;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlr= "SELECT max(id_beli) as maxKode FROM tb_beli WHERE jenis_beli = 'SUPPLY' AND status_beli= 'APPROVE' AND kantor_beli = '$kantor' AND MONTH(tgl_beli) = MONTH(CURRENT_DATE()) AND YEAR(tgl_beli) = YEAR(CURRENT_DATE())";
		$resultr = mysqli_query($kon,$sqlr);	  
		$rowr = mysqli_fetch_array($resultr,MYSQLI_ASSOC);
		$countr = mysqli_num_rows($resultr);
		
		$kodeRan = $rowr['maxKode'];
		$noUrut = (int) substr($kodeRan, 14, 20);
		$noUrut++;
		$kode_temp = "BTB-".date("m")."-".date("y")."-".$kantor."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);
		
		$sql="SELECT * FROM tb_detail_po WHERE nota_detpo='$nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){
			$pro=$data['produk_detpo'];
			$jum=$data['qty_detpo'];
			$harga_po=$data['harga_detpo'];
			$diskon_po=$data['diskon_detpo'];
			$totjum_po=$data['total_jumlah_detpo'];

			$sqlre= "SELECT * FROM tb_gudang WHERE kode_office_gudang='$kantor' AND kode_produk_gudang='$pro' AND event_gudang='OFFICE'";
			$resultre = mysqli_query($kon,$sqlre);
			$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
			$countre = mysqli_num_rows($resultre);
							
			if($countre == 1) {  
				$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
					tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='$kantor' AND event_gudang='OFFICE'";
				$resltt = mysqli_query($kon,$sli);
				if(!$resltt) {    
					$cek=$cek+1;
				}
			}else{
				$squl = "INSERT INTO tb_gudang (kode_produk_gudang, kode_office_gudang, jml_produk_gudang, supplier_gudang, staff_gudang, tgl_update_gudang, event_gudang) VALUES ('$pro','$kantor','$jum', '$staff', '$staff', NOW(), 'OFFICE')";
				$resuult = mysqli_query($kon,$squl);
				if(!$resuult) {    
					$cek=$cek+1;
				}
			}

			//insert detail beli
			$sql1 = "INSERT INTO tb_detail_beli (nota_detbeli, produk_detbeli, harga_detbeli, qty_detbeli, diskon_detbeli, total_jumlah_detbeli) VALUES 
			('$kode','$pro', '$harga_po', '$jum', '$diskon_po', '$totjum_po')";
			$result1 = mysqli_query($kon,$sql1);
			if(!$result1) {    
				$cek=$cek+1;
			}
		}		

		//insert beli
		$sql2 = "INSERT INTO tb_beli (id_beli, tgl_beli, total_beli, status_beli, cara_bayar_beli, jenis_beli, event_beli, 
		staff_beli, supplier_beli, tgl_approv_beli, counter_beli, kantor_beli, keterangan_beli) VALUES 
		('$kode','$tgl', '$total_po', 'APPROVE', 'KONSI', 'SUPPLY', '$event_po', '$staff_po', '$supp_po', NOW(), '$staff', '$kantor_po', '$ket')";
		$result2 = mysqli_query($kon,$sql2);
		if(!$result2) {    
			$cek=$cek+1;
		}
		
		//update tb_po
		$sql3 = "UPDATE tb_po SET beli_po='$kode', tgl_po='$tgl', status_po='APPROVE', tgl_approv_po=NOW(), keterangan_po='$ket', counter_po='$staff' WHERE id_po='$nota'";
		$result3 = mysqli_query($kon,$sql3);
		if(!$result3) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Stok Gudang Berhasil Di Update";
			$status['kode_nota']=$kode;
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Di Update";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Kode PO Tidak Tersedia";
	}
	
	echo json_encode($status);
?>
