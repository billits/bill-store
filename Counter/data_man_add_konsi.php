
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
              <a href="#" class="btn btn-primary" id="addpro">              
                <i class="fas fa-plus"></i> Tambah Produk    
              </a>
            </div>  

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama Produk</th>
										  <th>Harga</th>
                      <th>Qty</th>
                      <th>Diskon</th>
                      <th>Total</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      $nota = $_GET['nota'];
      $bayar=0;

      $query="SELECT * FROM tb_detail_mankonsi INNER JOIN tb_man_konsi ON tb_man_konsi.id_mk=tb_detail_mankonsi.nota_detmk
      INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_mankonsi.produk_detmk 
      INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
      INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_mankonsi.harga_detmk 
      WHERE tb_man_konsi.id_mk='$nota'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
        $bayar=$bayar+$baris['totjum_detmk'];
    ?>
                    <tr>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td><?php echo rupiah($baris['harga_harian']); ?></td>
                      <td><?php echo $baris['qty_detmk']; ?></td>       
                      <td><?php echo rupiah($baris['diskon_detmk']); ?></td>  
                      <td><?php echo rupiah($baris['totjum_detmk']); ?></td>                   
                      <td>
                        <a href="#" id="hapus" class="btn btn-small text-danger" data-jum="<?php echo $baris['qty_detmk']; ?>" data-nota="<?php echo $nota; ?>" data-pdk="<?php echo $baris['id_produk']; ?>"><i class="fas fa-trash"></i> Hapus</a>
                      </td>
                    </tr>              
    <?php
      }
    ?>             
                  </tbody><tfoot>
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
              <a href="#ModalApp" class="open-ModalApp btn btn-success btn-small-block" data-idnota="<?php echo $nota; ?>" data-tot="<?php echo $bayar; ?>" data-toggle="modal">Proses</a>
              <a href="#" class="btn btn-danger btn-small-block" data-nota="<?php echo $nota; ?>" id="batal">Cancel</a>
            </div>
          </div>