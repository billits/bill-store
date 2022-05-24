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
	$konsi = $_POST['konsi'];
	$jum=0;
  $bayar=0;
  $maks_ret=0;

  if (empty($nota)||empty($konsi)||empty($staff)||empty($ketsup)){
		$valid=1;
	}

	$sqlre1= "SELECT * FROM tb_jual_konsi WHERE id_jk = '$konsi'";
	$resultre1 = mysqli_query($kon,$sqlre1);	  
	$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
	$t_approv=$rowre1['tgl_approv_jk'];
	$t_order=$rowre1['tgl_order_jk'];


	if ($valid==0){
		mysqli_autocommit($kon, false);

	// $sql = "DELETE FROM detail_retur_transaksi WHERE id_detrettrans='$nota'";
	// $reslt = mysqli_query($kon,$sql);
	  
    $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk, tb_harga_produk.harga_harian, tb_detail_jual_konsi.harga_detjk FROM tb_produk   
    INNER JOIN tb_detail_jual_konsi ON tb_detail_jual_konsi.produk_detjk=tb_produk.id_produk 
    INNER JOIN tb_jual_konsi ON tb_jual_konsi.id_jk=tb_detail_jual_konsi.nota_detjk 
    INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_jual_konsi.harga_detjk
    WHERE tb_jual_konsi.id_jk='$konsi'";
    $result = mysqli_query($kon, $query);
    while($baris = mysqli_fetch_assoc($result)){
      $det_pdk=$baris['id_produk'];
      $harganya=$baris['harga_harian'];
      $pc=$baris['harga_detjk'];
      $jml_pdk=0;
      $jml_laku=0;
      $jml_ret=0;
      $jml_det_ret=0;
      $subtotal=0;
    
      //cari jumlah stok awal
      $query1="SELECT * FROM tb_produk 
        INNER JOIN tb_detail_jual_konsi ON tb_detail_jual_konsi.produk_detjk=tb_produk.id_produk 
        WHERE tb_detail_jual_konsi.produk_detjk='$det_pdk' AND tb_detail_jual_konsi.nota_detjk='$konsi'";
      $result1 = mysqli_query($kon, $query1);
      while($baris1 = mysqli_fetch_assoc($result1)){
        $jml_pdk=$jml_pdk+$baris1['qty_detjk'];
      }

      //cari jumlah total yang sudah diretur
      $query3="SELECT * FROM tb_produk 
        INNER JOIN tb_detail_retur_transaksi ON tb_detail_retur_transaksi.produk_detrettrans=tb_produk.id_produk 
        INNER JOIN tb_retur_transaksi ON tb_retur_transaksi.id_retur=tb_detail_retur_transaksi.id_detrettrans
        WHERE tb_detail_retur_transaksi.produk_detrettrans='$det_pdk' AND tb_retur_transaksi.notajual_retur='$konsi'";
      $result3 = mysqli_query($kon, $query3);
      while($baris3 = mysqli_fetch_assoc($result3)){
        $jml_ret=$jml_ret+$baris3['jumret_detrettrans'];
      }

      //cari jumlah laku
      $query4="SELECT * FROM tb_produk 
        INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
        INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
        WHERE tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='OFFICE' AND tb_jual.keterangan_jual='$konsi'";
        $result4 = mysqli_query($kon, $query4);
        while($baris4 = mysqli_fetch_assoc($result4)){
          $jml_laku=$jml_laku+$baris4['qty_detjual'];
        }

      $maks_ret=$jml_pdk-($jml_ret+$jml_laku);
      $subtotal = $maks_ret*$harganya;
      $bayar=$bayar+$subtotal;

      $query5 = "INSERT INTO tb_detail_retur_transaksi(id_detrettrans, produk_detrettrans, jumret_detrettrans, harga_detrettrans, totjum_detrettrans) 
        VALUES ('$nota', '$det_pdk', '$maks_ret', '$pc', '$subtotal')";
      $result5 = mysqli_query($kon,$query5);
      if(!$result5) {    
        $cek=$cek+1;
      }
  
      $sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$maks_ret', supplier_gudang='$staff', staff_gudang='$staff', 
      tgl_update_gudang=NOW() WHERE kode_produk_gudang='$det_pdk' AND kode_office_gudang='$kantor' AND event_gudang='OFFICE'";
      $resltt = mysqli_query($kon,$sli);
      if(!$resltt) {    
        $cek=$cek+1;
      }
	  }

    $sl = "UPDATE tb_retur_transaksi SET waktu_retur=NOW(), total_retur='$bayar', keterangan_retur='$ketsup', status_retur='SUCCESS' WHERE id_retur='$nota'";
    $reslts = mysqli_query($kon,$sl);
    if(!$reslts) {    
      $cek=$cek+1;
    }

    $sl2 = "UPDATE tb_jual_konsi SET retur_jk='$nota', tgl_approv_jk='$t_approv', tgl_order_jk='$t_order' WHERE id_jk='$konsi'";
    $reslt2 = mysqli_query($kon,$sl2);
    if(!$reslt2) {    
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
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}

	echo json_encode($status);
?>
