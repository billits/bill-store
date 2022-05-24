
    <!-- Core plugin JavaScript-->
    <script src='../vendor/jquery-easing/jquery.easing.min.js'></script>

    <!-- Page level plugin JavaScript-->
    <script src='../vendor/chart.js/Chart.min.js'></script>
    <script src='../vendor/datatables/jquery.dataTables.js'></script>
    <script src='../vendor/datatables/dataTables.bootstrap4.js'></script>

    <!-- Custom scripts for all pages-->
    <script src='../js/sb-admin.min.js'></script>

    <!-- Demo scripts for this page-->
    <script src='../js/demo/datatables-demo.js'></script>
    <script src='../js/demo/chart-area-demo.js'></script>

    <?php
      include "../db_proses/koneksi.php";
       
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }

      $evt = $_REQUEST['evt'];
      $nota = $_REQUEST['nota'];
      $bayar=0;
      $cont=0;

      $sqlre2= "SELECT * FROM tb_detail_events WHERE id_det_event = '$evt'";
      $resultre2 = mysqli_query($kon,$sqlre2);	  
      $rowre2 = mysqli_fetch_array($resultre2,MYSQLI_ASSOC);	
      $nama_event = $rowre2['nama_det_event'];
    ?>

          <div class="card mb-3">
            <div class="card-header">
              Data Retur Event <?php echo $nama_event; ?>
            </div>  
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>Produk</th>
										  <th>Jumlah</th>
                      <th>Retur</th>
                      <th>Terjual</th>
                      <th>Total</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php
    $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk, tb_harga_produk.harga_harian, tb_detail_beli_event.harga_detbelev FROM tb_produk 
    INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
    INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
    INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli_event.harga_detbelev
    WHERE tb_beli_event.event_beli_event='$evt'";
    $result = mysqli_query($kon, $query);
    while($baris = mysqli_fetch_assoc($result)){
      $det_pdk=$baris['id_produk'];
      $harganya=$baris['harga_harian'];
      $jml_pdk=0;
      $jml_laku=0;
      $jml_ret=0;
      $jml_det_ret=0;
      $subtotal=0;
      
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
        WHERE tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$evt'";
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

      $query4="SELECT * FROM tb_produk 
        INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
        INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
        WHERE tb_detail_retur_event.produk_detretevt='$det_pdk' AND tb_retur_event.id_returevt='$nota'";
      $result4 = mysqli_query($kon, $query4);
      while($baris4 = mysqli_fetch_assoc($result4)){
        $jml_det_ret=$baris4['jumret_detretevt'];
      }

      $subtotal = $jml_det_ret*$harganya;
      $bayar=$bayar+$subtotal;
      $jum_tot=$jml_ret+$jml_laku;

      if ($jml_pdk!=$jum_tot){
        $cont=$cont+1;
      }

    ?>
                    <tr>
                      <td><?php echo $baris['id_produk']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td><?php echo $jml_pdk; ?></td>
                      <td><?php echo $jml_ret; ?></td>
                      <td><?php echo $jml_laku; ?></td>
                      <td><?php echo rupiah($subtotal); ?></td>
                      <td>
                        <a href="#" class="btn btn-primary" id="retur" data-pc="<?php echo $baris['harga_detbelev']; ?>" data-pdk="<?php echo $baris['id_produk']; ?>" data-nota="<?php echo $nota; ?>" data-evt="<?php echo $evt; ?>" data-ret="<?php echo $jml_ret; ?>" data-laku="<?php echo $jml_laku; ?>" data-qty="<?php echo $jml_pdk; ?>"> Retur</a>
                        <a href="#" class="btn btn-danger" id="resetq" data-nota="<?php echo $nota; ?>" data-pdk="<?php echo $baris['id_produk']; ?>"> Reset</a>
                      </td>
                    </tr>  
                    
    <?php
      }
    ?>             
                  </tbody>                  
                  <tfoot>
                    <tr>
                      <th colspan="5">Total Bayar</th>
                      <th><?php echo rupiah($bayar); ?></th>
										  <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

          
          <div class="card mb-3">
            <div class="card-header">
                <a href="#ModalReAll" class="open-ModalReAll btn btn-primary btn-small-block" id="reall" data-evnt="<?php echo $evt; ?>" data-nota="<?php echo $nota; ?>" data-toggle="modal">Retur All</a>  
                <a href="#ModalSave" class="open-ModalSave btn btn-success btn-small-block" id="save" data-nota="<?php echo $nota; ?>" data-bayar="<?php echo $bayar; ?>" 
                data-evnt="<?php echo $evt; ?>" data-cont="<?php echo $cont; ?>" data-toggle="modal">Save</a>  
                <a href="#" class="btn btn-danger btn-small-block" id="back" data-nota="<?php echo $nota; ?>">Cancel</a>  
            </div>
          </div>

          