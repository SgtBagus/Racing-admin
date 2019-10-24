<form method="POST" action="<?= base_url('juara/paketdetailupdate') ?>" id="upload-create" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $tbl_paket_detail['id'] ?>">
    <div class="show_error"></div>
    <div class="form-group">
        <label>Team</label>
        <select class="form-control" name="dt[id_team]" id="team">
            <option value="">-- Pilih Team --</option>
            <?php
            $tbl_team = $this->mymodel->selectData("tbl_team");
            foreach ($tbl_team as $key => $value) {
                ?>
                <option value="<?= $value['id'] ?>" <?php if ($value['id'] == $tbl_paket_detail['id_team']) {
                                                            echo "selected";
                                                        } ?>><?= $value['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="form-id_raider">Raider</label>
        <select class="form-control" name="dt[id_raider]" id="rider">
            <option value="">-- Pilih Team --</option>
            <?php
            $tbl_raider = $this->mymodel->selectWhere("tbl_raider", array('team_id' => $tbl_paket_detail['id_team']));
            foreach ($tbl_raider as $key => $value) {
                ?>
                <option value="<?= $value['id'] ?>" <?php if ($value['id'] == $tbl_paket_detail['id_raider']) {
                                                            echo "selected";
                                                        } ?>><?= $value['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="form-number">Number</label>
        <input type="number" class="form-control" id="form-number" placeholder="Masukan Number" name="dt[number]" value="<?= $tbl_paket_detail['number'] ?>">
    </div>
    <div class="form-group">
        <label for="form-keterangan">Keterangan</label>
        <textarea class="form-control" name="dt[keterangan]"><?= $tbl_paket_detail['keterangan'] ?></textarea>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Save</button>
    <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
</form>
<script type="text/javascript">
    $(function() {
        $("#upload-create").submit(function() {
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
                            $("#load-table").html('');
                            loadtable($("#select-status").val());
                            $("#modal-form").modal('hide');
                        }, 1000);
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                    } else {
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                    form.find(".show_error").hide().html(xhr).slideDown("fast");
                }
            });
            return false;
        });

        function get_rider(team_id) {
            if (team_id) {
                $.ajax({
                    url: "<?= base_url() ?>ajax/get_rider/" + team_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $("#rider").empty();
                        if (!$.trim(data)) {
                            $("#rider").append('<option value="">Data Tidak Tersedia</option>');
                        } else {
                            $.each(data, function(key, value) {
                                $("#rider").append('<option value="' +
                                    value.id + '">' + value.name +
                                    '</option>');
                            });
                        }
                    }
                });
            } else {
                $("#rider").empty();
                $("#rider").append('<option value="">-Mohon Pilih Provinsi Terlebih Dahulu-</option>');
            }
        }

        $("#team").change(function() {
            get_rider($("#team").val());
        });
    });
</script>