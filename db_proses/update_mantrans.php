<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - DATA KOSONG
	// 2 - STOK TIDAK CUKUP
	
	$id=$_COOKIE["idstaff_bill"];
	$off=$_COOKIE["office_bill"];
	$ntj = $_POST['ntj'];
	$event = "";

	$istok = 0;
	$kapasitas=0;

  if (empty($id)||empty($ntj)||empty($off)){
		$valid=1;
	}
	
	$sqlre= "SELECT * FROM tb_man_trans WHERE id_mt = '$ntj'";
	$resultre = mysqli_query($kon,$sqlre);	  
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$event = $rowre['acara_mt'];

	$t_order=$rowre['tgl_order_mt'];
	$t_acara=$rowre['acara_mt'];
	$t_total=$rowre['total_mt'];
	$t_cara=$rowre['cara_bayar_mt'];
	$t_status_j=$rowre['status_mt'];
	$t_approv=$rowre['tgl_approv_mt'];
	$t_counter=$rowre['counter_mt'];
	$t_gudang=$rowre['gudang_mt'];
	$t_ket=$rowre['keterangan_mt'];
	$t_jenis=$rowre['jenis_mt'];
	$t_cs=$rowre['cs_mt'];
	$t_tlp=$rowre['tlp_mt'];
	$t_cek=$rowre['checking_mt'];
	$t_kantor=$rowre['kantor_mt'];
	$t_vou=$rowre['voucher_mt'];
	$t_dibayar=$rowre['dibayar_mt'];
	$t_kembali=$rowre['kembalian_mt'];

	//PEMBUATAN KODE NTJ
	if ($event==""){
		$valid=1;
	}elseif ($event=="OFFICE"){
		$sqlre2= "SELECT max(id_jual) as maxKode FROM tb_jual WHERE acara_jual = 'OFFICE' AND kantor_jual = '$off' 
		AND MONTH(tgl_order_jual) = MONTH(CURRENT_DATE()) AND YEAR(tgl_order_jual) = YEAR(CURRENT_DATE()) ";
		$resultre2 = mysqli_query($kon,$sqlre2);	  
		$rowre2 = mysqli_fetch_array($resultre2,MYSQLI_ASSOC);
		$countre2 = mysqli_num_rows($resultre2);
		$kodeRan = $rowre2['maxKode'];
		$noUrut = (int) substr($kodeRan, 14, 20);
		$noUrut++;
		$kode_temp = "NTJ-".date("m")."-".date("y")."-".$off."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);
	}else{
		$sqlre1= "SELECT * FROM tb_detail_events WHERE id_det_event = '$event'";
		$resultre1 = mysqli_query($kon,$sqlre1);	  
		$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
		$jenis_evt=$rowre1['event_det_event'];

		$sqlre2= "SELECT max(tb_jual.id_jual) as maxKode FROM tb_jual 
		INNER JOIN tb_detail_events ON tb_detail_events.id_det_event=tb_jual.acara_jual
		INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event
		WHERE tb_jual.kantor_jual = '$off' AND tb_detail_events.event_det_event='$jenis_evt' AND tb_detail_events.status_det_event='ON'
		AND MONTH(tb_jual.tgl_order_jual) = MONTH(CURRENT_DATE()) AND YEAR(tb_jual.tgl_order_jual) = YEAR(CURRENT_DATE()) ";
		$resultre2 = mysqli_query($kon,$sqlre2);	  
		$rowre2 = mysqli_fetch_array($resultre2,MYSQLI_ASSOC);
		$countre2 = mysqli_num_rows($resultre2);
		$kodeRan = $rowre2['maxKode'];
		$noUrut = (int) substr($kodeRan, 18, 24);
		$noUrut++;
		$kode_temp = "NTJ-".$jenis_evt."-".date("m")."-".date("y")."-".$off."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);
	}

	//PENGECEKKAN KAPASITAS
	$sqlc1="SELECT * FROM tb_detail_mantrans 
		INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_mantrans.produk_detmt 
		INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk WHERE tb_detail_mantrans.nota_detmt='$ntj'";
	$ssc1=mysqli_query($kon,$sqlc1);
	while($rowc1=mysqli_fetch_array($ssc1)){
		$prod=$rowc1['produk_detmt'];
		$jum=$rowc1['qty_detmt'];
		
		
			$sqlc2= "SELECT * FROM tb_gudang WHERE kode_office_gudang='$off' AND kode_produk_gudang='$prod' AND event_gudang='$event'";
			$ssc2 = mysqli_query($kon,$sqlc2);
			$rowc2 = mysqli_fetch_array($ssc2,MYSQLI_ASSOC);
			$countc2 = mysqli_num_rows($ssc2);
			if($countc2 == 1) { 
				$temp = $rowc2['jml_produk_gudang'];				
				if($temp >= $jum){
					$kapasitas=$kapasitas+0;
				}else{
					$kapasitas=$kapasitas+1;
				}
			}else{   		
				$kapasitas=$kapasitas+1;
			}
		
		//OVER KAPASITAS
		if ($kapasitas != 0){
			$istok=$istok+1;
		}
	}

	//CEK OVER KAPASITAS
	if ($istok != 0){
		$valid=2;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		
		//PENGURANGAN STOK PRODUK GUDANG UTAMA
		$sqlc11="SELECT * FROM tb_detail_mantrans 
		INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_mantrans.produk_detmt 
		INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk WHERE tb_detail_mantrans.nota_detmt='$ntj'";
		$ssc11=mysqli_query($kon,$sqlc11);
		while($rowc11=mysqli_fetch_array($ssc11)){
			$prod1=$rowc11['produk_detmt'];
			$jum1=$rowc11['qty_detmt'];
			
				$qw1 = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang-'$jum1', supplier_gudang='$id', staff_gudang='$id', 
					tgl_update_gudang=NOW() WHERE kode_produk_gudang='$prod1' AND kode_office_gudang='$off' AND event_gudang='$event'";
				$res_qw1 = mysqli_query($kon,$qw1);
				if(!$res_qw1) {    
					$cek=$cek+1;
				}
			
		}

		//PEMBUATAN NOTA NTJ
		$qw2 = "INSERT INTO tb_jual(id_jual, tgl_order_jual, acara_jual, total_jual, cara_bayar_jual, status_jual, tgl_approv_jual, counter_jual, gudang_jual, keterangan_jual, jenis_jual, nama_customer, tlp_customer, checking_by, kantor_jual, voucher_jual, dibayar_jual, kembalian_jual) 
		VALUES ('$kode', '$t_order', '$t_acara', '$t_total', '$t_cara', 'SUCCESS', '$t_approv', '$t_counter', '$t_gudang', '$t_ket', '$t_jenis', '$t_cs', '$t_tlp', '$t_cek', '$t_kantor', '$t_vou', '$t_dibayar', '$t_kembali')";
		$res_qw2 = mysqli_query($kon,$qw2);
		if(!$res_qw2) {    
			$cek=$cek+1;
		}

		$sql2="SELECT * FROM tb_detail_mantrans WHERE nota_detmt='$ntj'";
		$ss2=mysqli_query($kon,$sql2);
		while($row2=mysqli_fetch_array($ss2)){
			$i_produk=$row2['produk_detmt'];
			$i_harga=$row2['harga_detmt'];
			$i_qty=$row2['qty_detmt'];
			$i_diskon=$row2['diskon_detmt'];
			$i_totjum=$row2['total_jumlah_detmt'];

			$qw3 = "INSERT INTO tb_detail_jual(nota_detjual, produk_detjual, harga_detjual, qty_detjual, diskon_detjual, total_jumlah_detjual) 
			VALUES ('$kode', '$i_produk', '$i_harga', '$i_qty', '$i_diskon', '$i_totjum')";
			$res_qw3 = mysqli_query($kon,$qw3);	
			if(!$res_qw3) {    
				$cek=$cek+1;
			}
		}

		$qw4 = "UPDATE tb_man_trans SET manual_mt='$kode', tgl_order_mt='$t_order', tgl_approv_mt='$t_approv' WHERE id_mt='$ntj'";
		$res_qw4 = mysqli_query($kon,$qw4);		
		if(!$res_qw4) {    
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Ditambahkan";		
			$status['nott']= $kode;
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
    $status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Stok Gudang Tidak Mencukupi";
	}

	
	// $status['nilai']=0; //bernilai salah
	// $status['error']="Stok Gudang Tidak Mencukupi".$event;

	echo json_encode($status);
?>
