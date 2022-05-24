<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$staff = $_COOKIE['idstaff_bill'];
	$kantor = $_COOKIE['office_bill'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$evt = $_POST['evnt'];
	$jum=0;
	$bayar=0;

  if (empty($nota)||empty($evt)||empty($staff)||empty($ketsup)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
    

    // $sql = "DELETE FROM detail_retur_event WHERE id_detretevt='$nota'";
    // $reslt = mysqli_query($kon,$sql);

    $sql = "SELECT * FROM tb_retur_event WHERE id_returevt = '$nota'";
    $reslt = mysqli_query($kon,$sql);
    $rowre2 = mysqli_fetch_array($reslt,MYSQLI_ASSOC);  
    $evt2 = $rowre2['event_returevt'];
    $office2 = $rowre2['kantor_returevt'];
	  
    $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk, tb_harga_produk.harga_harian, tb_detail_beli_event.harga_detbelev FROM tb_produk 
      INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
      INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
      INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli_event.harga_detbelev
      WHERE tb_beli_event.event_beli_event='$evt'";
    $result = mysqli_query($kon, $query);
    while($baris = mysqli_fetch_assoc($result)){
      $det_pdk=$baris['id_produk'];
      $harganya=$baris['harga_harian'];
      $pc=$baris['harga_detbelev'];
      $jml_pdk=0;
      $jml_laku=0;
      $jml_ret=0;
      $jml_det_ret=0;
      $subtotal=0;
      $maks_ret=0;
      
      $query1="SELECT * FROM tb_produk 
        INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
        INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
        WHERE tb_detail_beli_event.produk_detbelev='$det_pdk' AND tb_beli_event.event_beli_event='$evt'";
      $result1 = mysqli_query($kon, $query1);
      while($baris1 = mysqli_fetch_assoc($result1)){
        $jml_pdk=$jml_pdk+$baris1['qty_detbelev'];
      }

      $query2="SELECT * FROM tb_produk 
        INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
        INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
        WHERE tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.status_jual='SUCCESS' AND tb_jual.acara_jual='$evt'";
      $result2 = mysqli_query($kon, $query2);
      while($baris2 = mysqli_fetch_assoc($result2)){
        $jml_laku=$jml_laku+$baris2['qty_detjual'];
      }

      $query3="SELECT * FROM tb_produk 
        INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
        INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
        WHERE tb_detail_retur_event.produk_detretevt='$det_pdk' AND tb_retur_event.event_returevt='$evt'";
      $result3 = mysqli_query($kon, $query3);
      while($baris3 = mysqli_fetch_assoc($result3)){
        $jml_ret=$jml_ret+$baris3['jumret_detretevt'];
      }
	  
      $maks_ret=$jml_pdk-($jml_laku+$jml_ret);
      $subtotal = $maks_ret*$harganya;
      $bayar=$bayar+$subtotal;
		
      $query4 = "INSERT INTO tb_detail_retur_event(id_detretevt, produk_detretevt, jumret_detretevt, harga_detretevt, totjum_detretevt) 
        VALUES ('$nota', '$det_pdk', '$maks_ret', '$pc', '$subtotal')";
      $result4 = mysqli_query($kon,$query4);
      if(!$result4) {    
        $cek=$cek+1;
      }

      $sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$maks_ret', supplier_gudang='$staff', staff_gudang='$staff', 
      tgl_update_gudang=NOW() WHERE kode_produk_gudang='$det_pdk' AND kode_office_gudang='$office2' AND event_gudang='OFFICE'";
      $resltt = mysqli_query($kon,$sli);
      if(!$resltt) {    
        $cek=$cek+1;
      }

      $sli1 = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang-'$maks_ret', supplier_gudang='$staff', staff_gudang='$staff', 
      tgl_update_gudang=NOW() WHERE kode_produk_gudang='$det_pdk' AND kode_office_gudang='$office2' AND event_gudang='$evt2'";
      $resltt1 = mysqli_query($kon,$sli1);
      if(!$resltt1) {    
        $cek=$cek+1;
      }

    }

    $sl = "UPDATE tb_retur_event SET waktu_returevt=NOW(), status_returevt='SUCCESS', total_returevt='$bayar', keterangan_returevt='$ketsup' WHERE id_returevt='$nota'";
    $reslt = mysqli_query($kon,$sl);
    if(!$reslt) {    
      $cek=$cek+1;
    }

    $sqlll = "INSERT INTO tb_notif_retur(event_retur, status_retur, waktu_retur, staff_retur) VALUES ('$evt2', '1', NOW(), '$staff')";
    $result = mysqli_query($kon,$sqlll);	
    if(!$result) {    
      $cek=$cek+1;
    }
      
    if ($cek==0){
      mysqli_commit($kon);
      $status['nilai']=1; //bernilai benar
      $status['nott']=$nota; 
      $status['error']="Data Retur Berhasil Diproses";
    }else{          
      mysqli_rollback($kon);
      $status['nilai']=0; //bernilai salah
      $status['error']="Data Gagal Diproses";
    }
    
    // $status['nilai']=0; //bernilai salah
    // $status['error']="Inputan Tidak Boleh Kosong";
    mysqli_close($kon);
  }elseif($valid==1){
    $status['nilai']=0; //bernilai salah
    $status['error']="Inputan Tidak Boleh Kosong";
  }

	echo json_encode($status);
?>
