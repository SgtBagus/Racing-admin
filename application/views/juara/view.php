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
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="bg-success">
                                            <th>No</th>
                                            <th>Hari ke / Tanggal</th>
                                            <th>Juara Ke 1</th>
                                            <th>Juara Ke 2</th>
                                            <th>Juara Ke 3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($tbl_juara as $row) {
                                            $tbl_juara_detail = $this->mymodel->selectWithQuery("SELECT id, id_raider, MAX(point) as point FROM tbl_juara_detail WHERE id_juara = '" . $row['id'] . "'");
                                            $tbl_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $tbl_juara_detail[0]['id_raider']));
                                            $winner1 = $this->mymodel->selectDataone('tbl_juara_detail', array('id_event' => $tbl_event['id'], 'id_juara' => $row['id'], 'juara' => '1'));
                                            $winner2 = $this->mymodel->selectDataone('tbl_juara_detail', array('id_event' => $tbl_event['id'], 'id_juara' => $row['id'], 'juara' => '2'));
                                            $winner3 = $this->mymodel->selectDataone('tbl_juara_detail', array('id_event' => $tbl_event['id'], 'id_juara' => $row['id'], 'juara' => '3'));
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td>
                                                    <?php $days = $row['days']; ?>
                                                    <?= $row['days'] . " / " . date('d M Y', strtotime($tbl_event['tgleventStart'] . ' +' . strval($days - 1) . ' day')) ?>
                                                </td>
                                                <td style="width:300px">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <?php if ($winner1) { ?>
                                                                <form method="POST" action="<?= base_url('juara/updateWinner_1/') . $tbl_juara_detail[0]['id'] ?>">
                                                                <?php } else { ?>
                                                                    <form method="POST" action="<?= base_url('juara/addWinner_1/') . $row['id'] ?>">
                                                                    <?php } ?>
                                                                    <div class="show_error"></div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label>Rider : </label>
                                                                            <select name="dtd[idRaider]" class="form-control select2" style="width:100%">
                                                                                <?php
                                                                                    foreach ($raider_terdaftar as $raider_terdaftar_record) {
                                                                                        $name_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $raider_terdaftar_record['raider_id'])); ?>

                                                                                    <option value=<?= $raider_terdaftar_record['raider_id'] ?> <?php if ($winner1['id_raider'] == $raider_terdaftar_record['raider_id']) {
                                                                                                                                                            echo "selected";
                                                                                                                                                        } ?>> <?= $name_raider['name'] ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <br>
                                                                        <div class="col-md-12">
                                                                            <label>Point : </label>
                                                                            <input type="number" name="dtd[point]" class="form-control" style="width:100% !important" value="<?= $winner1['point'] ?>">
                                                                            <input type="hidden" name="dtd[idEvent]" class="form-control" value="<?= $row['id_event'] ?>">
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div align="right">
                                                                        <?php if ($winner1) { ?>
                                                                            <button type="submit" class="btn btn-primary btn-send">
                                                                                <i class="fa fa-edit"></i> Ubah
                                                                            </button>
                                                                        <?php } else { ?>
                                                                            <button type="submit" class="btn btn-primary btn-send">
                                                                                <i class="fa fa-save"></i> Simpan
                                                                            </button>
                                                                        <?php } ?>
                                                                    </div>
                                                                    </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width:300px">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <?php if ($winner2) { ?>
                                                                <form method="POST" action="<?= base_url('juara/updateWinner_2/') . $tbl_juara_detail[0]['id'] ?>">
                                                                <?php } else { ?>
                                                                    <form method="POST" action="<?= base_url('juara/addWinner_2/') . $row['id'] ?>">
                                                                    <?php } ?>
                                                                    <div class="show_error"></div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label>Rider : </label>
                                                                            <select name="dtd[idRaider]" class="form-control select2" style="width:100%">
                                                                                <?php
                                                                                    foreach ($raider_terdaftar as $raider_terdaftar_record) {
                                                                                        $name_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $raider_terdaftar_record['raider_id'])); ?>

                                                                                    <option value=<?= $raider_terdaftar_record['raider_id'] ?> <?php if ($winner2['id_raider'] == $raider_terdaftar_record['raider_id']) {
                                                                                                                                                            echo "selected";
                                                                                                                                                        } ?>> <?= $name_raider['name'] ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <br>
                                                                        <div class="col-md-12">
                                                                            <label>Point : </label>
                                                                            <input type="number" name="dtd[point]" class="form-control" style="width:100% !important" value="<?= $winner2['point'] ?>">
                                                                            <input type="hidden" name="dtd[idEvent]" class="form-control" value="<?= $row['id_event'] ?>">
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div align="right">
                                                                        <?php if ($winner2) { ?>
                                                                            <button type="submit" class="btn btn-primary btn-send">
                                                                                <i class="fa fa-edit"></i> Ubah
                                                                            </button>
                                                                        <?php } else { ?>
                                                                            <button type="submit" class="btn btn-primary btn-send">
                                                                                <i class="fa fa-save"></i> Simpan
                                                                            </button>
                                                                        <?php } ?>
                                                                    </div>
                                                                    </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width:300px">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <?php if ($winner3) { ?>
                                                                <form method="POST" action="<?= base_url('juara/updateWinner_3/') . $tbl_juara_detail[0]['id'] ?>">
                                                                <?php } else { ?>
                                                                    <form method="POST" action="<?= base_url('juara/addWinner_3/') . $row['id'] ?>">
                                                                    <?php } ?>
                                                                    <div class="show_error"></div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label>Rider : </label>
                                                                            <select name="dtd[idRaider]" class="form-control select2" style="width:100%">
                                                                                <?php
                                                                                    foreach ($raider_terdaftar as $raider_terdaftar_record) {
                                                                                        $name_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $raider_terdaftar_record['raider_id'])); ?>

                                                                                    <option value=<?= $raider_terdaftar_record['raider_id'] ?> <?php if ($winner3['id_raider'] == $raider_terdaftar_record['raider_id']) {
                                                                                                                                                            echo "selected";
                                                                                                                                                        } ?>> <?= $name_raider['name'] ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <br>
                                                                        <div class="col-md-12">
                                                                            <label>Point : </label>
                                                                            <input type="number" name="dtd[point]" class="form-control" style="width:100% !important" value="<?= $winner3['point'] ?>">
                                                                            <input type="hidden" name="dtd[idEvent]" class="form-control" value="<?= $row['id_event'] ?>">
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div align="right">
                                                                        <?php if ($winner3) { ?>
                                                                            <button type="submit" class="btn btn-primary btn-send">
                                                                                <i class="fa fa-edit"></i> Ubah
                                                                            </button>
                                                                        <?php } else { ?>
                                                                            <button type="submit" class="btn btn-primary btn-send">
                                                                                <i class="fa fa-save"></i> Simpan
                                                                            </button>
                                                                        <?php } ?>
                                                                    </div>
                                                                    </form>
                                                        </div>
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