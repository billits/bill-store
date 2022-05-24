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
            <li class="breadcrumb-item">
              <a href="home.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active"> Retur Produk Pusat</li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataTrans">
          </div>

          <!-- Modal Popup untuk Edit Data Produk-->
          <div id="ModalRetur" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-retur">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Retur Produk</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="data-retur">
                    </div>             
                  </div>
                  <div class="modal-footer">                  
                    <button class="btn btn-success" id="btn-save" type="submit">Simpan</button>
                    <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Batal</button>
                  </div>
                </form>    
              </div>
            </div>
          </div>

          <!-- Modal Popup untuk Tambah Data Produk--> 
          <div id="ModalSave" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Proses Retur Produk</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-save">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="keterangan">Keterangan*</label>
                      <input class="form-control" type="text" name="ket" id="ket" required/>  
                      <input type="hidden" name="nota" id="nota" value="">
                      <input type="hidden" name="bayar" id="bayar" value="">
                    </div>     
                    <div class="modal-footer">
                      <button class="btn btn-success" id="btn-save" type="submit">Proses</button>
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
        var nota = getUrlVars()["nota"];
        
        var datatrans = "data_rt_pst.php?nota="+nota;
        $('#DataTrans').load(datatrans); 

        $(document).on("click", ".open-ModalSave", function () {   
          var id_nota = $(this).data('nota');
          var total_bayar = $(this).data('bayar');
           
          $(".modal-body #nota").val( id_nota );
          $(".modal-body #bayar").val( total_bayar );
        });

        $('#form-save').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-save").serialize();
          $.ajax({
            url:"../db_proses/add_save_returoff.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 

                //Program Nota Masuk Disini
                var nota_tmp = obj.nott;
                window.open(
                  '../Print Nota NTR Pusat.php?nota='+nota_tmp,
                  '_blank' // <- This is what makes it open in a new window.
                );
                window.location= 'ru_pusat.php';
              }else{
                alert(obj.error); 
              }
            }
          })
        })

        $(document).on('click','#resetq',function(e){
          e.preventDefault();
          var pnot = $(this).attr('data-nota');
          var ppdk = $(this).attr('data-pdk');
          bootbox.dialog({
            message: "Batalkan Reset ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/reset_returevent.php', { 'kode_nota':pnot, 'kode_pro':ppdk })
                  .done(function(html){             
                    // window.location= 'ru_evt.php';
                    bootbox.alert('Data Berhasil di Reset');
                    // $('#DataTrans').load(datatrans); 
                    location.reload(true);
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
        
        $(document).on('click','#retur',function(e){
          e.preventDefault();
          $("#ModalRetur").modal('show');
          $.post('retur_pdk_pst.php',
            {pdk:$(this).attr('data-pdk'),
              nota1:$(this).attr('data-nota'),
              ret:$(this).attr('data-ret'),
              pc:$(this).attr('data-pc'),
              qty:$(this).attr('data-qty')},
            function(html){
              $("#data-retur").html(html);
            }  
          );
        });

        $("#form-retur").submit(function(e) {
          e.preventDefault();
          var dataform = $("#form-retur").serialize();
          $.ajax({
            url: "../db_proses/update_retoff_produk.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $('#ModalRetur').modal('hide');
                // $('#DataTrans').load(datatrans); 
                location.reload(true);
              }else{
                alert(obj.error); 
              }
            }
          });
        });

        $(document).on('click','#back',function(e){
          e.preventDefault();
          var pnot = $(this).attr('data-nota');
          bootbox.dialog({
            message: "Batalkan Retur ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/delete_returevent.php', { 'kode_nota':pnot })
                  .done(function(html){             
                    window.location= 'ru_pusat.php';
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

