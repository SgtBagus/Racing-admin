<div class="content-wrapper">
    <section class="content-header">
        <h1>Tambah Juara </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Tambah Juara</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form method="POST" action="<?= base_url('juara/store') ?>" id="upload" enctype="multipart/form-data" class="form-horizontal">
                        <div class="box-body">
                            <div class="show_error"></div>
                            
                            <input type="hidden" name="id_event" value="<?=$id?>">
                            <div class="form-group">
                                <h3 for="inputEmail3" class="col-sm-3 control-label">Juara 1</h3>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nama Raider</label>
                                <div class="col-sm-9">
                                    <select name="dtd[idRaider][0]" class="form-control select2">
                                        <?php
                                        foreach ($raider_terdaftar as $raider_terdaftar_record) {
                                            $name_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $raider_terdaftar_record['raider_id']));
                                            echo "<option value=" . $raider_terdaftar_record['raider_id'] . ">" . $name_raider['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Point</label>
                                <div class="col-sm-9">
                                    <input type="number" name="dtd[point][0]" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <h3 for="inputEmail3" class="col-sm-3 control-label">Juara 2</h3>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nama Raider</label>
                                <div class="col-sm-9">
                                    <select name="dtd[idRaider][1]" class="form-control select2">
                                        <?php
                                        foreach ($raider_terdaftar as $raider_terdaftar_record) {
                                            $name_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $raider_terdaftar_record['raider_id']));
                                            echo "<option value=" . $raider_terdaftar_record['raider_id'] . ">" . $name_raider['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Point</label>
                                <div class="col-sm-9">
                                    <input type="number" name="dtd[point][1]" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <h3 for="inputEmail3" class="col-sm-3 control-label">Juara 3</h3>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nama Raider</label>
                                <div class="col-sm-9">
                                    <select name="dtd[idRaider][2]" class="form-control select2">
                                        <?php
                                        foreach ($raider_terdaftar as $raider_terdaftar_record) {
                                            $name_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $raider_terdaftar_record['raider_id']));
                                            echo "<option value=" . $raider_terdaftar_record['raider_id'] . ">" . $name_raider['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Point</label>
                                <div class="col-sm-9">
                                    <input type="number" name="dtd[point][2]" class="form-control">
                                </div>
                            </div>
                            <div class="show_error"></div>
                        </div>
                        <div class="box-footer" align="right">
                            <a href="<?= base_url('juara/view/') . $id ?> ">
                                <button type="button" class="btn btn-info"><i class="fa fa-stars"></i> Kembali</button>
                            </a>
                            <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
  $(function() {
    $("#upload").submit(function() {
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
          form.find(".show_error").slideUp().html("");
        },

        success: function(response, textStatus, xhr) {
          var str = response;
          if (str.indexOf("success") != -1) {
            form.find(".show_error").hide().html(response).slideDown("fast");
            setTimeout(function() {
              window.location.href = "<?= base_url('juara/view/').$id ?>";
            }, 1000);

            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
          } else {
            form.find(".show_error").hide().html(response).slideDown("fast");
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
          }
        },
        error: function(xhr, textStatus, errorThrown) {
          console.log(xhr);
          $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
          form.find(".show_error").hide().html(xhr).slideDown("fast");
        }
      });
      return false;
    });
  });
</script>