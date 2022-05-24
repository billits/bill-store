<?php
  include ('akses.php');
  include ('../_partials/partial_none.php');
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php echo $csjs1; ?>
    <script>
      function myFunction() {        
        var qty=parseInt($('#qty').val());
        var price=parseInt($('#price').val());
        var diskon=parseInt($('#diskon').val());
        // var hrg_diskon=(diskon/100)*price;
        var hrg_diskon=diskon;
        var hrg_pdk=price-hrg_diskon;
        var tot_fix = qty*hrg_pdk;  

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
            Manual Transaksi Event <?php echo $_COOKIE['office_bill']; ?>
          </ol>

          <!-- DataTables Example -->
          <div id="ListPro">          
          </div>

          <!-- Modal Popup untuk Detail Data Produk-->
          <div id="ModalDetail" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-det">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Detail Data Produk</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="data-detail">
                    </div>             
                  </div>
                  <div class="modal-footer">                  
                    <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Kembali</button>
                  </div>
                </form>    
              </div>
            </div>
          </div>

          <!-- Modal Popup untuk input Jumlah Produk-->
          <div id="ModalJum" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-jum">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Jumlah Order Produk</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="data-jum">
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
      function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
          vars[key] = value;
        });
        return vars;
      }

      $(document).ready(function(){
        var office = '<?php echo $_COOKIE["office_bill"];?>';
        var idnota = getUrlVars()["nota"];
        var ListPro = "list_pro_evt_man.php?nota="+idnota;
        $('#ListPro').load(ListPro); 

        $(document).on('click','#kembali',function(e){
          e.preventDefault();
          window.location= 'add_man_trans_evt.php?nota='+idnota;
        });

        $(document).on('click','#jum',function(e){
          e.preventDefault();
          $("#ModalJum").modal('show');
          $.post('set_jml_evt_man.php',
            {id:$(this).attr('data-id'),
              nota:idnota,
              off:office},
            function(html){
              $("#data-jum").html(html);
            }  
          );
        });
        
        $("#form-jum").submit(function(e) {
          e.preventDefault();
          var dataform = $("#form-jum").serialize();
          $.ajax({
            url: "../db_proses/add_man_trans_pro_evt.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error);                 
                // window.location= 'add_trans_evt.php?nota='+idnota;
                $("#ModalJum").modal('hide');
                $('#ListPro').load(ListPro);
              }else{
                alert(obj.error); 
              }
            }
          });
        });
        
      })
    </script>

  </body>
  
</html>

