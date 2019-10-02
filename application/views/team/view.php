<div class="content-wrapper">
	<section class="content-header">
		<h1> Tim <small><?= $tim['name']?></small> </h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Tim</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xm-12">
				<div class="show_error"></div>
				<input type="hidden" name="ids" value="<?= $tbl_investor['id'] ?>">
				<div class="col-md-4">  
					<div class="form-group">
						<center>
							<?php
							if($file['dir']!=""){
								$types = explode("/", $file['mime']);
								if($types[0]=="image"){
									?>
									<img src="<?= base_url($file['dir']) ?>" style="width: 250px; height: 250px; border-radius: 50%" class="img img-thumbnail">
									<br> 
								<?php }else{ ?>

									<i class="fa fa-file fa-5x text-danger"></i>
									<br>
									<a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>
									<br>
									<br>
								<?php } ?>
							<?php } ?>

							<?php if ($user['phone']) { ?>
								<br>
								<a href="https://api.whatsapp.com/send?phone=<?=$user['phone']?>&text=Permisi Saudara/Saudari <?= $user['name']?>, Saya sebagai admin AGNOV.ID (https://agnov.id/), Ingin Mempertanyakan Bahwa...."target="_blank">
									<button type="button" class="btn btn-sm btn-success"><i class="fa fa-whatsapp"></i> Hubungi Whatsapp</button>
								</a>
							<?php } ?>
						</center>       
					</div>    
				</div>  
				<div class="col-md-8">        
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Data Investor</h3>
						</div>
						<div class="box-body">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab_info" data-toggle="tab" aria-expanded="false">Info</a></li>
									<li class=""><a href="#tab_contact" data-toggle="tab" aria-expanded="false">Kontak</a></li>
									<li class=""><a href="#tab_dana" data-toggle="tab" aria-expanded="false">Sumber Dana</a></li>
									<li class=""><a href="#tab_rek" data-toggle="tab" aria-expanded="false">Rekerning</a></li>
									<li class=""><a href="#tab_doc" data-toggle="tab" aria-expanded="false">Dokumen</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_info">
										<div class="row">
											<div class="col-md-12"> 
												<div class="box-body">
													<div class="row">
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Nama Lengkap</label>
																<input type="text" name="dt[name]" class="form-control" placeholder="Masukan Nama Lengkap" value="<?= $user['name']?>" readonly>
															</div>
														</div>
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Jenis Kelamin</label>
																<?php if($user['jk']) {?>
																	<select class="form-control select2" name="dt[jk]" style="width: 100%" disabled>
																		<option value="">--Pilih Jenis Kelamin--</option>
																		<option value="L" <?php if($user['jk'] == 'L'){echo "selected";} ?>>Laki Laki</option>
																		<option value="P" <?php if($user['jk'] == 'P'){echo "selected";} ?>>Perempuan</option>
																	</select>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Warga Negara</label>
																<?php if($user['wrg_negara']) {?>
																	<select class="form-control select2" name="dt[wrg_negara]" style="width: 100%" disabled>
																		<option value="">--Pilih Warga Negara--</option>
																		<option value="WNI" <?php if($user['wrg_negara'] == 'WNI'){echo "selected";} ?>>WNI</option>
																		<option value="WNA" <?php if($user['wrg_negara'] == 'WNA'){echo "selected";} ?>>WNA</option>
																	</select>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Agama</label>
																<?php if($user['agama_id']) {?>
																	<select class="form-control select2" name="dt[agama_id]"  style="width: 100%" disabled>
																		<option value="">--Pilih Agama--</option>
																		<?php $tbl_agama = $this->mymodel->selectData("tbl_agama");
																		foreach ($tbl_agama as $key => $value) {?>
																			<option value="<?= $value['id'] ?>" <?php if($user['agama_id'] == $value['id']){echo "selected"; } ?>><?= $value['value'] ?></option>
																		<?php } ?>
																	</select>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Tempat Lahir</label>
																<?php if($user['tpt_lahir']) {?>
																	<input type="text" name="dt[tpt_lahir]" class="form-control" placeholder="Masukan Tempat Lahir" value="<?= $user['tpt_lahir']?>" readonly>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Tanggal Lahir</label>
																<?php if($user['tgl_lahir']) {?>
																	<input type="text" name="dt[tgl_lahir]" class="form-control" id="datepicker" placeholder="Masukan Tanggal Lahir" value="<?= date("d-m-Y", strtotime($user['tgl_lahir'])); ?>" readonly>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12"> 
															<div class="form-group">
																<label>Status Perkawinan</label>
																<?php if($user['status_kawin']) {?>
																	<select class="form-control select2" name="dt[status_kawin]" style="width: 100%" disabled>
																		<option value="">--Pilih Status Perkawinan--</option>
																		<option value="L" <?php if($user['jk'] == 'L'){echo "selected";} ?>>Laki Laki</option>
																		<option value="P" <?php if($user['jk'] == 'P'){echo "selected";} ?>>Perempuan</option>
																	</select>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab_contact">
										<div class="row">
											<div class="col-md-12"> 
												<div class="box-body">
													<div class="row">
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Email</label>
																<input type="text" name="dt[email]" class="form-control" placeholder="Masukan Email" value="<?= $user['email']?>" readonly>
															</div>
														</div>
														<div class="col-md-6"> 
															<div class="form-group">
																<label>No Hp</label>
																<?php if($user['phone']) {?>
																	<input type="number" name="dt[phone]" class="form-control" placeholder="Masukan Telephone" value="<?= $user['phone']?>" readonly>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12"> 
															<div class="form-group">
																<label>Alamat</label>
																<?php if($user['alamat']) {?>
																	<textarea name="dt[alamat]" class="form-control" placeholder="Masukan Alamat" readonly><?= $user['alamat'] ?></textarea>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Kelurahan</label>
																<?php if($user['kelurahan']) {?>
																	<input type="text" name="dt[kelurahan]" class="form-control" placeholder="Masukan Kelurahan" value="<?= $user['kelurahan']?>" readonly>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
														<div class="col-md-6">  
															<div class="form-group">
																<label>Kecamatan</label>
																<?php if($user['kecamatan']) {?>
																	<input type="text" name="dt[kecamatan]" class="form-control" placeholder="Masukan Kecamatan" value="<?= $user['kecamatan']?>" readonly>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Provinsi</label>
																<?php if($user['provinsi_id']) {?>
																	<select class="form-control select2" name="dt[provinsi_id]" style="width: 100%" disabled>
																		<option value="">--Pilih Provinsi--</option>
																		<?php 
																		$tbl_provinsi = $this->mymodel->selectData("tbl_provinsi"); foreach ($tbl_provinsi as $key => $value) 
																		{ ?>
																			<option value="<?= $value['id'] ?>" <?php if($user['provinsi_id'] == $value['id']){ echo "selected"; } ?>><?= $value['value'] ?></option>
																		<?php } ?>
																	</select>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
														<div class="col-md-6">  
															<div class="form-group">
																<label>Kota</label>
																<?php if($user['kota_id']) {?>
																	<select class="form-control select2" name="dt[kota_id]" style="width: 100%" disabled>
																		<option value="">--Pilih Kota--</option>
																		<?php 
																		$tbl_kota = $this->mymodel->selectData("tbl_kota"); foreach ($tbl_kota as $key => $value) 
																		{ ?>
																			<option value="<?= $value['id'] ?>" <?php if($user['kota_id'] == $value['id']){ echo "selected"; } ?>><?= $value['value'] ?></option>
																		<?php } ?>
																	</select>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Kode Pos</label>
																<?php if($user['kode_pos']) {?>
																	<input type="text" name="dt[kode_pos]" class="form-control" placeholder="Masukan Kode Pos" value="<?= $user['kode_pos']?>" readonly>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab_dana">
										<div class="row">
											<div class="col-md-12"> 
												<div class="box-body">
													<div class="row">
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Sumber Dana</label>
																<?php if($user['sumberdana_id']) {?>
																	<select class="form-control select2" name="dt[sumberdana_id]" style="width: 100%" disabled>
																		<option value="">--Pilih Sumber Dana--</option>
																		<?php 
																		$tbl_sumberdana = $this->mymodel->selectData("tbl_sumberdana"); foreach ($tbl_sumberdana as $key => $value) 
																		{ ?>
																			<option value="<?= $value['id'] ?>" <?php if($user['sumberdana_id'] == $value['id']){ echo "selected"; } ?> ><?= $value['value'] ?></option>
																		<?php } ?>
																	</select>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
														<div class="col-md-6">  
															<div class="form-group">
																<label>Pekerjaan</label>
																<?php if($user['pekerjaan_id']) {?>
																	<select class="form-control select2" name="dt[pekerjaan_id]" style="width: 100%" disabled>
																		<option value="">--Pilih Pekerjaan --</option>
																		<?php 
																		$tbl_pekerjaan = $this->mymodel->selectData("tbl_pekerjaan"); foreach ($tbl_pekerjaan as $key => $value) 
																		{ ?>
																			<option value="<?= $value['id'] ?>" <?php if($user['pekerjaan_id'] == $value['id']){ echo "selected"; } ?> ><?= $value['value'] ?></option>
																		<?php } ?>
																	</select>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Penghasilan Bulanan</label>
																<?php if($user['gaji_id']) {?>
																	<select class="form-control select2" name="dt[gaji_id]" style="width: 100%" disabled>
																		<option value="">--Pilih Penghasilan Bulanan--</option>
																		<?php 
																		$tbl_gaji = $this->mymodel->selectData("tbl_gaji"); foreach ($tbl_gaji as $key => $value) 
																		{ ?>
																			<option value="<?= $value['id'] ?>" <?php if($user['gaji_id'] == $value['id']){ echo "selected"; } ?> ><?= $value['value'] ?></option>
																		<?php } ?>
																	</select>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab_rek">
										<div class="row">
											<div class="col-md-12"> 
												<div class="box-body">
													<div class="row">
														<div class="col-md-6"> 
															<div class="form-group">
																<label>Bank</label>
																<?php if($user['bank_id']) {?>
																	<select class="form-control select2" name="dt[bank_id]" style="width: 100%" disabled>
																		<option value="">--Pilih Bank--</option>
																		<?php 
																		$tbl_bank = $this->mymodel->selectData("tbl_bank"); foreach ($tbl_bank as $key => $value) 
																		{ ?>
																			<option value="<?= $value['id'] ?>"<?php if($user['bank_id'] == $value['id']){ echo "selected"; } ?> ><?= $value['value'] ?></option>
																		<?php } ?>
																	</select>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
														<div class="col-md-6">  
															<div class="form-group">
																<label>Cabang</label>
																<?php if($user['bank_cabang']) {?>
																	<input type="text" name="dt[bank_cabang]" class="form-control" placeholder="Masukan Cabang Bank" value="<?= $user['bank_cabang']?>" readonly>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div> 
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">  
															<div class="form-group">
																<label>No Rekening</label>
																<?php if($user['no_rek']) {?>
																	<input type="text" name="dt[no_rek]" class="form-control" placeholder="Masukan No Rekening" value="<?= $user['no_rek']?>" readonly>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
														<div class="col-md-6">  
															<div class="form-group">
																<label>Atas Nama</label>
																<?php if($user['atas_nama']) {?>
																	<input type="text" name="dt[atas_nama]" class="form-control" placeholder="Masukan Atas Nama" value="<?= $user['atas_nama']?>" readonly>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab_doc">
										<div class="row">
											<div class="col-md-12"> 
												<div class="box-body">
													<div class="row">
														<div class="col-md-6">  
															<div class="form-group">
																<label>No KTP</label>
																<?php if($user['no_ktp']) {?>
																	<input type="text" name="dt[no_ktp]" class="form-control" placeholder="Masukan No KTP" value="<?= $user['no_ktp']?>" readonly>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
														<div class="col-md-6">  
															<div class="form-group">
																<label>No NPWP</label>
																<?php if($user['no_npwp']) {?>
																	<input type="text" name="dt[no_npwp]" class="form-control" placeholder="Masukan No NPWP" value="<?= $user['no_npwp']?>" readonly>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
													</div>
													<div class="row"  align="center">
														<div class="col-md-6"> 
															<div class="form-group">
																<label for="exampleInputEmail1">Foto KTP</label>
																<br>
																<?php if($ktp) { ?>
																	<img src="<?= base_url().$ktp['dir']?>" width="250px" height="250px" id="preview_ktp">
																	<br><br>
																	<a href="<?= base_url('webfile/investor/doc/').$ktp['name']?>" target="_blank">
																		<button type="button" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Lihat Gambar</button>
																	</a>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
															</div>
														</div>
														<div class="col-md-6">  
															<div class="form-group">
																<label for="exampleInputEmail1">Foto NPWP</label>
																<br>
																<?php if($npwp) { ?>
																	<img src="<?= base_url().$npwp['dir']?>" width="250px" height="250px" id="preview_npwp">
																	<br><br>
																	<a href="<?= base_url('webfile/investor/doc/').$npwp['name']?>" target="_blank">
																		<button type="button" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Lihat Gambar</button>
																	</a>
																<?php } else { ?>
																	<p class='help-block'><i>Belum Tersedia</i></p>
																<?php } ?>
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
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xm-12">
				<div class="col-md-12">   
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Data Investasi</h3>
						</div>
						<div class="box-body">
							<div class="table-responsive">
								<table id="datatable" class="table table-bordered table-striped" >
									<thead>
										<tr class="bg-success">
											<th>No</th>
											<th>Code</th>
											<th>Project</th>
											<th>Banyak Unit</th>
											<th>Harga per Unit</th>
											<th>Total Harga</th>
											<th>Tgl Pembayaran</th>
											<th>Status Pembayaran</th>
											<th>Bukti Pembayaran</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; foreach ($tbl_project_invest as $row_invest) {
											$project =  $this->mymodel->selectDataOne('tbl_project', array('id' => $row_invest['project_id'] ));
											$investor =  $this->mymodel->selectDataOne('tbl_investor', array('id' => $row_invest['investor_id'] ));
											$file =  $this->mymodel->selectDataOne('file', array('table_id' => $investor['id'], 'table' => 'tbl_investor')) ;
											$file_invest =  $this->mymodel->selectDataOne('file', array('table_id' => $row_invest['id'], 'table' => 'tbl_project_invest')) ;?>
											<tr>
												<td><?= $i ?></td>
												<td><b><?= $row_invest['code'] ?></b></td>
												<td>
													<a href="<?= base_url('admin/project/view/').$project['id'] ?>">
														<?= $project['title'] ?>
													</a>
												</td>
												<td><?= $row_invest['unit'] ?></td>
												<td><b>Rp <?= number_format($project['harga'],0,',','.') ?></b></td>
												<td><b>Rp <?= number_format($row_invest['total_harga'],0,',','.') ?>,-</b></td>
												<td>
													<?php if (!$row_invest['tgl_pembayaran']) { 
														echo "<p class='help-block'><i>Belum Tersedia</i></p>";
													} else {
														echo date('Y-m-d H:i:s', strtotime($row_invest['tgl_pembayaran']));
													}?>
												</td>
												<td align="center">
													<?php if (!$row_invest['tgl_pembayaran']) { ?>
														<p class='help-block'><i>Invoice Ini Belum Terbayar</i></p>
														<hr>
														<div class="row" align="center">
															<button type="button" class="btn btn-send btn-approve btn-sm btn-sm btn-primary" onclick="approve(<?=$row_invest['id']?>)"><i class="fa fa-check-circle"></i></button>
															<button type="button" class="btn btn-send btn-reject btn-sm btn-sm btn-danger" onclick="reject(<?=$row_invest['id']?>)"><i class="fa fa-ban"></i></button>
														</div>
													<?php  } else {
														if ($row_invest['status_pembayaran'] == 'WAITING') {
															echo '<small class="label bg-yellow"><i class="fa fa-warning"> </i> Menunggu Dikonfirmasi </small>
															<hr>
															<div class="row" align="center">
															<button type="button" class="btn btn-send btn-approve btn-sm btn-sm btn-primary" onclick="approve('.$row_invest['id'].')"><i class="fa fa-check-circle"></i></button>
															<button type="button" class="btn btn-send btn-reject btn-sm btn-sm btn-danger" onclick="reject('.$row_invest['id'].')"><i class="fa fa-ban"></i></button>
															</div>';
														} else if($row_invest['status_pembayaran'] == "APPROVE") {
															echo '<small class="label bg-green"><i class="fa fa-check"> </i> Di Terima </small>';

														}else if($row_invest['status_pembayaran'] == "REJECT") {
															echo '<small class="label bg-red"><i class="fa fa-ban"> </i> Di Tolak </small>';

														}else if($row_invest['status_pembayaran'] == "EXPIRED") {
															echo '<small class="label bg-red"><i class="fa fa-ban"> </i> Kadarluasa</small>';

														}else if($row_invest['status_pembayaran'] == "WAITING PAY") {
															echo '<small class="label bg-yellow"><i class="fa fa-warning"> </i> Menunggu Pembayaran </small>';
														}
													} ?>
												</td>
												<td align="center">
													<?php if (!$file_invest) { ?>
														<p class='help-block'><i>Belum Tersedia</i></p>
													<?php  }else { ?>
														<div class="row" align="center">
															<a href="<?= base_url().$file_invest['dir']?>" target="_blank">
																<button type="button" class="btn btn-send btn-approve btn-sm btn-sm btn-info">
																	<i class="fa fa-eye"></i> Bukti
																</button>
															</a>
														</div>
													<?php } ?>
												</td>
												<td>
													<div class="btn-group">
														<a href="<?= base_url('admin/investasi/view/').$row_invest['id']?>">
															<button type="button" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></button></div>
														</a>
														<a href="<?= base_url('invoice/payment/').$row_invest['code']?>" target="_blank">
															<button type="button" class="btn btn-sm btn-sm btn-primary"><i class="fa fa-print"></i></button>
														</a>
													</div>
												</td>
											</tr>
											<?php $i++; }  ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" align="center">
				<a href="<?= base_url('admin/investor')?>">
					<button type="button" class="btn btn-sm btn-sm btn-info"><i class="fa fa-arrow-left"></i> Kembali</button>
				</a>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">

	function approve(id) {
		$.ajax({
			type: "POST",
			url: "<?= base_url('admin/investasi/approve/') ?>"+id,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend : function(){
				$(".btn-send").addClass("disabled").html("<i class='fa fa-spinner'></i>").attr('disabled',true);
				$(".show_error").slideUp().html("");
			},
			success: function(response, textStatus, xhr) {
				var str = response;
				if (str.indexOf("success") != -1){
					$(".show_error").hide().html(response).slideDown("fast");
					$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> ').attr('disabled',false);
					$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> ').attr('disabled',false);
					location.reload();
				}else{
					setTimeout(function(){
						$("#modal-delete").modal('hide');
					}, 1000);
					$(".show_error").hide().html(response).slideDown("fast");
					$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> ').attr('disabled',false);
					$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> ').attr('disabled',false);
				}
			},
			error: function(xhr, textStatus, errorThrown) {
			}
		});
	}

	function reject(id) {
		$.ajax({
			type: "POST",
			url: "<?= base_url('admin/investasi/reject/') ?>"+id,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend : function(){
				$(".btn-send").addClass("disabled").html("<i class='fa fa-spinner'></i>").attr('disabled',true);
				$(".show_error").slideUp().html("");
			},
			success: function(response, textStatus, xhr) {
				var str = response;
				if (str.indexOf("success") != -1){
					$(".show_error").hide().html(response).slideDown("fast");
					$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> ').attr('disabled',false);
					$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> ').attr('disabled',false);
					location.reload();
				}else{
					setTimeout(function(){
						$("#modal-delete").modal('hide');
					}, 1000);
					$(".show_error").hide().html(response).slideDown("fast");
					$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> ').attr('disabled',false);
					$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> ').attr('disabled',false);
				}
			},
			error: function(xhr, textStatus, errorThrown) {
			}
		});
	}

</script>