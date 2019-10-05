<div class="content-wrapper">
	<section class="content-header">
		<h1> Team  <small><?= $tbl_team['name']?></small> </h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Team</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xm-12">
				<input type="hidden" name="ids" value="<?= $tbl_event_register['id'] ?>">
				<div class="col-md-4">  
					<div class="form-group">
						<center>
							<img src="<?= $file_team['url'] ?>" style="width: 500px; height: 400px; border-radius: 20px" class="img img-thumbnail">
							<h3><?= $tbl_team['name']?> <?php if ($tbl_team['verificacion'] == 'ENABLE') {
								echo '<i class="fa fa-check-circle" style="color: #3b8dbc"> </i>';
							} ?><br><small><?= $tbl_team['email']?></small></h3>
						</center>       
					</div> 
					<div class="box">
						<div class="box-body">
							<h4>Data Lainya : </h4>
							<div class="row">
								<div class="col-md-12"> 
									<div class="box-body">
										<div class="row">
											<div class="col-md-8"> 
												<div class="form-group">
													<label>Nomor Whatsapp</label>
													<input type="text" class="form-control" value="<?= $tbl_team['nowa']?>" readonly>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label> Hubungi Melalui</label>
													<a href="#" target="_blank">
														<button type="button" class="btn btn-sm btn-success btn-block"><i class="fa fa-whatsapp"></i> Whatsapp</button>
													</a> 
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12"> 
									<div class="box-body">
										<div class="row">
											<div class="col-md-6"> 
												<div class="form-group">
													<label>Kota Team</label>
													<input type="text" class="form-control" value="<?= $tbl_team['kota']?>" readonly>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Alamat Lengkap Team</label>
													<textarea class="form-control" readonly rows="5px"><?= $tbl_team['alamat'] ?></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>   
				</div>  
				<div class="col-md-8">     
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Data Raider</h3>
						</div>
						<div class="box-body">
							<div class="table-responsive">
								<table id="datatable" class="table table-bordered table-striped" >
									<thead>
										<tr class="bg-success">
											<th>No</th>
											<th>Nama Team</th>
											<th>Image</th>
											<th>Nama</th>
											<th>Alamat</th>
											<th>Kota</th>
											<th>Nomor Start</th>
											<th>Nama Jersey</th>
											<th>Ukuran Jersey</th>
											<th>Motor</th>
											<th>Nomor Whatsapp</th>
											<th>Verifikasi</th>
											<th>Status</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1;
										foreach ($tbl_raider as $row) { 
											$photo = $this->mymodel->selectDataone('file', array('table' => 'tbl_raider', 'table_id' => $row['id'])); 
											$team = $this->mymodel->selectDataone('tbl_team',  array('id' => $row['team_id'])); 
											$motor = $this->mymodel->selectDataone('master_motor',  array('id' => $row['motor_id']));?>
											<tr>
												<td><?= $i ?></td>
												<td><?= $team['name'] ?></td>
												<td align="center"><img src="<?= $photo['url']?>" width="100px" height="100px" ></td>
												<td>
													<?= $row['name'] ?>
													<small><?= $row['email'] ?></small>
												</td>
												<td><?= $row['alamat'] ?></td>
												<td><?= $row['kota'] ?></td>
												<td><?= $row['nostart'] ?></td>
												<td><?= $row['namajersey'] ?></td>
												<td><?= $row['ukuran_jersey'] ?></td>
												<td><?= $motor['value'] ?></td>
												<td><?= $row['nowa'] ?></td>
												<td>
													<?php if($row['verificacion']=='ENABLE'){?>
														<p> Terverifikasikan </p>
														<a href="<?= base_url('team/raiderverificacion/').$row['id'].'/DISABLE/'.$tbl_team['id'] ?>">
															<button type="button" class="btn btn-sm btn-sm btn-danger">
																<i class="fa fa-ban"></i> LEPAS VERIFIKASI
															</button>
														</a>
													<?php }else { ?>
														<p> Belum Terverifikasi </p>
														<a href="<?= base_url('team/raiderverificacion/').$row['id'].'/ENABLE/'.$tbl_team['id'] ?>">
															<button type="button" class="btn btn-sm btn-sm btn-primary">
																<i class="fa fa-check-circle"></i> VERIFIKASI
															</button>
														</a>
													<?php } ?>
												</td>
												<td>
													<?php if($row['status']=='ENABLE'){?>
														<a href="<?= base_url('team/raiderstatus/').$row['id'].'/DISABLE/'.$tbl_team['id'] ?>">
															<button type="button" class="btn btn-sm btn-sm btn-success">
																<i class="fa fa-check-circle"></i> ENABLE
															</button>
														</a>
													<?php }else { ?>
														<a href="<?= base_url('team/raiderstatus/').$row['id'].'/ENABLE/'.$tbl_team['id'] ?>">
															<button type="button" class="btn btn-sm btn-sm btn-danger">
																<i class="fa fa-ban"></i> DISABLE
															</button>
														</a>
													<?php } ?>
												</td>
												<td>
													<div class="btn-group">
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
		</div>
		<div class="row" align="center">
			<a href="<?= base_url('team')?>">
				<button type="button" class="btn btn-sm btn-sm btn-info"><i class="fa fa-arrow-left"></i> Kembali</button>
			</a>
		</div>
	</div>
</section>
</div>