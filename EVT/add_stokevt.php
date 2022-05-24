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
  <?php      
	  include "../db_proses/koneksi.php";
    $evt=$_GET['evn'];
    $sql2= "SELECT * FROM detail_events WHERE id_det_event = '$evt' ";
    $result2 = mysqli_query($kon,$sql2);	  
    $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $event = $row2['nama_det_event'];
  ?>
  Tambah Stok Produk Gudang <?php echo "Event ".$event." ".$_COOKIE['nama_office']; ?>
          </ol>

          <!-- DataTables Example -->
          <div id="TambahStok">          
          </div>

          <!-- Modal Popup untuk Tambah Data Produk--> 
          <div id="ModalApp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Kirim PO Ke Pusat</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-approv">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="keterangan">Keterangan Event*</label>
                      <input class="form-control" type="text" name="ket" id="ket" required/>  
                      <input type="hidden" name="bayar" id="bayar" value="">
                      <input type="hidden" name="nota" id="nota" value="">
                      <input type="hidden" name="office" id="office" value="">
                      <input type="hidden" name="pegawai" id="pegawai" value="">
                      <input type="hidden" name="event" id="event" value="<?php echo $_GET['evn'];?>">
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
        var idevt = getUrlVars()["evn"];
        
        var datastok = "data_addstokevt.php?nota="+idnota+"&evt="+idevt;
        $('#TambahStok').load(datastok); 

        $(document).on('click','#addpro',function(e){
          e.preventDefault();
          window.location= 'add_stokproevt.php?nota='+idnota+'&evt='+idevt;
        });

        $(document).on("click", ".open-ModalApp", function () {          
          var office = '<?php echo $_COOKIE["id_office"];?>';        
          var pegawai = '<?php echo $_COOKIE["id_pegawai"];?>';
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
            url:"../db_proses/add_orderprodukevt1.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                //Program Nota Masuk Disini
                //alert(obj.error); 
                var nota_tmp = obj.kode_nota;
                window.open(
                  '../Print Nota NTJK.php?nota='+nota_tmp,
                  '_blank' // <- This is what makes it open in a new window.
                );
                window.location= 'poevt1.php';
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
                  $.post('../db_proses/delete_addprodukevt.php', { 'kode_nota':pnot, 'kode_produk':ppdk })
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
            message: "Batalkan Orderan ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/delete_stokevt.php', { 'kode_nota':pnot })
                  .done(function(html){             
                    window.location= 'poevt1.php';
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

