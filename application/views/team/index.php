<div class="content-wrapper">
    <section class="content-header">
        <h1>Tim</h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Tim</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-6"> </div>
                            <div class="col-md-6">
                                <div class="pull-right">
                                    <a href="<?= base_url('fitur/ekspor/tbl_team') ?>" target="_blank">
                                        <button type="button" class="btn btn-sm btn-warning">
                                            <i class="fa fa-file-excel-o"></i> Ekspor Tim
                                        </button>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-info" onclick="modal()">
                                        <i class="fa fa-file-excel-o"></i> Import Tim
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php
                        if($_GET['delete']){
                            echo '<div class="show_error">
                            <div class="alert alert-danger ks-solid ks-active-border" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true" class="fa fa-close"></span>
                            </button>
                            <h5 class="alert-heading"><i class="fa fa-ban"></i> Perhatian !</h5>
                            <ul>
                            <li>Team Berhasil Di Hapus</li>
                            </ul>
                            </div>
                            </div>';
                        }
                        ?>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="bg-success">
                                        <th style="width:20px">No</th>
                                        <th>Image</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>Kota</th>
                                        <th>Nomor Whatsapp</th>
                                        <th>Verifikasi</th>
                                        <th>Status</th>
                                        <th>Jumlah Manajer</th>
                                        <th>Jumlah Raider</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($tbl_team as $row) { 
                                        $photo = $this->mymodel->selectDataone('file', array('table' => 'tbl_team', 'table_id' => $row['id'])); 
                                        $rowmanager = $this->mymodel->selectWithQuery("SELECT count(id) as rowmanager from tbl_manager WHERE team_id = '".$row['id']."'");
                                        $rowraider = $this->mymodel->selectWithQuery("SELECT count(id) as rowraider from tbl_raider WHERE team_id = '".$row['id']."'");?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td align="center"><img src="<?= $photo['url']?>" width="100px" height="100px" ></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['email'] ?></td>
                                            <td><?= $row['alamat'] ?></td>
                                            <td><?= $row['kota'] ?></td>
                                            <td><?= $row['nowa'] ?></td>
                                            <td>
                                                <?php if($row['verificacion']=='ENABLE'){?>
                                                    <p> Terverifikasikan </p>
                                                    <a href="<?= base_url('team/verificacion/').$row['id'] ?>/DISABLE">
                                                        <button type="button" class="btn btn-sm btn-sm btn-danger">
                                                            <i class="fa fa-ban"></i> LEPAS VERIFIKASI
                                                        </button>
                                                    </a>
                                                <?php }else { ?>
                                                    <p> Belum Terverifikasi </p>
                                                    <a href="<?= base_url('team/verificacion/').$row['id'] ?>/ENABLE">
                                                        <button type="button" class="btn btn-sm btn-sm btn-primary">
                                                            <i class="fa fa-check-circle"></i> VERIFIKASI
                                                        </button>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($row['status']=='ENABLE'){?>
                                                    <a href="<?= base_url('team/status/').$row['id'] ?>/DISABLE">
                                                        <button type="button" class="btn btn-sm btn-sm btn-success">
                                                            <i class="fa fa-check-circle"></i> ENABLE
                                                        </button>
                                                    </a>
                                                <?php }else { ?>
                                                    <a href="<?= base_url('team/status/').$row['id'] ?>/ENABLE">
                                                        <button type="button" class="btn btn-sm btn-sm btn-danger">
                                                            <i class="fa fa-ban"></i> DISABLE
                                                        </button>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td><?= $rowmanager[0]['rowmanager'] ?></td>
                                            <td><?= $rowraider[0]['rowraider'] ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-info" onclick="view(<?= $row['id'] ?>)">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    <button type="button" onclick="hapus(<?=$row['id']?>)" class="btn btn-sm btn-danger">
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
<?php $this->load->view('modals/delete_modal') ?>
<?php $this->load->view('modals/import_modal') ?>
<script type="text/javascript">
    loadtable($("#select-status").val());

    function view(id) {
        location.href = "<?= base_url('team/view/') ?>" + id;
    }


    function modal(){
        $('#modal-impor').modal();
        $("#modal_title").text('Import Team');
    }

    function hapus(id) {
        $("#modal-delete").modal('show');
        $('#upload-delete').attr('action', ' http://192.168.100.9:8000/team/delete/'+id);
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