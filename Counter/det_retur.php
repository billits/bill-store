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
            <li class="breadcrumb-item active"> Retur Transaksi</li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataTrans">
          </div>

          <!-- Modal Popup untuk Tambah Data Produk--> 
          <div id="ModalReAll" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Proses Retur Transaksi</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-reall">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="keterangan">Keterangan*</label>
                      <input class="form-control" type="text" name="ket" id="ket" required/>  
                      <input type="hidden" name="nota" id="nota" value="">
                      <input type="hidden" name="ntj" id="ntj" value="">
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
        var ntj = getUrlVars()["ntj"];
        var nota = getUrlVars()["nota"];
        
        var datatrans = "data_rt_trans.php?nota="+nota+"&ntj="+ntj;
        $('#DataTrans').load(datatrans); 

        $(document).on("click", ".open-ModalReAll", function () {   
          var id_nota = $(this).data('nota');
          var ntj = $(this).data('ntj');
           
          $(".modal-body #nota").val( id_nota );
          $(".modal-body #ntj").val( ntj );
        });

        $('#form-reall').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-reall").serialize();
          $.ajax({
            url:"../db_proses/add_retur_trans.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 

                //Program Nota Masuk Disini
                var nota_tmp = obj.nott;
                window.open(
                  '../Print Nota NTR Transaksi.php?nota='+nota_tmp,
                  '_blank' // <- This is what makes it open in a new window.
                );
                window.location= 'rt_trans.php';
              }else{
                alert(obj.error); 
              }
            }
          })
        })

        

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
                  $.post('../db_proses/delete_returtrans.php', { 'kode_nota':pnot })
                  .done(function(html){             
                    window.location= 'rt_trans.php';
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

