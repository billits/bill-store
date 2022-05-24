
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

      $reg = $_COOKIE['region_bill'];
      $kantor = $_COOKIE['office_bill'];   
      $nota = $_REQUEST['nota'];
      $bayar=0;

    ?>

          <div class="card mb-3">
            <div class="card-header">
              Data Retur Pusat
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
                      <th>Total</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php
    $query = "SELECT * FROM tb_gudang 
    INNER JOIN tb_produk ON tb_produk.id_produk=tb_gudang.kode_produk_gudang 
    INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
    INNER JOIN tb_harga_produk ON tb_harga_produk.produk_harga=tb_produk.id_produk 
    WHERE tb_gudang.kode_office_gudang='$kantor' AND tb_gudang.event_gudang='OFFICE' AND tb_harga_produk.region_harga='$reg' AND tb_harga_produk.status_harga='ON'";
    // $query="SELECT * FROM gudang 
    // INNER JOIN produk ON produk.id_produk=gudang.kode_produk_gudang
    // INNER JOIN harga_produk ON harga_produk.id_harga=gudang.kode_produk_gudang
    // INNER JOIN office ON office.region_office=harga_produk.region_harga 
    // WHERE gudang.kode_office_gudang='$kantor' AND gudang.event_gudang='OFFICE' AND harga_produk.status_harga='ON'";
    $result = mysqli_query($kon, $query);
    while($baris = mysqli_fetch_assoc($result)){
      $det_pdk=$baris['id_produk'];
      $harganya=$baris['harga_harian'];
      // $jml_pdk=0;
      $jml_pdk=$baris['jml_produk_gudang'];
      $jml_laku=0;
      $jml_ret=0;
      $jml_det_ret=0;
      $subtotal=0;
      
      // $query1="SELECT * FROM tb_gudang 
      //   WHERE kode_produk_gudang='$det_pdk' AND kode_office_gudang='$kantor' AND event_gudang='OFFICE'";
      // $result1 = mysqli_query($kon, $query1);
      // while($baris1 = mysqli_fetch_assoc($result1)){
      //   $jml_pdk=$baris1['jml_produk_gudang'];
      // }

      // $query2="SELECT * FROM produk 
      //   INNER JOIN detail_jual ON detail_jual.produk_detjual=produk.id_produk 
      //   INNER JOIN jual ON jual.id_jual=detail_jual.nota_detjual
      //   WHERE detail_jual.produk_detjual='$det_pdk' AND jual.acara_jual='$evt'";
      // $result2 = mysqli_query($kon, $query2);
      // while($baris2 = mysqli_fetch_assoc($result2)){
      //   $jml_laku=$jml_laku+$baris2['qty_detjual'];
      // }

      // $query3="SELECT * FROM produk 
      //   INNER JOIN detail_retur_event ON detail_retur_event.produk_detretevt=produk.id_produk 
      //   INNER JOIN retur_event ON retur_event.id_returevt=detail_retur_event.id_detretevt
      //   WHERE detail_retur_event.produk_detretevt='$det_pdk' AND retur_event.event_returevt='OFFICE'";
      // $result3 = mysqli_query($kon, $query3);
      // while($baris3 = mysqli_fetch_assoc($result3)){
      //   $jml_ret=$jml_ret+$baris3['jumret_detretevt'];
      // }

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
    ?>
                    <tr>
                      <td><?php echo $baris['id_produk']; ?></td>
                      <td><?php echo $baris['nama_produk']."-".$baris['nama_kategori']; ?></td>
                      <td><?php echo $jml_pdk; ?></td>
                      <td><?php echo $jml_det_ret; ?></td>
                      <td><?php echo rupiah($subtotal); ?></td>
                      <td>
                        <a href="#" class="btn btn-primary" id="retur" 
                        data-pc="<?php echo $baris['id_harga']; ?>" 
                        data-pdk="<?php echo $baris['id_produk']; ?>" 
                        data-nota="<?php echo $nota; ?>" 
                        data-ret="<?php echo $jml_det_ret; ?>" 
                        data-qty="<?php echo $jml_pdk; ?>"> 
                        
                        Retur</a>
                        <a href="#" class="btn btn-danger" id="resetq" data-nota="<?php echo $nota; ?>" data-pdk="<?php echo $baris['id_produk']; ?>"> Reset</a>
                      </td>
                    </tr>  
                    
    <?php
      }
    ?>             
                  </tbody>                  
                  <tfoot>
                    <tr>
                      <th colspan="4">Total Bayar</th>
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
                <!-- <a href="#ModalReAll" class="open-ModalReAll btn btn-primary btn-small-block" id="reall" data-evnt="<?php echo $evt; ?>" data-nota="<?php echo $nota; ?>" data-toggle="modal">Retur All</a>   -->
                <a href="#ModalSave" class="open-ModalSave btn btn-success btn-small-block" id="save" 
                data-nota="<?php echo $nota; ?>" 
                data-bayar="<?php echo $bayar; ?>" 
                data-toggle="modal">Save</a>  
                <a href="#" class="btn btn-danger btn-small-block" id="back" data-nota="<?php echo $nota; ?>">Cancel</a>  
            </div>
          </div>

          