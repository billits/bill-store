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
            Tambah Konsi Cabang
          </ol>

          <!-- DataTables Example -->
          <div id="TambahStok">          
          </div>

          <!-- Modal Popup untuk Tambah Data Produk--> 
          <div id="ModalApp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Konsi Gudang Cabang</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  Kirim Konsi Ke Cabang?
                  <form method="post" id="form-approv">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <input type="hidden" name="bayar" id="bayar" value="">
                      <input type="hidden" name="nota" id="nota" value="">
                      <input type="hidden" name="office" id="office" value="">
                      <input type="hidden" name="pegawai" id="pegawai" value="">
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-success" id="btn-save" type="submit">Send</button>
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
        
        var datastok = "data_addstok.php?nota="+idnota;
        $('#TambahStok').load(datastok); 

        $(document).on('click','#addpro',function(e){
          e.preventDefault();
          window.location= 'add_stokkonsi.php?nota='+idnota;
        });

        $(document).on("click", ".open-ModalApp", function () {          
          var office = '<?php echo $_COOKIE["office_bill"];?>';        
          var pegawai = '<?php echo $_COOKIE["idstaff_bill"];?>';
          var id_nota = $(this).data('idnota');
          var total_bayar = $(this).data('tot');
          $(".modal-body #nota").val( id_nota );
          $(".modal-body #bayar").val( total_bayar );
          $(".modal-body #office").val( office );
          $(".modal-body #pegawai").val( pegawai );
        });

        $('#form-approv').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-approv").serialize();
          $.ajax({
            url:"../db_proses/add_orderkonsi.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                // alert(obj.error); 
                var nota_tmp = obj.kode_nota;
                window.open(
                  '../Print Nota NPO Cabang.php?nota='+nota_tmp,
                  '_blank' // <- This is what makes it open in a new window.
                );
                window.location= 'konsi_cabang.php';
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
          bootbox.dialog({
            message: "Hapus Produk ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/delete_addproduk_konsi.php', { 'kode_nota':pnot, 'kode_produk':ppdk })
                  .done(function(html){             
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
            message: "Batalkan Konsi ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/delete_stok_konsi.php', { 'kode_nota':pnot })
                  .done(function(html){             
                    window.location= 'konsi_cabang.php';
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

