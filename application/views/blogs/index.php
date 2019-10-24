 <div class="content-wrapper">
   <section class="content-header">
     <h1> Blog / Informasi </h1>
     <ol class="breadcrumb">
       <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
       <li class="active">Blog / Informasi</li>
     </ol>
   </section>
   <section class="content">
     <div class="row">
       <div class="col-xs-12">
         <div class="box">
           <div class="box-header">
             <div class="row">
               <div class="col-md-12">
                 <div class="pull-right">
                   <a href="<?= base_url('blogs/create') ?>">
                     <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Blog / Informasi</button>
                   </a>
                   <a href="<?= base_url('fitur/ekspor/tbl_blog') ?>" target="_blank">
                     <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-file-excel-o"></i> Ekspor Event</button>
                   </a>
                 </div>
               </div>
             </div>
           </div>
           <div class="box-body">
             <div class="show_error"></div>
             <div class="table-responsive">
               <table id="datatable" class="table table-bordered table-striped">
                 <thead>
                   <tr class="bg-success">
                     <th style="width:20px">No</th>
                     <th>Image</th>
                     <th>Judul Blog / Informasi</th>
                     <th>Deskripsi</th>
                     <th>Status</th>
                     <th></th>
                   </tr>
                 </thead>
                 <tbody>
                   <?php
                    $i = 1;
                    foreach ($tbl_blog as $row) {
                      $file =  $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'tbl_blog'));
                      ?>
                     <tr>
                       <td><?= $i ?></td>
                       <td><img src="<?= $file['url'] ?>" width="250px" height="180px"></td>
                       <td><?= $row['title'] ?></td>
                       <td><?= $row['deskripsi'] ?></td>
                       <td>
                         <?php if ($row['status'] == 'ENABLE') { ?>
                           <a href="<?= base_url('blogs/status/') . $row['id'] ?>/DISABLE">
                             <button type="button" class="btn btn-sm btn-sm btn-success">
                               <i class="fa fa-check-circle"></i> ENABLE
                             </button>
                           </a>
                         <?php } else { ?>
                           <a href="<?= base_url('blogs/status/') . $row['id'] ?>/ENABLE">
                             <button type="button" class="btn btn-sm btn-sm btn-danger">
                               <i class="fa fa-ban"></i> DISABLE
                             </button>
                           </a>
                         <?php } ?>
                       </td>
                       <td>
                         <div class="btn-group">
                           <button type="button" class="btn btn-sm btn-primary" onclick="edit(<?= $row['id'] ?>)">
                             <i class="fa fa-edit"></i>
                           </button>
                           <?php if ($this->session->userdata('role_id') == '17') { ?>
                             <button type="button" onclick="hapus(<?= $row['id'] ?>)" class="btn btn-sm btn-danger">
                               <i class="fa fa-trash-o"></i>
                             </button>
                           <?php } ?>
                         </div>
                       </td>
                     </tr>
                   <?php $i++;
                    } ?>
                 </tbody>
               </table>
             </div>
           </div>
         </div>
       </div>
     </div>
   </section>
 </div>
 <div class="modal fade bd-example-modal-sm" tabindex="-1" tbl_blog="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <form id="upload-delete" action="<?= base_url('blogs/delete') ?>" method="POST">
         <div class="modal-header">
           <h5 class="modal-title">Confirm delete</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <input type="hidden" name="id" id="delete-input">
           <p>Are you sure to delete this data?</p>
         </div>
         <div class="modal-footer">
           <button type="submit" class="btn btn-danger btn-send">Yes, Delete</button>
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         </div>
       </form>
     </div>
   </div>
 </div>
 <script type="text/javascript">
   loadtable($("#select-status").val());

   function edit(id) {
     location.href = "<?= base_url('blogs/edit/') ?>" + id;
   }

   function hapus(id) {
     $("#modal-delete").modal('show');
     $("#delete-input").val(id);
   }

   $("#upload-delete").submit(function() {
     event.preventDefault();
     var form = $(this);
     var mydata = new FormData(this);
     $.ajax({
       type: "POST",
       url: form.attr("action"),
       data: mydata,
       cache: false,
       contentType: false,
       processData: false,
       beforeSend: function() {
         $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled', true);
         $(".show_error").slideUp().html("");
       },
       success: function(response, textStatus, xhr) {
         var str = response;
         if (str.indexOf("success") != -1) {
           $(".show_error").hide().html(response).slideDown("fast");
           $(".btn-send").removeClass("disabled").html('Yes, Delete it').attr('disabled', false);
         } else {
           setTimeout(function() {
             $("#modal-delete").modal('hide');
           }, 1000);
           $(".show_error").hide().html(response).slideDown("fast");
           $(".btn-send").removeClass("disabled").html('Yes , Delete it').attr('disabled', false);
           loadtable($("#select-status").val());
         }
       },
       error: function(xhr, textStatus, errorThrown) {}
     });
     return false;
   });
 </script>