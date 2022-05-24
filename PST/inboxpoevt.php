<?php
  include ('akses.php');
  include ('../_partials/partial_pusat.php');
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php echo $csjs1; ?>
    <script>
      function myFunction() {        
        var qty=parseInt($('#qty').val());
        var price=parseInt($('#price').val());
        var tot_fix = qty*price;  

        var reverse = tot_fix.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = 'Rp. '+ribuan.join('.').split('').reverse().join('');
        document.getElementById("total").value = ribuan;   
      }
    </script>
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
            <li class="breadcrumb-item active"> Inbox PO Event  </li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataPO">
          </div>

          <!-- Modal Popup untuk Edit Data Produk-->
          <div id="ModalEdit" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-edit">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Edit Order Produk</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="data-edit">
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
      $(document).ready(function(){
        var datapo = "data_po_evt.php";
        $('#DataPO').load(datapo); 

        $(document).on('click','#detail',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          var datalap = "data_detpo_evt.php?id="+datatmp;
          $('#DataPO').load(datalap); 
        });
        
        $(document).on('click','#kembali',function(e){
          e.preventDefault();
          $('#DataPO').load(datapo); 
        });
        
        $(document).on('click','#edit',function(e){
          e.preventDefault();
          $("#ModalEdit").modal('show');
          $.post('edit_po_evt.php',
            {id:$(this).attr('data-id'),
            pdk:$(this).attr('data-pdk')},
            function(html){
              $("#data-edit").html(html);
            }  
          );
        });

        $(document).on('click','#aprov',function(e){
          e.preventDefault();
          var dataform = $("#form-app").serialize();
          $.ajax({
            url: "../db_proses/update_po_evt.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                var nota_tmp = obj.kode_nota;
                window.open(
                  '../Print Nota NTJK.php?nota='+nota_tmp,
                  '_blank' // <- This is what makes it open in a new window.
                );
                window.location= 'inboxpoevt.php'; 
              }else{
                alert(obj.error); 
              }
            }
          });
        });
        
        
        $("#form-edit").submit(function(e) {
          e.preventDefault();
          var dataform = $("#form-edit").serialize();
          $.ajax({
            url: "../db_proses/update_pstproduk_evt.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $('#ModalEdit').modal('hide');
                var datalap = "data_detpo_evt.php?id="+obj.link;
                $('#DataPO').load(datalap); 
              }else{
                alert(obj.error); 
              }
            }
          });
        });
        
        $(document).on('click','#hapus',function(e){
          e.preventDefault();
          var pnot = $(this).attr('data-id');
          var pjum = $(this).attr('data-jum');
          var ppdk = $(this).attr('data-pdk');
          bootbox.dialog({
            message: "Hapus Produk ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/delete_addproduk_evt.php', { 'kode_nota':pnot, 'kode_produk':ppdk, 'kode_jum':pjum })
                  .done(function(html){             
                    var datalap = "data_detpo_evt.php?id="+pnot;
                    $('#DataPO').load(datalap); 
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

        // $(document).on('click','#hapus_nota',function(e){
        //   e.preventDefault();
        //   var pnot = $(this).attr('data-id');
        //   bootbox.dialog({
        //     message: "Hapus PO Cabang ?",
        //     title: "",
        //     buttons: {
        //       danger: {
        //         label: "Ya",
        //         className: "btn-success",
        //         callback: function() {
        //           $.post('../db_proses/delete_btb_cabang.php', { 'kode_nota':pnot })
        //           .done(function(html){           
        //             location.reload();
        //           })
        //           .fail(function(){
        //             bootbox.alert('Something Went Wrog ....');
        //           })
        //         }
        //       }, 
        //       success: {
        //         label: "Tidak",
        //         className: "btn-danger",
        //         callback: function() {
        //           $('.bootbox').modal('hide');
        //         }
        //       }
        //     }
        //   });
        // });

        $(document).on('click','#cetak',function(e){
          e.preventDefault();
          var nota_tmp = $(this).attr('data-id');
          window.open(
            '../Print Nota NTJK.php?nota='+nota_tmp,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

      })
    </script>

  </body>
  
</html>

