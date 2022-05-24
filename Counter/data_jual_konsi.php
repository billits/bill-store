
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

      $ntjk = $_REQUEST['ntjk'];
      $nota = $_REQUEST['nota'];

    ?>

          <div class="card mb-3">
            <div class="card-header">
    
    <?php
      $query="SELECT * FROM tb_jual_konsi INNER JOIN tb_staff ON tb_staff.kode_staff=tb_jual_konsi.counter_jk 
      INNER JOIN tb_office ON tb_office.id_office=tb_jual_konsi.kantor_jk 
      WHERE tb_jual_konsi.id_jk='$ntjk'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
        $gudang_id = $baris['gudang_jk'];
    
        $query1 = "SELECT * FROM tb_staff INNER JOIN tb_office ON tb_office.id_office=tb_staff.office_staff WHERE tb_staff.kode_staff='$gudang_id'";
	      $result1 = mysqli_query($kon, $query1);
        $baris1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
        
    ?>
        <table width=100%>
          <tr>
            <td>
              <table>
                <tr>
                  <th>Kode </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['id_jk']; ?></td>
                </tr>
                <tr>
                  <th>Tanggal Order</th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo date("d-m-Y H:i:s", strtotime($baris['tgl_order_jk'])); ?></td>
                </tr>
                <tr>
                  <th>Counter </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['nama_staff']." - ".$baris['nama_office']; ?></td>
                </tr>
                <?php
                  if ($baris['status_jk']!="PENDING"){
                ?>
                <tr>
                  <th>Tanggal Ambil</th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo date("d-m-Y H:i:s", strtotime($baris['tgl_approv_jk'])); ?></td>
                </tr>
                <tr>
                  <th>Gudang </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris1['nama_staff']." - ".$baris['nama_office']; ?></td>
                </tr>
                <?php
                  }
                ?>
              </table>  
            </td>
            <td>
              <table>              
                <tr>
                  <th>Transaksi </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['jenis_jk']; ?></td>
                </tr>         
                <tr>
                  <th>Pembayaran </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['cara_bayar_jk']; ?></td>
                </tr>
                <tr>
                  <th>Nama Customer </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['cs_jk']; ?></td>
                </tr>
                <tr>
                  <th>Keterangan </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['keterangan_jk']; ?></td>
                </tr>
              </table>  
            </td>
          </tr>
        </table>                 
    <?php
      }
    ?> 
            </div>    
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>Produk</th>
										  <th>Harga</th>
										  <th>Sisa Konsi</th>
                      <th>Jml Beli</th>
                      <th>Diskon</th>
                      <th>Total</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php
    $bayar=0;
    $query2="SELECT * FROM tb_detail_jual_konsi INNER JOIN tb_jual_konsi ON tb_jual_konsi.id_jk=tb_detail_jual_konsi.nota_detjk 
    INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_jual_konsi.produk_detjk 
    INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_jual_konsi.harga_detjk 
    WHERE tb_jual_konsi.id_jk='$ntjk'";
    $result2 = mysqli_query($kon, $query2);
    
    while($baris2 = mysqli_fetch_assoc($result2)){
      $produk=$baris2['id_produk'];
      $totju=$baris2['total_jk'];
      $totpro=$baris2['qty_detjk'];
      $jml_ret=0;
      $jml_laku=0;      
      $jml_beli=0;   
      $dis_beli=0;
      $tojum_beli=0;

      $query3="SELECT * FROM tb_produk 
      INNER JOIN tb_detail_retur_transaksi ON tb_detail_retur_transaksi.produk_detrettrans=tb_produk.id_produk 
      INNER JOIN tb_retur_transaksi ON tb_retur_transaksi.id_retur=tb_detail_retur_transaksi.id_detrettrans
      WHERE tb_detail_retur_transaksi.produk_detrettrans='$produk' AND tb_retur_transaksi.notajual_retur='$ntjk'";
      $result3 = mysqli_query($kon, $query3);
      while($baris3 = mysqli_fetch_assoc($result3)){
        $jml_ret=$jml_ret+$baris3['jumret_detrettrans'];
      }

      $query4="SELECT * FROM tb_produk 
      INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
      INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
      WHERE tb_detail_jual.produk_detjual='$produk' AND tb_jual.acara_jual='OFFICE' AND tb_jual.keterangan_jual='$ntjk'";
      $result4 = mysqli_query($kon, $query4);
      while($baris4 = mysqli_fetch_assoc($result4)){
        $jml_laku=$jml_laku+$baris4['qty_detjual'];
      }

      $query5="SELECT * FROM tb_produk 
      INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
      INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
      WHERE tb_detail_jual.produk_detjual='$produk' AND tb_jual.id_jual='$nota'";
      $result5 = mysqli_query($kon, $query5);
      while($baris5 = mysqli_fetch_assoc($result5)){
        $jml_beli=$baris5['qty_detjual'];
        $dis_beli=$baris5['diskon_detjual'];
        $tojum_beli=$baris5['total_jumlah_detjual'];
      }

      $totpro=$totpro-($jml_ret+$jml_laku);
      $bayar=$bayar+$tojum_beli;
      
    ?>
                    <tr>
                      <td><?php echo $baris2['id_produk']; ?></td>
                      <td><?php echo $baris2['nama_produk']; ?></td>
                      <td><?php echo rupiah($baris2['harga_harian']); ?></td>
                      <td><?php echo $totpro; ?></td>
                      <td><?php echo $jml_beli; ?></td>
                      <td><?php echo rupiah($dis_beli); ?></td>
                      <td><?php echo rupiah($tojum_beli); ?></td>
                      <td>                        
                        <a href="#" class="btn btn-primary" id="setjml" 
                        data-pc="<?php echo $baris2['harga_detjk']; ?>" 
                        data-pdk="<?php echo $baris2['id_produk']; ?>" 
                        data-nota="<?php echo $nota; ?>" 
                        data-qty="<?php echo $totpro; ?>"> Set Jumlah</a>
                        <a href="#" class="btn btn-danger" id="resetq" 
                        data-nota="<?php echo $nota; ?>" 
                        data-pdk="<?php echo $baris2['id_produk']; ?>"> Reset</a>
                      </td>
                    </tr>    
                    
    <?php
      }
    ?>             
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="6">Total</th>
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
              <form id="form-app" method="post">                  
                <a href="#ModalApp" class="open-ModalApp btn btn-success btn-small-block" name="jual" id="jual" 
                  data-id="<?php echo $nota; ?>" data-bayar="<?php echo $bayar; ?>" data-toggle="modal">Proses</a>   
                <button type="submit" class="btn btn-danger" name="batal" id="batal" data-nota="<?php echo $nota; ?>">Batal</button>  
              </form> 
            </div>
          </div>
          