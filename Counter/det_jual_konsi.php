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
        var hrg_diskon=diskon;
        var hrg_pdk=price-hrg_diskon;
        var tot_fix = qty*hrg_pdk;  

        var reverse = tot_fix.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = 'Rp. '+ribuan.join('.').split('').reverse().join('');
        document.getElementById("total").value = ribuan;   
      }
      function myFunction2() { 
        var Dibayar=parseInt($('#Dibayar').val());
        var Subtotal=parseInt($('#bayar').val());
        var Voucher=parseInt($('#Voucher').val());

        var hrg_final=Subtotal-Voucher;
        var kembalian=Dibayar-hrg_final; 

        var reverse = hrg_final.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = 'Rp. '+ribuan.join('.').split('').reverse().join('');
        document.getElementById("total1").value = ribuan;   

        var reverse1 = kembalian.toString().split('').reverse().join(''),
        ewuan = reverse1.match(/\d{1,3}/g);
        if (hrg_final > Dibayar){
          ewuan = '- Rp. '+ewuan.join('.').split('').reverse().join('');
        }else{
          ewuan = 'Rp. '+ewuan.join('.').split('').reverse().join('');
        }
        document.getElementById("Kembali").value = ewuan;   

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
            <li class="breadcrumb-item active"> Transaksi Konsi Leader</li>
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
                    <h5 class='modal-title' id='exampleModalLabel'>Set Jumlah Produk</h5>
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
          <div id="ModalApp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Transaksi Konsi</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-approv">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="jenis">Transaksi*</label>
                      <select class="form-control" name="jenis" id="jenis">
                        <option value="">Pilih Jenis Transaksi</option>
                        <option value="UMUM">Umum</option>
                        <option value="DEPO">Depo</option>
                        <option value="STOKIS">Stokis</option>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="buy">Pembayaran*</label>
                      <select class="form-control" name="buy" id="buy">
                        <option value="">Pilih Cara Bayar</option>
                        <option value="DEBIT">Debit</option>
                        <option value="TUNAI">Tunai</option>
                        <option value="TRANSFER">Transfer</option>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Pelanggan*</label>
                      <input class="form-control" type="text" name="nama" id="nama" required/>  
                      <input type="hidden" name="nota" id="nota" value="">
                      <input type="hidden" name="ntjk" id="ntjk" value="">
                      <input type="hidden" name="office" id="office" value="">
                      <input type="hidden" name="bayar" id="bayar" value="">
                      <input type="hidden" name="pegawai" id="pegawai" value="">
                    </div>     
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="rp_bayar">Subtotal*</label>
                      <input class="form-control" type="text" name="rp_bayar" id="rp_bayar" readonly required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Voucher">Voucher*</label>
                      <input class="form-control" type="text" name="Voucher" id="Voucher" value="0" onkeyup="myFunction2()" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="total">Total*</label>
                      <input class="form-control" type="text" name="total1" id="total1" readonly required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Dibayar">Dibayar*</label>
                      <input class="form-control" type="text" name="Dibayar" id="Dibayar" onkeyup="myFunction2()" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Kembali">Kembali*</label>
                      <input class="form-control" type="text" name="Kembali" id="Kembali" readonly required/>  
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
        var ntjk = getUrlVars()["ntjk"];
        var nota = getUrlVars()["nota"];
        
        var datatrans = "data_jual_konsi.php?nota="+nota+"&ntjk="+ntjk;
        $('#DataTrans').load(datatrans); 

        $(document).on("click", ".open-ModalApp", function () {          
          var office = '<?php echo $_COOKIE["office_bill"];?>';        
          var pegawai = '<?php echo $_COOKIE["idstaff_bill"];?>';
          var total_bayar = $(this).data('bayar');
          var rp_tot = total_bayar;

          var reverse9 = rp_tot.toString().split('').reverse().join(''),
          ribuan = reverse9.match(/\d{1,3}/g);
          ribuan = 'Rp. '+ribuan.join('.').split('').reverse().join('');
           
          $(".modal-body #nota").val( nota );
          $(".modal-body #ntjk").val( ntjk );
          $(".modal-body #bayar").val( total_bayar );
          $(".modal-body #office").val( office );
          $(".modal-body #total").val( ribuan );
          $(".modal-body #pegawai").val( pegawai );
          $(".modal-body #rp_bayar").val( ribuan );
        });

        $('#form-approv').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-approv").serialize();
          $.ajax({
            url:"../db_proses/add_trans_konsi.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 

                //Program Nota Masuk Disini
                var nota_tmp = obj.nott;
                window.open(
                  '../Print Nota NTJ1.php?nota='+nota_tmp,
                  '_blank' // <- This is what makes it open in a new window.
                );
                window.location= 'list_konsi.php';
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
            message: "Anda Yakin Reset ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/reset_pro_konsi.php', { 'kode_nota':pnot, 'kode_pro':ppdk })
                  .done(function(html){             
                    // window.location= 'ru_evt.php';
                    bootbox.alert('Data Berhasil di Reset');
                    $('#DataTrans').load(datatrans); 
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

        
        $(document).on('click','#setjml',function(e){
          e.preventDefault();
          $("#ModalRetur").modal('show');
          $.post('set_jml_konsi.php',
            {pdk:$(this).attr('data-pdk'),
              nota1:$(this).attr('data-nota'),
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
            url: "../db_proses/add_trans_konsi_pro.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $('#ModalRetur').modal('hide');
                $('#DataTrans').load(datatrans); 
              }else{
                alert(obj.error); 
              }
            }
          });
        });

        $(document).on('click','#batal',function(e){
          e.preventDefault();
          var pnot = $(this).attr('data-nota');
          bootbox.dialog({
            message: "Batalkan Transaksi ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/delete_ntj_konsi.php', { 'kode_nota':pnot })
                  .done(function(html){             
                    window.location= 'list_konsi.php';
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

