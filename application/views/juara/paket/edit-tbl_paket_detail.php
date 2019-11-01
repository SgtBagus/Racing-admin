<form method="POST" action="<?= base_url('juara/paketdetailupdate') ?>" id="upload-create" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $tbl_paket_detail['id'] ?>">
    <div class="show_error"></div>
    <div class="form-group">
        <label>Team</label>
        <select class="form-control" name="dt[id_team]" id="team">
            <option value=""> - SEMUA RIDER TERDAFTAR - </option>
            <?php
            $tbl_team = $this->mymodel->selectWithQuery("SELECT a.team_id as team_id, b.name as name FROM tbl_event_register a LEFT JOIN tbl_team b ON a.team_id = b.id WHERE a.approve = 'APPROVE' AND a.event_id = " . $event_id . " ORDER BY a.team_id ASC");
            foreach ($tbl_team as $key => $row) {
                $value = $row['team_id'];
                $name = $row['name'];

                if ($row['team_id'] == 0) {
                    $value = 0;
                    $name = 'Rider Tanpa Team';
                }

                ?>
                <option value="<?= $value ?>" <?php if ($value == $tbl_paket_detail['id_team']) {
                                                        echo "selected";
                                                    } ?>><?= $name ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="form-id_raider">Raider</label>
        <select class="form-control" name="dt[id_raider]" id="rider">
            <?php
            $tbl_raider = $this->mymodel->selectWithQuery("SELECT a.raider_id as raider_id, c.name as nameraider, c.nostart as nostart, d.name as nameteam FROM tbl_event_register_raider a LEFT JOIN tbl_event_register b ON a.event_register_id = b.id LEFT JOIN tbl_raider c ON a.raider_id = c.id LEFT JOIN tbl_team d ON b.team_id = d.id WHERE b.approve = 'APPROVE' AND b.event_id = " . $event_id . " AND b.team_id = " . $tbl_paket_detail['id_team']);
            foreach ($tbl_raider as $key => $row) {
                $nameteam = $row['nameteam'];
                if (!$nameteam) {
                    $nameteam = 'INDIVIDU';
                }
                ?>
                <option value="<?= $row['raider_id'] ?>" <?php if ($row['raider_id'] == $tbl_paket_detail['id_raider']) {
                                                                    echo "selected";
                                                                } ?>><?= $row['nameraider'] ?> - #<?= $row['nostart'] ?> - <?= $nameteam ?></option>
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
            $.ajax({
                url: "<?= base_url() ?>ajax/get_rider/<?= $event_id ?>/" + team_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $("#rider").empty();
                    if (!$.trim(data)) {
                        $("#rider").append('<option value="">Data Tidak Tersedia</option>');
                    } else {
                        $.each(data, function(key, value) {
                            var nameteam = value.nameteam;
                            if (!nameteam) {
                                nameteam = 'INDIVIDU';
                            }

                            $("#rider").append('<option value="' +
                                value.id + '">' + value.nameraider + ' - #' + value.nostart + " - " + nameteam +
                                '</option>');
                        });
                    }
                }
            });
        }

        $("#team").change(function() {
            get_rider($("#team").val());
        });
    });
</script>