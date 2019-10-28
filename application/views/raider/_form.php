<?php
$action = base_url('rider/store');
if ($data_edit) {
    $action = base_url('rider/update');
}
?>

<form method="POST" action="<?= $action ?>" id="upload-create" enctype="multipart/form-data" class="form-horizontal">
    <div class="box-body">
        <div class="show_error"></div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Nama Rider*</label>
            <div class="col-sm-9">
                <?php if ($data_edit) {
                    echo '<input type="hidden" name="dt[id]" value="' . $data_edit['id'] . '">';
                }  ?>
                <input type="text" class="form-control" placeholder="Masukan Nama Rider ..." name="dt[name]" <?php if ($data_edit) {
                                                                                                                    echo "value='" . $data_edit['name'] . "'";
                                                                                                                }  ?>>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Team*</label>
            <div class="col-sm-9">
                <select class="form-control select2" name="dt[team_id]">
                    <option value="0" <?php if ($data_edit) {
                                            if ($data_edit['team_id'] == "0") {
                                                echo "selected";
                                            }
                                        } ?>> - Tanpa Team / Perorangan - </option> <?php
                                                                                    $tbl_team = $this->mymodel->selectWhere("tbl_team", array('status' => 'ENABLE'));
                                                                                    foreach ($tbl_team as $key => $value) {
                                                                                        ?> <option value="<?= $value['id'] ?>" <?php if ($data_edit) {
                                                                                                                                        if ($data_edit['team_id'] == $value['id']) {
                                                                                                                                            echo "selected";
                                                                                                                                        }
                                                                                                                                    } else if ($_GET['team_id'] == $value['id']) {
                                                                                                                                        echo "selected";
                                                                                                                                    } ?>>
                            <?= $value['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Email Rider</label>
            <div class="col-sm-9">
                <input type="email" name="dt[email]" class="form-control" <?php if ($data_edit) {
                                                                                echo "value='" . $data_edit['email'] . "'";
                                                                            } ?>>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-4">
                <div class="input-group">
                    <div class="input-group-addon">
                        Password
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="*****">
                </div>
            </div>
            <div class="col-sm-5">
                <div class="input-group">
                    <div class="input-group-addon">
                        Konfirmasi Password
                    </div>
                    <input type="password" name="confirmpassword" class="form-control" placeholder="*****">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
            <div class="col-sm-9">
                <textarea name="dt[alamat]" class="form-control" rows="5"><?php if ($data_edit) {
                                                                                echo $data_edit['alamat'];
                                                                            }  ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Kota Rider</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="Masukan Kota Rider ..." name="dt[kota]" <?php if ($data_edit) {
                                                                                                                    echo "value='" . $data_edit['kota'] . "'";
                                                                                                                }  ?>>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Lahir</label>
            <div class="col-sm-9">
                <input type="text" class="form-control tgl" name="dt[kota]" <?php if ($data_edit) {
                                                                                echo "value='" . $data_edit['tgllahir'] . "'";
                                                                            }  ?>>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Nomor Start*</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" name="dt[nostart]" <?php if ($data_edit) {
                                                                                    echo "value='" . $data_edit['nostart'] . "'";
                                                                                }  ?>>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Nama di Jersey*</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="dt[namajersey]" <?php if ($data_edit) {
                                                                                    echo "value='" . $data_edit['namajersey'] . "'";
                                                                                }  ?>>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Ukuran Jersey*</label>
            <div class="col-sm-9">
                <label>
                    <input type="radio" name="dt[ukuran_jersey]" class="minimal" value="S" <?php if ($data_edit) {
                                                                                                if ($data_edit['ukuran_jersey'] == 'S') {
                                                                                                    echo "checked";
                                                                                                }
                                                                                            } else {
                                                                                                echo "checked";
                                                                                            } ?>>
                    S
                </label>
                <label>
                    <input type="radio" name="dt[ukuran_jersey]" class="minimal" value="M" <?php if ($data_edit) {
                                                                                                if ($data_edit['ukuran_jersey'] == 'M') {
                                                                                                    echo "checked";
                                                                                                }
                                                                                            } ?>>
                    M
                </label>
                <label>
                    <input type="radio" name="dt[ukuran_jersey]" class="minimal" value="L" <?php if ($data_edit) {
                                                                                                if ($data_edit['ukuran_jersey'] == 'L') {
                                                                                                    echo "checked";
                                                                                                }
                                                                                            } ?>>
                    L
                </label>
                <label>
                    <input type="radio" name="dt[ukuran_jersey]" class="minimal" value="XL" <?php if ($data_edit) {
                                                                                                if ($data_edit['ukuran_jersey'] == 'XL') {
                                                                                                    echo "checked";
                                                                                                }
                                                                                            } ?>>
                    XL
                </label>
                <label>
                    <input type="radio" name="dt[ukuran_jersey]" class="minimal" value="XXL" <?php if ($data_edit) {
                                                                                                    if ($data_edit['ukuran_jersey'] == 'XXL') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                } ?>>
                    XXL
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Nomor Wa</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="Masukan Kota Team ..." name="dt[nowa]" <?php if ($data_edit) {
                                                                                                                echo "value='" . $data_edit['nowa'] . "'";
                                                                                                            }  ?>>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Nama Motor*</label>
            <div class="col-sm-9">
                <select class="form-control select2" name="dt[motor_id]">
                    <?php
                    $master_motor = $this->mymodel->selectData("master_motor");
                    foreach ($master_motor as $key => $value) {
                        ?>
                        <option value="<?= $value['id'] ?>" <?php if ($data_edit) {
                                                                    if ($data_edit['motor_id'] == $value['id']) {
                                                                        echo "selected";
                                                                    }
                                                                } ?>>
                            <?= $value['value'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Gol. Darah</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="Masukan Gol. Darah ..." name="dt[goldarah]" <?php if ($data_edit) {
                                                                                                                        echo "value='" . $data_edit['goldarah'] . "'";
                                                                                                                    }  ?>>
            </div>
        </div>
        <div class="show_error"></div>
    </div>
    <div class="box-footer" align="right">
        <a href="<?= base_url('team') ?> ">
            <button type="button" class="btn btn-info"><i class="fa fa-stars"></i> Data Team</button>
        </a>
        <?php if ($data_edit) { ?>
            <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-edit"></i> Edit</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Save</button>
        <?php } ?>
    </div>
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
                            window.location.href = "<?= base_url('rider') ?>";
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

    $('.textarea').wysihtml5();
</script>