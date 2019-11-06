<div class="content-wrapper">
  <section class="content-header">
    <h1>Dashboard</h1>
    <h5 style="padding-left:1px;">Welcome to Never Say Old Dashboard</h5>
  </section>
  <section class="content">
    <div class="row">
      <?php if ($this->session->userdata('role_id') == '17') { ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-star"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Event</span>
              <span class="info-box-number"><?= $totalevent[0]['total'] ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-bar-chart"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Pendaftar yang perlu dikonfirmasi</span>
              <span class="info-box-number"><?= $totalregister[0]['totalregister'] ?></span>
              <a href="<?= base_url('eventregister') ?>">Lihat Disini !</a>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-cubes"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Merchandise</span>
              <span class="info-box-number"><?= $totalmerchandise[0]['totalmerchandise'] ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Team Bergabung</span>
              <span class="info-box-number"><?= $totalteam[0]['totalteam'] ?> Team</span>
            </div>
          </div>
        </div>
      <?php } else { ?>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-archive"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Proyek</span>
              <span class="info-box-number"><?= $Totalproyek[0]['total'] ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Rata Rata Total Harga Semua Proyek</span>
              <span class="info-box-number"> Rp <?= number_format($AVGReturn[0]['AVG'], 0, ',', '.')  ?> ,- </span>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Banyak Investor Bergabung</span>
              <span class="info-box-number"><?= $InvestorJOIN[0]['InvestorJOIN'] ?></span>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">5 Data Event Terbaru</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped datatable">
                <thead>
                  <tr class="bg-success">
                    <th style="width:20px">No</th>
                    <th>Judul Event</th>
                    <th>Nomor Petanggung Jawab</th>
                    <th>Tgl Event Dimulai</th>
                    <th>Tgl Event Berakhir</th>
                    <th>Status Event</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($tbl_event as $row) {
                    $file =  $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'tbl_event'));
                    ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><?= $row['title'] ?></td>
                      <td><?= $row['phone'] ?></td>
                      <td><?= date('d M Y', strtotime($row['tgleventStart'])) ?></td>
                      <td><?= date('d M Y', strtotime($row['tgleventEnd'])) ?></td>
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
                    </tr>
                  <?php $i++;
                  } ?>
                </tbody>
              </table>
            </div>
            <div class="box-footer" align="center">
              <a href="<?= base_url('team') ?>">
                <button type="button" class="btn btn-sm btn-sm btn-info"><i class="fa fa-eye"></i> Lihat Semua Team</button>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Data Team Terbaru</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <ul class="users-list clearfix">
              <?php foreach ($team as $row_team) {
                $rowraider = $this->mymodel->selectWithQuery("SELECT count(id) as rowraider from tbl_raider WHERE team_id = '" . $row_team['id'] . "'");
                ?>
                <li>
                  <a href="<?= base_url('team/view/') . $row_team['id'] ?>" style="color:black">
                    <?php $image_src = $this->mymodel->selectDataone('file', array('table' => 'tbl_team', 'table_id' => $row_team['id'])); ?>
                    <?php if ($image_src != NULL) { ?>
                    <img style="height: 50px; width: 50px; object-fit: cover; display: inline;" src="<?= $image_src['url'] ?>" alt="User Image">
                    <?php } else { ?>
                    <img style="height: 50px; width: 50px; object-fit: cover; display: inline;" src="https://dev.karyastudio.com/nso_mobile/webfiles/team/team_default.png" alt="User Image">
                    <?php } ?>
                    <br>
                    <?= strlen($row_team["name"]) > 10 ? substr($row_team["name"], 0, 10) . "..." : $row_team["name"] ?>
                    <br>
                    <small>Total Rider : <?= $rowraider[0]['rowraider'] ?></small>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </div>
          <div class="box-footer" align="center">
            <a href="<?= base_url('team') ?>">
              <button type="button" class="btn btn-sm btn-sm btn-info"><i class="fa fa-eye"></i> Lihat Semua Team</button>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">5 Wisata Terbaru</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped datatable">
                <thead>
                  <tr class="bg-success">
                    <th style="width:20px">No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Tanggal Dimulai</th>
                    <th>Tanggal Selesai</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($tbl_wisata as $row) { ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><img src="<?= $file['url'] ?>" width="50px" height="50px"></td>
                      <td><?= $row['title'] ?></td>
                      <td><?= date('d M Y', strtotime($row['tglwisataStart'])) ?></td>
                      <td><?= date('d M Y', strtotime($row['tglwisataEnd'])) ?></td>
                    </tr>
                  <?php $i++;
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="box-footer" align="center">
            <a href="<?= base_url('wisata') ?>">
              <button type="button" class="btn btn-sm btn-sm btn-info"><i class="fa fa-eye"></i> Lihat Semua Wisata</button>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">5 Blog / Informasi Terbaru</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped datatable">
                <thead>
                  <tr class="bg-success">
                    <th style="width:20px">No</th>
                    <th>Gambar</th>
                    <th>Judul Blog / Informasi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($tbl_blog as $row) {
                    $file =  $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'tbl_blog'));
                    ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><img src="<?= $file['url'] ?>" width="50px" height="50px"></td>
                      <td><?= $row['title'] ?></td>
                    </tr>
                  <?php $i++;
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="box-footer" align="center">
            <a href="<?= base_url('blog') ?>">
              <button type="button" class="btn btn-sm btn-sm btn-info"><i class="fa fa-eye"></i> Lihat Semua Blog</button>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">5 Kategori Gallery Terbaru</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped datatable">
                <thead>
                  <tr class="bg-success">
                    <th style="width:20px">No</th>
                    <th>Gambar</th>
                    <th>Nama Kategori</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($master_imagegroup as $row) {
                    $file =  $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'master_gallery'));
                    ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><img src="<?= $file['url'] ?>" width="50px" height="50px"></td>
                      <td><?= $row['value'] ?></td>
                    </tr>
                  <?php $i++;
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="box-footer" align="center">
            <a href="<?= base_url('master/imagegroup') ?>">
              <button type="button" class="btn btn-sm btn-sm btn-info"><i class="fa fa-eye"></i> Lihat Semua Kategori Gallery</button>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">5 Merchandise Terbaru</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped datatable">
                <thead>
                  <tr class="bg-success">
                    <th style="width:20px">No</th>
                    <th>Gambar</th>
                    <th>Judul Merchandise</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($tbl_merchandise as $row) {
                    $file =  $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'tbl_merchandise'));
                    ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><img src="<?= $file['url'] ?>" width="50px" height="50px"></td>
                      <td><?= $row['title'] ?></td>
                    </tr>
                  <?php $i++;
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="box-footer" align="center">
            <a href="<?= base_url('merchandise') ?>">
              <button type="button" class="btn btn-sm btn-sm btn-info"><i class="fa fa-eye"></i> Lihat Semua Merchandise</button>
            </a>
          </div>
        </div>
      </div>
    </div>
</div>
</section>
</div>