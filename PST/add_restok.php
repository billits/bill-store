<?php
  include ('akses.php');
  include ('../_partials/partial_none.php');
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php echo $csjs1; ?>
  </head>


  <body id="page-top">
    <?php echo $topnav; ?>

    <div id="wrapper">
      <?php echo $topside; ?>

      <div id="content-wrapper">
        <div class="container-fluid">
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            ReStok Produk Gudang Office 
          </ol>

          <!-- DataTables Example -->
          <div id="TambahStok"> 
          </div>

          <!-- Modal Popup untuk Tambah Data Produk--> 
          <div id="ModalApp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Approve Data ReStok Produk</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-approv">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="offc">Kantor*</label>
                      <select class="form-control" name="offc" id="offc">
    <?php
      include "../db_proses/koneksi.php";
      $query1 = "SELECT * FROM tb_office";
      $result1 = mysqli_query($kon, $query1);
      
      while($baris1 = mysqli_fetch_assoc($result1)){
    ?>
                      <option value="<?php echo $baris1['id_office']; ?>"><?php echo $baris1['nama_office']; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="keterangan">Keterangan*</label>
                      <input class="form-control" type="text" name="ket" id="ket" required/>  
                      <input type="hidden" name="bayar" id="bayar" value="">
                      <input type="hidden" name="nota" id="nota" value="">
                      <input type="hidden" name="pegawai" id="pegawai" value="">
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-success" id="btn-save" type="submit">Approve</button>
                      <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Batal</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <?php
          echo $footer;
        ?>
        
      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
		<?php
      echo $logout;
    ?>

    <?php
      echo $csjs2;
    ?>

    <script type="text/javascript">
      function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
          vars[key] = value;
        });
        return vars;
      }
      $(document).ready(function(){
        var idnota = getUrlVars()["nota"];
        
        var datastok = "data_addrestok.php?nota="+idnota;
        $('#TambahStok').load(datastok); 

        $(document).on('click','#addpro',function(e){
          e.preventDefault();
          window.location= 'add_restokpro.php?nota='+idnota;
        });

        $(document).on("click", ".open-ModalApp", function () {        
          var pegawai = '<?php echo $_COOKIE["idstaff_bill"];?>';
          var id_nota = $(this).data('idnota');
          var total_bayar = $(this).data('tot');
          $(".modal-body #nota").val( id_nota );
          $(".modal-body #bayar").val( total_bayar );
          $(".modal-body #pegawai").val( pegawai );
        });

        $('#form-approv').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-approv").serialize();
          $.ajax({
            url:"../db_proses/add_orderproduk_restok.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                // alert(obj.error); 
                var nota_temp = obj.nota_id;
                window.open(
                  '../Print Nota ReStok.php?nota='+nota_temp,
                  '_blank' // <- This is what makes it open in a new window.
                );
                window.location= 'restok.php';
              }else{
                alert(obj.error); 
              }
            }
          })
        })

        $(document).on('click','#hapus',function(e){
          e.preventDefault();
          var pnot = $(this).attr('data-nota');
          var ppdk = $(this).attr('data-pdk');
          var ppdknama = $(this).attr('data-pdknama');
          bootbox.dialog({
            message: "Hapus Produk "+ppdknama+" ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/delete_restok_produk.php', { 'kode_nota':pnot, 'kode_produk':ppdk })
                  .done(function(html){             
                    bootbox.alert('Produk '+ppdknama+' Berhasil dihapus');
                    $('#TambahStok').load(datastok);   
                  })
                  .fail(function(){
                    bootbox.alert('Something Went Wrog ....');
                  })
                }
              }, 
              success: {
                label: "Tidak",
                className: "btn-danger",
                callback: function() {
                  $('.bootbox').modal('hide');
                }
              }
            }
          });
        });

        $(document).on('click','#batal',function(e){
          e.preventDefault();
          var pnot = $(this).attr('data-nota');
          bootbox.dialog({
            message: "Batalkan Orderan ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/delete_restok.php', { 'kode_nota':pnot })
                  .done(function(html){             
                    window.location= 'restok.php';
                  })
                  .fail(function(){
                    bootbox.alert('Something Went Wrog ....');
                  })
                }
              }, 
              success: {
                label: "Tidak",
                className: "btn-danger",
                callback: function() {
                  $('.bootbox').modal('hide');
                }
              }
            }
          });
        });
        
      })
    </script>

  </body>
  
</html>

