<div class="content-wrapper">
    <section class="content-header">
        <h1> Pendaftar Event <small><?= $tbl_event['title'] ?></small> </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Tim</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xm-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <center>
                            <img src="<?= $file_event['url'] ?>" style="width: 550px; height: 350px; border-radius: 20px" class="img img-thumbnail">
                        </center>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Event</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Event</label>
                                                    <input type="text" class="form-control" value="<?= $tbl_event['title'] ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Nomor Petanggung Jawab Event</label>
                                                            <input type="text" class="form-control" value="<?= $tbl_event['phone'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label> Hubungi Melalui</label>
                                                            <a href="#" target="_blank">
                                                                <button type="button" class="btn btn-sm btn-success btn-block"><i class="fa fa-whatsapp"></i> Whatsapp</button>
                                                            </a>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Tanggal Dimulai</label>
                                                            <input type="text" class="form-control" value="<?= date('d M Y', strtotime($tbl_event['tgleventStart'])) ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Tanggal Selesai</label>
                                                            <input type="text" class="form-control" value="<?= date('d M Y', strtotime($tbl_event['tgleventEnd'])) ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Minim Rider</label>
                                                            <input type="text" class="form-control" value="<?= $tbl_event['minraider'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Maximal Rider</label>
                                                            <input type="text" class="form-control" value="<?= $tbl_event['maxraider'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Kota Event</label>
                                                            <input type="text" class="form-control" value="<?= $tbl_event['kota'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Alamat Lengkap Event</label>
                                                            <textarea class="form-control" readonly rows="5px"><?= $tbl_event['alamat'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Juara Umum</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <center>
                                <?php if ($tbl_raider) { ?>
                                    <img src="<?= $file_raider['url'] ?>" style="width: 200px; height: 200px; border-radius: 20px" class="img img-thumbnail">
                                    <br>
                                    <h4>
                                        <b>
                                            <?= $tbl_raider['name'] ?> <?php if ($tbl_raider['verificacion'] == 'ENABLE') {
                                                                                echo '<i class="fa fa-check-circle" style="color: #3b8dbc"> </i>';
                                                                            } ?>
                                        </b>
                                        <br>
                                        Point : <?= $point ?>
                                    </h4>
                                <?php } else { ?>
                                    Belum Tersedia
                                <?php } ?>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Juara</h3>
                        </div>
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <a href="<?= base_url('juara/adddays/') . $tbl_event['id'] ?>">
                                            <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Juara</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="bg-success">
                                            <th>No</th>
                                            <th>Hari Ke</th>
                                            <th>Juara Umum</th>
                                            <th>Juara Point</th>
                                            <th>Dibuat Pada</th>
                                            <th>Diubah Pada</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($tbl_juara as $row) {
                                            $tbl_juara_detail = $this->mymodel->selectWithQuery("SELECT id_raider, MAX(point) as point FROM tbl_juara_detail WHERE id_juara = '" . $row['id'] . "'");
                                            $tbl_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $tbl_juara_detail[0]['id_raider']));
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td>
                                                    <?= $row['days'] ?>
                                                </td>
                                                <td><?= $tbl_raider['name'] ?></td>
                                                <td><?= $tbl_juara_detail[0]['point'] ?></td>
                                                <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                                <td><?= date('d M Y', strtotime($row['updated_at'])) ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-info" onclick="view(<?= $row['id'] ?> )">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="hapus(<?= $row['id'] ?> )">
                                                            <i class="fa fa-trash"></i>
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
        </div>
        <div class="row" align="center">
            <a href="<?= base_url('eventregister') ?>">
                <button type="button" class="btn btn-sm btn-sm btn-info"><i class="fa fa-arrow-left"></i> Kembali</button>
            </a>
        </div>
    </section>
</div>

<script type="text/javascript">
    function view(id) {
        location.href = "<?= base_url('juara/viewDays/') ?>" + id;
    }
    
    function hapus(id) {
        location.href = "<?= base_url('juara/delete/') ?>" + id + "/<?=$tbl_event['id']?>";
    }
</script>