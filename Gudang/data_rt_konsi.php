
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

      $konsi = $_REQUEST['konsi'];
      $nota = $_REQUEST['nota'];
      $bayar=0;
      $cont=0;
      
    ?>

          <div class="card mb-3">
            <div class="card-header">
              Data Retur Konsi Leader
            </div>  
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>Produk</th>
										  <th>Jml Konsi</th>
                      <th>Sudah Retur</th>
                      <th>Terjual</th>
                      <th>Jml Retur</th>
                      <th>Total</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <!-- INNER JOIN temp_jual ON temp_jual.jml_pdk_temp=produk.id_produk  -->
    <?php
    $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk, tb_harga_produk.harga_harian, tb_detail_jual_konsi.harga_detjk FROM tb_produk   
    INNER JOIN tb_detail_jual_konsi ON tb_detail_jual_konsi.produk_detjk=tb_produk.id_produk 
    INNER JOIN tb_jual_konsi ON tb_jual_konsi.id_jk=tb_detail_jual_konsi.nota_detjk 
    INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_jual_konsi.harga_detjk
    WHERE tb_jual_konsi.id_jk='$konsi'";
    $result = mysqli_query($kon, $query);
    while($baris = mysqli_fetch_assoc($result)){
      $det_pdk=$baris['id_produk'];
      $harganya=$baris['harga_harian'];
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

      $query2="SELECT * FROM tb_produk 
      INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
      INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
      WHERE tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='OFFICE' AND tb_jual.keterangan_jual='$konsi'";
      $result2 = mysqli_query($kon, $query2);
      while($baris2 = mysqli_fetch_assoc($result2)){
        $jml_laku=$jml_laku+$baris2['qty_detjual'];
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

      //cari jumlah diretur
      $query4="SELECT * FROM tb_produk 
        INNER JOIN tb_detail_retur_transaksi ON tb_detail_retur_transaksi.produk_detrettrans=tb_produk.id_produk 
        INNER JOIN tb_retur_transaksi ON tb_retur_transaksi.id_retur=tb_detail_retur_transaksi.id_detrettrans
        WHERE tb_detail_retur_transaksi.produk_detrettrans='$det_pdk' AND  tb_detail_retur_transaksi.id_detrettrans='$nota'";
      $result4 = mysqli_query($kon, $query4);
      while($baris4 = mysqli_fetch_assoc($result4)){
        $jml_det_ret=$baris4['jumret_detrettrans'];
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
                      <td><?php echo $jml_det_ret; ?></td>
                      <td><?php echo rupiah($subtotal); ?></td>
                      <td>
                        <a href="#" class="btn btn-primary" id="retur" data-pc="<?php echo $baris['harga_detjk']; ?>" data-pdk="<?php echo $baris['id_produk']; ?>" data-nota="<?php echo $nota; ?>" data-evt="<?php echo $evt; ?>" data-ret="<?php echo $jml_ret; ?>" data-laku="<?php echo $jml_laku; ?>" data-qty="<?php echo $jml_pdk; ?>"> Retur</a>
                        <a href="#" class="btn btn-danger" id="resetq" data-nota="<?php echo $nota; ?>" data-pdk="<?php echo $baris['id_produk']; ?>"> Reset</a>
                      </td>
                    </tr>  
                    
    <?php
      }
    ?>             
                  </tbody>                  
                  <tfoot>
                    <tr>
                      <th colspan="6">Total Bayar<?php echo $nota; ?></th>
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
                <a href="#ModalReAll" class="open-ModalReAll btn btn-primary btn-small-block" id="reall" data-konsi="<?php echo $konsi; ?>" data-nota="<?php echo $nota; ?>" data-toggle="modal">Retur All</a>  
                <a href="#ModalSave" class="open-ModalSave btn btn-success btn-small-block" id="save" data-nota="<?php echo $nota; ?>" data-bayar="<?php echo $bayar; ?>" 
                data-konsi="<?php echo $konsi; ?>" data-cont="<?php echo $cont; ?>" data-toggle="modal">Save</a>  
                <a href="#" class="btn btn-danger btn-small-block" id="back" data-nota="<?php echo $nota; ?>">Cancel</a>  
            </div>
          </div>

          