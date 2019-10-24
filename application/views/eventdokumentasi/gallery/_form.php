<?php

if($data_edit){
  $action = base_url('eventdokumentasi/imageupdate/'.$data_edit['id']);
}

?>

<form method="POST" action="<?= $action ?>" id="upload-create" enctype="multipart/form-data" class="form-horizontal">
  <div class="box-body">
    <div class="show_error"></div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Groub Gambar*</label>
      <input type="hidden" name="event_id" value="<?= $event_id ?>">
      <div class="col-sm-9">
        <select class="form-control select2" name="dt[imagegroup_id]">
          <option value="">-- Pilih Kategori Gambar --</option>
          <?php
          $master_imagegroup = $this->mymodel->selectWhere("master_imagegroup", array("id_event" => $event_id));
          foreach ($master_imagegroup as $key => $value) {
            ?>
            <option value="<?= $value['id'] ?>" <?php if($data_edit){if($data_edit['id'] == $value['id']) { echo "selected"; }} ?> ><?= $value['value'] ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Gambar*</label>
      <div class="col-sm-9">
        <div class="box-body">
          <?php if($data_edit){ ?>
            <table class="table table-bordered" style="width: 100%">
              <thead style="font-weight: bold;">
                <tr>
                  <th style="width: 300px">Gambar</th>
                  <th>Info Gambar</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="detail_image_open">
                <?php
                $i = 0;
                $file_detail = $this->mymodel->selectWhere("tbl_gallery", array('imagegroup_id' => $data_edit['id']));
                foreach($file_detail as $img){
                  $nomor = $i + 1;
                  $file = $this->mymodel->selectDataone("file", array('table_id' => $img['id'], 'table' => 'tbl_gallery'));?>
                  <tr id="detail_image_edit">
                    <td>
                      <img id="image_previewDetail-<?=$i?>" src="<?= $file['url']?>" alt="User Image" height="150px" style="margin: 15px">
                    </td>
                    <td>
                      <div class="row">
                        <div class="col-md-10">
                          <div class="form-group">
                            <label>Judul Gambar*</label>
                            <input type="text" class="form-control" placeholder="Masukan Nama gambar" value="<?= $img['title']?>" readonly>
                          </div>
                          <div class="form-group">
                            <label>Caption Gambar</label>
                            <textarea class="form-control" rows="5" readonly><?= $img['caption']?></textarea>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <a href="<?= base_url('eventdokumentasi/editImage/').$img['id'].'/'.$event_id?>">
                        <button type="button" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Ubah Detail Gambar</button>
                      </a>
                      <button type="button" class="btn btn-danger btn-send" data-toggle="modal" data-target="#modal-delete-imageDetail-<?=$i?>"><i class="fa fa-update"></i> Hapus Detail Gambar</button>
                      <div class="modal modal-default fade" id="modal-delete-imageDetail-<?=$i?>" style="display: none;">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header bg-red">
                              <h4 class="modal-title" align="center"><i class="fa fa-image"></i> Hapus Detail Gambar</h4>
                            </div>
                            <div class="modal-body" align="center">
                              <h3>Anda Yakin Ingin Menghapus Gambar Ke-<?=$nomor?></h3>
                              <div class="box-footer" align="center">
                                <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                                <a href="<?= base_url('eventdokumentasi/delete_image/'.$img['id'].'/'.$event_id)?>">
                                  <button type="button" class="btn btn-danger btn-send" ><i class="fa fa-trash"></i> Hapus</button>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php
                  $i++;
                }?>
              </tbody>
              <tfoot>
                <td colspan="3" align="center" id="btn_image_add">
                  <a href="<?= base_url('eventdokumentasi/addOneImage/').$data_edit['id']?>">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"><i class="fa fa-file"></i> Tambah Gambar</button>
                  </a>
                  <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-image"><i class="fa fa-trash"></i> Hapus Semua Gambar</button>
                </td>
              </tfoot>
            </table>
            <div class="modal modal-default fade" id="modal-delete-image" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header bg-red">
                    <h4 class="modal-title" align="center"><i class="fa fa-image"></i> Hapus Semua Detail Gambar</h4>
                  </div>
                  <div class="modal-body" align="center">
                    <h3>Anda Yakin Ingin Menghapus Semua Gambar</h3>
                    <div class="box-footer" align="center">
                      <button type="button" class="btn btn-info"><i class="fa fa-close" data-dismiss="modal"></i> Tutup</button>
                      <a href="<?= base_url('eventdokumentasi/delete_Allimage/'.$data_edit['id'])?>">
                        <button type="button" class="btn btn-danger btn-send" ><i class="fa fa-trash"></i> Hapus</button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } else {?>
            <button type="button" class="btn btn-sm btn-primary" id="btnFile-many"><i class="fa fa-file"></i> Masukan Gambar</button>
            <input type="file" id="uploadFile" name="file_many[]" style="display: none" multiple accept="image/x-png,image/jpeg,image/jpg" />
            <p class="help-block" id="note_image">Gambar Bisa Multi Select</p>
            <table class="table table-bordered" style="width: 100%">
              <thead style="font-weight: bold;">
                <tr>
                  <th style="width: 300px">Gambar</th>
                  <th>Info Gambar</th>
                </tr>
              </thead>
              <tbody id="detail_image_open">
              </tbody>
            </table>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="show_error"></div>
  </div>
  <div class="box-footer" align="right">
    <a href="<?= base_url('eventdokumentasi/view/').$event_id ?> ">
      <button type="button" class="btn btn-info"><i class="fa fa-picture-o"></i> Data Dokuemntasi Event</button>
    </a>
  </div>
</form>
<script type="text/javascript">
  $(function () {

    $("#upload-create").submit(function(){
      var form = $(this);
      var mydata = new FormData(this);
      $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: mydata,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend : function(){
          $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
          form.find(".show_error").slideUp().html("");
        },

        success: function(response, textStatus, xhr) {
          var str = response;
          if (str.indexOf("success") != -1){
            form.find(".show_error").hide().html(response).slideDown("fast");
            setTimeout(function(){
              window.location.href = "<?= base_url('eventdokumentasi/view/'.$event_id) ?>";
            }, 1000);

            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
          }else{
            form.find(".show_error").hide().html(response).slideDown("fast");
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
          }
        },
        error: function(xhr, textStatus, errorThrown) {
          console.log(xhr);
          $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
          form.find(".show_error").hide().html(xhr).slideDown("fast");
        }
      });
      return false;
    });
  });

  $('.textarea').wysihtml5();
</script>
