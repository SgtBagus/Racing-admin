<div class="content-wrapper">
  <section class="content-header">
    <h1> Komentar </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Komentar</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <div class="show_error"></div>
            <div class="table-responsive">
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                  <tr class="bg-success">
                    <th style="width:20px">No</th>
                    <th>Dibuat Pada</th>
                    <th>Diubah Pada</th>
                    <th>Komentar</th>
                    <th>Nama</th>
                    <th>Judul Gallery</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($tbl_comment as $row) { 
                    $name = '';
                    $role = '';
                    if($row['id_raider']){
                      $tbl_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $row['id_raider']));
                      $name = $tbl_raider['name'];
                      $role = 'Rider';
                    }else if ($row['id_user']){
                      $user = $this->mymodel->selectDataone('user', array('id' => $row['id_user']));
                      $name = $user['name'];
                      $role = 'Admin';
                    }

                    $master_imagegroup = $this->mymodel->selectDataone('master_imagegroup', array('id' => $row['imagegroup_id']))

                    ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><?= date('d M Y H:i:s', strtotime($row['created_at']))?></td>
                      <td>
                        <?php
                        if ($row['updated_at']) {
                          echo date('d M Y H:i:s', strtotime($row['updated_at']));
                        } else {
                          echo "<p class='help-block'><i>Belum Tersedia</i></p>";
                        }
                        ?>
                      </td>
                      <td><?= $row['comment'] ?></td>
                      <td>
                        <?= $name ?> <br>
                        <p class='help-block'><i><?= $role ?></i></p>
                      </td>
                      <td><?= $master_imagegroup['value'] ?></td>
                      <td>
                        <?php if ($row['status'] == 'ENABLE') { ?>
                          <a href="<?= base_url('comment/status/') . $row['id'] ?>/DISABLE">
                            <button type="button" class="btn btn-sm btn-sm btn-success">
                              <i class="fa fa-check-circle"></i> ENABLE
                            </button>
                          </a>
                        <?php } else { ?>
                          <a href="<?= base_url('comment/status/') . $row['id'] ?>/ENABLE">
                            <button type="button" class="btn btn-sm btn-sm btn-danger">
                              <i class="fa fa-ban"></i> DISABLE
                            </button>
                          </a>
                        <?php } ?>
                      </td>
                      <td>
                        <div class="btn-group">
                          <?php if($row['id_user'] == $this->session->userdata('id')) { ?>
                           <button type="button" onclick="edit(<?= $row['id'] ?>)" class="btn btn-sm btn-info">
                             <i class="fa fa-edit"></i>
                           </button>
                         <?php } ?>
                         <button type="button" onclick="hapus(<?= $row['id'] ?>)" class="btn btn-sm btn-danger">
                           <i class="fa fa-trash-o"></i>
                         </button>
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
<div class="modal fade bd-example-modal-sm" tabindex="-1" tbl_event="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">
 <div class="modal-dialog modal-sm">
   <div class="modal-content">
     <form id="upload-delete" action="<?= base_url('comment/delete') ?>" method="POST">
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
<div class="modal fade bd-example-modal-sm" tabindex="-1" master_motor="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-form">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title-form" ></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="load-form"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

  function edit(id) {
    $("#load-form").html('loading...');

    $("#modal-form").modal();
    $("#title-form").html('Edit Komentar');
    $("#load-form").load("<?= base_url('comment/edit/') ?>"+id);
  }


  function hapus(id) {
   $("#modal-delete").modal('show');
   $("#delete-input").val(id);
 }

 $("#upload-start").submit(function() {
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