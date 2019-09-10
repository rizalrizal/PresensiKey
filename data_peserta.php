<?php 
error_reporting(E_ERROR | E_PARSE);
session_start();
ob_start();

//Mengecek status login
if(!isset($_SESSION['username']) or !isset($_SESSION['password'])){
  session_start();
  session_destroy();
   echo "<script>
      window.location = 'index.php';
      </script>";
}
include 'koneksi.php'; 
include 'helper.php'; 
?>
<!doctype html>
<html lang="en">

<head>
  <title>Data Peserta</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/animate.css">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet"href="./css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="./css/dataTables.bootstrap4.min.css">
</head>

<body>
  <a href="kelas.php" class="btn-sm btn btn-primary" style="position: absolute; top: 0;right: 0;margin-top: 10px;margin-right: 10px;"
  >Kelas</a>
  <div class="container-fluid gradient-2">
    <div class="row">
      <div class="col-12 text-left mt-3 mb-3">
        <h2 class="animated fadeInDown presensi ">Data Peserta Presensi</h2>
        <h1 class="display-4 animated fadeInDown">Kelas Eksekutif #YukNgaji</h1>
      </div>
    </div>
    <div class="row"> 
      <div class="linehor"> </div>
    </div>

   


    

    <div class="row">

      <div class="col-8">
        
        <div class="row mb-4 text-left pt-3"> 
          <div class="col-12">
         <button type="button" class="btn btn-primary" onclick="form_add()">Tambah Peserta</button>
          </div>
        </div>
        <div class="row">
          <div class="col-11 table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar2">
            <table class="table table-bordered table-hover table-sm bg-light">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">Alamat</th>
                <th scope="col" width="200">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <!-- List Data Menggunakan DataTable -->              
            </tbody>
          </table>
          </div>
        </div>
      </div>

      <div class="col-4 mt-5 text-center">
     <img src="./assets/logoBG.png" class="d-flex mx-auto mt-5" style="width: 60% !important;">
      </div>

    </div>

  </div>

   <!-- START Modal Form -->

  <div class="modal fade" id="modalpeserta" tabindex="-1" role="dialog" aria-labelledby="modalpeserta" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                  <form onsubmit="return save_data()">
                  <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2" style="color: #000;">Tambah Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body" style="color: #000;">
                        <input type="hidden" name="id" id="id">
                        <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="Nama">Nama</label>
                          <input type="text" class="form-control" name="nama" id="nama">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="Email">Email</label>
                          <input type="email" class="form-control" name="email" id="email">
                        </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label for="Alamat">Alamat</label>
                            <textarea class="form-control" rows="5" name="alamat" id="alamat"></textarea>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <div class="mr-auto">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button> 

                      </div>
                    </div>
                  </div>
                  </form>
                  </div>
                </div>

  <!-- END Modal Form -->

  <script src="./js/jquery-3.3.1.min.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap4.min.js"></script>
  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="./js/bootstrap-datepicker.js"></script>

  <script type="text/javascript">
     //Tempat Proses Jquery Ajax
      
      var save_method, table,pesan;
      //Menerapkan plugin datatables
      $(function(){
         table = $('.table').DataTable( {
                "processing": true,
                "ajax": "ajax/ajax_peserta.php?action=table_data"
            } );
         });

        function form_add(){
         save_method = "add";
         $('#modalpeserta').modal('show');
         $('#modalpeserta form')[0].reset();
         $('.modal-title').text('Tambah Peserta');
      }

      function form_edit(id){
           save_method = "edit";
           $.ajax({
              url : "ajax/ajax_peserta.php?action=form_data&id="+id,
              type : "GET",
              dataType : "JSON",
              success : function(data){
                 $('#modalpeserta').modal('show');
                 $('.modal-title').text('Ubah Peserta');
              
                 $('#id').val(data.id_peserta);
                 $('#nama').val(data.nama);
                 $('#email').val(data.email);
                 $('#alamat').val(data.alamat);
              },
              error : function(){
                 alert("Tidak dapat menampilkan data!");
              }
           });
      }

      function save_data(){
         if(save_method == "add"){
            url = "ajax/ajax_peserta.php?action=insert";
            pesan = "Berhasil Disimpan";
         }else{ 
            url = "ajax/ajax_peserta.php?action=update";
            pesan= "Berhasil Diubah";
         }

         $.ajax({
            url : url,
            type : "POST",
            data : $('#modalpeserta form').serialize(),
            success : function(){
               $('#modalpeserta').modal('hide');
               $('#modalpeserta form')[0].reset();
               alert(pesan);
               table.ajax.reload();         
            },
            error : function(){
               alert("Tidak dapat menyimpan data!");
            }     
         });
         return false;
      }

      function delete_data(id){
         if(confirm("Apakah yakin data akan dihapus?")){
            $.ajax({
               url : "ajax/ajax_peserta.php?action=delete&id="+id,
               type : "GET",
               success : function(data){
                  alert("Data Berhasil Dihapus")
                  table.ajax.reload();
               },
               error : function(){
                  alert("Tidak dapat menghapus data!");
               }
            });
         }
      }


    
  </script>

</body>

</html>