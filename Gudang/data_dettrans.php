    
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


          <div class="card mb-3">
            <div class="card-header">
    <?php
      include "../db_proses/koneksi.php";
      
      $org = $_COOKIE['idstaff_bill'];
      $kantr = $_COOKIE['office_bill'];
      $nota = $_REQUEST['id'];      
      $tgl=0;
      
      $query="SELECT * FROM tb_jual INNER JOIN tb_staff ON tb_staff.kode_staff=tb_jual.counter_jual 
      INNER JOIN tb_office ON tb_office.id_office=tb_jual.kantor_jual 
      WHERE tb_jual.id_jual='$nota'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
        $tgl=date("Y-m-d H:i:s", strtotime($baris['tgl_order_jual']));
    ?>
              <table width=100%>
          <tr>
            <td>
              <table>
                <tr>
                  <th>kode </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['id_jual']; ?></td>
                </tr>
                <tr>
                  <th>Tanggal Order</th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo date("d-m-Y H:i:s", strtotime($baris['tgl_order_jual'])); ?></td>
                </tr>
                <tr>
                  <th>Counter </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['nama_staff']." - ".$baris['nama_office']; ?></td>
                </tr>
                <?php
                  if ($baris['status_jual']!="PENDING"){
                    if($baris['gudang_jual'] == '0'){
                ?>
                <?php
                    }else{
                ?>
                <tr>
                  <th>Tanggal Ambil</th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo date("d-m-Y H:i:s", strtotime($baris['tgl_approv_jual'])); ?></td>
                </tr>
                <tr>
                  <th>Gudang </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris1['nama_staff']." - ".$baris['nama_office']; ?></td>
                </tr>
                <?php
                    }
                  }
                ?>
              </table>  
            </td>
            <td>
              <table>              
                <tr>
                  <th>Transaksi </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['jenis_jual']; ?></td>
                </tr>         
                <tr>
                  <th>Pembayaran </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['cara_bayar_jual']; ?></td>
                </tr>
                <tr>
                  <th>Nama Customer </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['nama_customer']; ?></td>
                </tr>
                <tr>
                  <th>Telepon Customer </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['tlp_customer']; ?></td>
                </tr>
                <tr>
                  <th>Keterangan </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['keterangan_jual']; ?></td>
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
                      <th>kategori</th>
										  <th>Harga</th>
										  <th>Diskon</th>
                      <th>Qty</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      $bayar=0;
      $query2="SELECT * FROM tb_detail_jual INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual 
      INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_jual.produk_detjual 
      INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
      INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_jual.harga_detjual 
      WHERE tb_jual.id_jual='$nota'";
      $result2 = mysqli_query($kon, $query2);
      
      while($baris2 = mysqli_fetch_assoc($result2)){
        $bayar=$bayar+$baris2['total_jumlah_detjual'];
        $produk=$baris2['id_produk'];
        $vou=$baris2['voucher_jual'];
        $totju=$baris2['total_jual'];
        $dibayar=$baris2['dibayar_jual'];
        $kembali=$baris2['kembalian_jual']
        
    ?>
                    <tr>
                      <td><?php echo $baris2['id_produk']; ?></td>
                      <td><?php echo $baris2['nama_produk']; ?></td>
                      <td><?php echo $baris2['nama_kategori']; ?></td>
                      <td><?php echo rupiah($baris2['harga_harian']); ?></td>
                      <td><?php echo rupiah($baris2['diskon_detjual']); ?></td>
                      <td><?php echo $baris2['qty_detjual']; ?></td>
                      <td><?php echo rupiah($baris2['total_jumlah_detjual']); ?></td>
                    </tr>    
                    
    <?php
      }
    ?>             
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="6">SubTotal</th>
                      <th><?php echo rupiah($bayar); ?></th>
                    </tr>
                    <tr>
                      <th colspan="6">Voucher </th>
                      <th><?php echo rupiah($vou); ?></th>
                    </tr>                    
                    <tr>
                      <th colspan="6">Total </th>
                      <th><?php echo rupiah($totju); ?></th>
                    </tr>             
                    <tr>
                      <th colspan="6">Dibayar </th>
                      <th><?php echo rupiah($dibayar); ?></th>
                    </tr>             
                    <tr>
                      <th colspan="6">Kembali </th>
                      <th><?php echo rupiah($kembali); ?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-header">
              <form id="form-app" method="post">
                  <input type="hidden" name="nota" value="<?php echo $nota; ?>">
                  <input type="hidden" name="total" value="<?php echo $bayar; ?>">
                  <input type="hidden" name="staff" value="<?php echo $org; ?>">
                  <input type="hidden" name="off" value="<?php echo $kantr; ?>">
                  <input type="hidden" name="tgl" value="<?php echo $tgl; ?>">
                  <button type="submit" class="btn btn-success" name="aprov" id="aprov">Approve</button>        
                  <button type="submit" class="btn btn-danger" name="kembali" id="kembali" >Kembali</button>  
              </form> 
            </div>
          </div>

          
