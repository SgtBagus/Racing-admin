 <div class="content-wrapper">
   <section class="content-header">
     <h1> Event </h1>
     <ol class="breadcrumb">
       <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
       <li class="active">Event</li>
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
                   <a href="<?= base_url('event/create') ?>">
                     <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Event</button>
                   </a>
                   <a href="<?= base_url('fitur/ekspor/tbl_event') ?>" target="_blank">
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
                     <th>Judul Event</th>
                     <th>Harga Pendaftaran</th>
                     <th>Tgl Event Dimulai</th>
                     <th>Tgl Event Berakhir</th>
                     <th>Aturan Event</th>
                     <th>Status Event</th>
                     <th>Public</th>
                     <th>Status Pendaftaran</th>
                     <th></th>
                   </tr>
                 </thead>
                 <tbody>
                   <?php
                    $i = 1;
                    foreach ($tbl_event as $row) {
                      $file =  $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'tbl_event'));
                      $rule =  $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'event_rule'));
                      ?>
                     <tr>
                       <td><?= $i ?></td>
                       <td><?= $row['title'] ?></td>
                       <td>Rp <?= $row['harga'] ?>,-</td>
                       <td>
                         <?php
                            if ($row['tgleventStart']) {
                              echo date('d M Y', strtotime($row['tgleventStart']));
                            } else {
                              echo "<p class='help-block'><i>Belum Tersedia</i></p>";
                            }
                            ?>
                       </td>
                       <td>
                         <?php
                            if ($row['tgleventEnd']) {
                              echo date('d M Y', strtotime($row['tgleventEnd']));
                            } else {
                              echo "<p class='help-block'><i>Belum Tersedia</i></p>";
                            }
                            ?>
                       </td>
                       <td align="center">
                         <?php
                            if ($rule) {
                              echo '
                          <div class="row" align="center">
                          Peraturan Event - ' . $row['title'] . '
                          <div class="col-md-12">
                          <a href="' . base_url($rule['dir']) . '" target="_blank">
                          <button type="button" class="btn btn-send btn-info btn-sm btn-sm btn-primary"><i class="fa fa-eye"></i></button>
                          </a>
                          <a href="' . base_url('download/downloadPDFEvent/' . $rule['id']) . '">
                          <button type="button" class="btn btn-send btn-warning btn-sm btn-sm btn-danger"><i class="fa fa-download"></i></button>
                          </a>
                          </div>
                          </div>';
                            } else {
                              echo "<p class='help-block'><i>Belum Tersedia</i></p>";
                            }
                            ?>
                       </td>
                       <td align="center">
                         <?php
                            if ($row['statusEvent'] == 'STARTED') {
                              echo '<small class="label bg-yellow"><i class="fa fa-warning"> </i> Belum Dimulai</small>
                          <hr>
                          <div class="row" align="center">
                          <div class="col-md-12">
                          <button type="button" class="btn btn-send btn-approve btn-sm btn-sm btn-primary" onclick="start(' . $row['id'] . ')"><i class="fa fa-check-circle"></i> Mulai Event</button>
                          <button type="button" class="btn btn-send btn-reject btn-sm btn-sm btn-danger" onclick="cancel(' . $row['id'] . ')"><i class="fa fa-ban"></i> Batalkan Event</button>
                          </div>
                          </div>';
                            } else if ($row['statusEvent'] == "BERJALAN") {
                              echo '<small class="label bg-green"><i class="fa fa-warning"> </i> Event Dimulai</small>
                          <hr>
                          <div class="row" align="center">
                          <div class="col-md-12">
                          <button type="button" class="btn btn-send btn-approve btn-sm btn-sm btn-primary" onclick="finish(' . $row['id'] . ')"><i class="fa fa-check-circle"></i> Selesai Event</button>
                          <button type="button" class="btn btn-send btn-reject btn-sm btn-sm btn-danger" onclick="cancel(' . $row['id'] . ')"><i class="fa fa-ban"></i> Batalkan Event</button>
                          </div>
                          </div>';
                            } else if ($row['statusEvent'] == "BATAL") {
                              echo '<small class="label bg-red"><i class="fa fa-ban"> </i> Event Dibatalkan </small>';
                            } else if ($row['statusEvent'] == "SELESAI") {
                              echo '<small class="label bg-green"><i class="fa fa-check"> </i> Event Selesai </small>';
                            }
                            ?>
                       </td>
                       <td>
                         <?php if ($row['public'] == 'ENABLE') { ?>
                           <a href="<?= base_url('event/publicStatus/') . $row['id'] ?>/DISABLE">
                             <button type="button" class="btn btn-sm btn-sm btn-success">
                               <i class="fa fa-check-circle"></i> ENABLE
                             </button>
                           </a>
                         <?php } else { ?>
                           <a href="<?= base_url('event/publicStatus/') . $row['id'] ?>/ENABLE">
                             <button type="button" class="btn btn-sm btn-sm btn-danger">
                               <i class="fa fa-ban"></i> DISABLE
                             </button>
                           </a>
                         <?php } ?>
                       </td>
                       <td>
                         <?php if ($row['status'] == 'ENABLE') { ?>
                           <a href="<?= base_url('event/status/') . $row['id'] ?>/DISABLE">
                             <button type="button" class="btn btn-sm btn-sm btn-success">
                               <i class="fa fa-check-circle"></i> ENABLE
                             </button>
                           </a>
                         <?php } else { ?>
                           <a href="<?= base_url('event/status/') . $row['id'] ?>/ENABLE">
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
 <div class="modal fade bd-example-modal-sm" tabindex="-1" tbl_event="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <form id="upload-delete" action="<?= base_url('event/delete') ?>" method="POST">
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

 <div class="modal fade bd-example-modal" tabindex="-1" tbl_event="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-start">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <form id="upload-start" action="<?= base_url('event/start') ?>" method="POST">
         <div class="modal-header">
           <h5 class="modal-title">Mulai Event</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <input type="hidden" name="id" id="upload-input">
           <div class="form-group">
             <label>URL Link Live jika tersedia</label>
             <input type="text" class="form-control" placeholder="Masukan Link Live Event" name="dt[live_url]">
           </div>
         </div>
         <div class="modal-footer">
           <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-check-circle"></i> Mulai Event</button>
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         </div>
       </form>
     </div>
   </div>
 </div>

 <script type="text/javascript">
   loadtable($("#select-status").val());

   function edit(id) {
     location.href = "<?= base_url('event/edit/') ?>" + id;
   }

   function start(id) {
     $("#modal-start").modal('show');
     $("#upload-input").val(id);
   }

   function cancel(id) {
     location.href = "<?= base_url('event/cancel/') ?>" + id;
   }

   function finish(id) {
     location.href = "<?= base_url('event/finish/') ?>" + id;
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