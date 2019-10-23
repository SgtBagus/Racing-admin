<div class="content-wrapper">
    <section class="content-header">
        <h1>Lihat Juara Hari ke - <?= $tbl_juara['days'] ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Lihat Juara</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form method="POST" action="<?= base_url('juara/update') ?>" id="upload" enctype="multipart/form-data" class="form-horizontal">
                        <div class="box-body">
                            <div class="show_error"></div>
                            <?php
                            $i = 1;
                            $array = 0;
                            foreach ($tbl_juara_detail as $row) {
                                ?>
                                <input type="hidden" name="dtd[id_juara][<?= $array ?>]" value="<?= $row['id'] ?>">
                                <div class="form-group">
                                    <h3 for="inputEmail3" class="col-sm-3 control-label">Juara <?= $i ?></h3>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Nama Raider</label>
                                    <div class="col-sm-9">
                                        <select name="dtd[idRaider][<?= $array ?>]" class="form-control select2">
                                            <?php
                                                foreach ($raider_terdaftar as $raider_terdaftar_record) {
                                                    $name_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $raider_terdaftar_record['raider_id'])); ?>
                                                <option value="<?= $raider_terdaftar_record['raider_id'] ?>" <?php if($raider_terdaftar_record['raider_id'] == $row['id_raider']){echo "selected"; } ?>> <?= $name_raider['name'] ?></option>";
                                            <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Point</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="dtd[point][<?= $array ?>]" class="form-control" value="<?= $row['point'] ?>">
                                    </div>
                                </div>

                            <?php $i++;
                                $array++;
                            } ?>
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
                            window.location.href = "<?= base_url('juara/view/') . $tbl_juara['id_event'] ?>";
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