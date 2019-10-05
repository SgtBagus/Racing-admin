<div class="content-wrapper">
	<section class="content-header">
		<h1> Pendaftar Event  <small><?= $tbl_event['title']?></small> </h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Tim</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xm-12">
				<input type="hidden" name="ids" value="<?= $tbl_event_register['id'] ?>">
				<div class="col-md-4">  
					<div class="form-group">
						<center>
							<img src="<?= $file_event['url'] ?>" style="width: 550px; height: 350px; border-radius: 20px" class="img img-thumbnail">
							<br>
							<br>
							<?php
							if ($tbl_event_register['approve'] == 'WAITING') {
								echo '<small class="label bg-yellow"><i class="fa fa-warning"> </i> Menunggu Dikonfirmasi </small>
								<br>
								<br>
								<div class="row" align="center">
								<button type="button" class="btn btn-send btn-approve btn-sm btn-sm btn-primary" onclick="approve('.$tbl_event_register['id'].')"><i class="fa fa-check-circle"></i> Terima Pendaftaran</button>
								<button type="button" class="btn btn-send btn-reject btn-sm btn-sm btn-danger" onclick="reject('.$tbl_event_register['id'].')"><i class="fa fa-ban"></i> Tolak Pendaftaran</button>
								</div>';
							} else if($tbl_event_register['approve'] == "APPROVE") {
								echo '<small class="label bg-green"><i class="fa fa-check"> </i> Pendaftaran Di Terima </small>
								<br>
								<br>
								<div class="row" align="center">
								<button type="button" class="btn btn-send btn-approve btn-sm btn-sm btn-success" onclick="finish('.$tbl_event_register['event_id'].')"><i class="fa fa-check-circle"></i> Event Selesai</button>
								<button type="button" class="btn btn-send btn-reject btn-sm btn-sm btn-danger" onclick="cancel('.$tbl_event_register['event_id'].')"><i class="fa fa-ban"></i> Event Dibatalkan</button>
								</div>';
							}else if($tbl_event_register['approve'] == "REJECT") {
								echo '<small class="label bg-red"><i class="fa fa-ban"> </i> Pendaftaran Di Tolak </small>';
							}else if($tbl_event_register['approve'] == "FINISH") {
								echo '<small class="label bg-green"><i class="fa fa-check"> </i> Event Selesai </small>';
							}else if($tbl_event_register['approve'] == "CANCEL") {
								echo '<small class="label bg-red"><i class="fa fa-ban"> </i> Event Dibatalkan</small>';
							}
							?>
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
													<input type="text" class="form-control" value="<?= $tbl_event['title']?>" readonly>
												</div>
											</div>
											<div class="col-md-6"> 
												<div class="row">
													<div class="col-md-8"> 
														<div class="form-group">
															<label>Nomor Petanggung Jawab Event</label>
															<input type="text" class="form-control" value="<?= $tbl_event['phone']?>" readonly>
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
											<div class="col-md-6"> 
												<div class="form-group">
													<label>Tanggal Event</label>
													<input type="text" class="form-control" value="<?= $tbl_event['tglevent']?>" readonly>
												</div>
											</div>
											<div class="col-md-6"> 
												<div class="row">
													<div class="col-md-6"> 
														<div class="form-group">
															<label>Minim Raider</label>
															<input type="text" class="form-control" value="<?= $tbl_event['minraider']?>" readonly>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Maximal Raider</label>
															<input type="text" class="form-control" value="<?= $tbl_event['maxraider']?>" readonly>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-12"> 
												<div class="row">
													<div class="col-md-6"> 
														<div class="form-group">
															<label>Kota Event</label>
															<input type="text" class="form-control" value="<?= $tbl_event['kota']?>" readonly>
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
				<div class="col-md-12">   
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Data Team</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<center>
									<img src="<?= $file_team['url'] ?>" style="width: 200px; height: 200px; border-radius: 20px" class="img img-thumbnail">
									<br>
									<h4><b><?= $tbl_team['name'] ?></b></h4>
								</center>        
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="col-md-12">   
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Data Manager</h3>
						</div>
						<div class="box-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped" >
									<thead>
										<tr class="bg-success">
											<th>No</th>
											<th></th>
											<th>Nama</th>
											<th>Alamat</th>
											<th>Phone</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; foreach ($tbl_manager as $row_manager) { 
											$filemanager = $this->mymodel->selectDataone('file', array('table_id' => $row_manager['id'], 'table' => 'tbl_manager')); ?>
											<tr>
												<td><?= $i ?></td>
												<td>
													<img src="<?= $filemanager['url']?>" witdh="50px" height="50px" style="border-radius: 50%">
												</td>
												<td><?= $row_manager['name'] ?></td>
												<td><?= $row_manager['alamat'] ?></td>
												<td>
													<?= $row_manager['nowa'] ?><br>
													<a href="#" target="_blank">
														<button type="button" class="btn btn-sm btn-success btn-block"><i class="fa fa-whatsapp"></i> Whatsapp</button>
													</a> 
												</td>
											</tr>
											<?php $i++; }?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="col-md-12">   
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
												<th></th>
												<th>Nama</th>
												<th>Alamat</th>
												<th>Motor</th>
												<th>Phone</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1; foreach ($tbl_event_register_raider as $row_raider) { 
												$raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $row_raider['id']));
												$motor = $this->mymodel->selectDataone('master_motor', array('id' => $raider['motor_id']));  
												$fileraider = $this->mymodel->selectDataone('file', array('table_id' => $row_raider['id'], 'table' => 'tbl_raider')); ?>
												<tr>
													<td><?= $i ?></td>
													<td>
														<img src="<?= $fileraider['url']?>" witdh="50px" height="50px" style="border-radius: 50%">
													</td>
													<td>
														<?= $raider['name'] ?>  <?php if ($raider['verificacion'] == 'ENABLE') {
															echo '<i class="fa fa-check-circle" style="color: #3b8dbc"> </i>';
														} ?>
													</td>
													<td><?= $raider['alamat'] ?></td>
													<td><?= $motor['value'] ?></td>
													<td><?= $raider['nowa'] ?></td>
												</tr>
												<?php $i++;  }?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="col-md-12">   
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Tambah Catatan</h3>
								</div>
								<div class="box-body">
									<form action="<?=base_url('eventregister/addnote/').$tbl_event_register['id']?>" method="POST" id="notesumbit">
										<div class="show_error"></div>
										<div class="form-group">
											<textarea class="form-control" rows="5" name="note"><?=$tbl_event_register['note']?></textarea>
										</div>
										<button type="submit" class="btn btn-sm btn-sm btn-primary btn-send pull-right">
											<i class="fa fa-save"></i> Simpan
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row" align="center">
					<a href="<?= base_url('eventregister')?>">
						<button type="button" class="btn btn-sm btn-sm btn-info"><i class="fa fa-arrow-left"></i> Kembali</button>
					</a>
				</div>
			</section>
		</div>

		<script type="text/javascript">


			function approve(id) {
				$.ajax({
					type: "POST",
					url: "<?= base_url('eventregister/approve/') ?>"+id,
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
							$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> Terima Pendaftaran').attr('disabled',false);
							$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> Tolak Pendaftaran').attr('disabled',false);
							location.reload();
						}else{
							setTimeout(function(){
								$("#modal-delete").modal('hide');
							}, 1000);
							$(".show_error").hide().html(response).slideDown("fast");
							$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> Terima Pendaftaran').attr('disabled',false);
							$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> Tolak Pendaftaran').attr('disabled',false);
							location.reload();
						}
					},
					error: function(xhr, textStatus, errorThrown) {
					}
				});
			}


			function reject(id) {
				$.ajax({
					type: "POST",
					url: "<?= base_url('eventregister/reject/') ?>"+id,
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
							$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> Terima Pendaftaran').attr('disabled',false);
							$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> Tolak Pendaftaran').attr('disabled',false);
							location.reload();
						}else{
							setTimeout(function(){
								$("#modal-delete").modal('hide');
							}, 1000);
							$(".show_error").hide().html(response).slideDown("fast");
							$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> Terima Pendaftaran').attr('disabled',false);
							$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> Tolak Pendaftaran').attr('disabled',false);
							location.reload();
						}
					},
					error: function(xhr, textStatus, errorThrown) {
					}
				});
			}

			function finish(id) {
				$.ajax({
					type: "POST",
					url: "<?= base_url('eventregister/finish/') ?>"+id,
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
							$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> Terima Pendaftaran').attr('disabled',false);
							$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> Tolak Pendaftaran').attr('disabled',false);
							location.reload();
						}else{
							setTimeout(function(){
								$("#modal-delete").modal('hide');
							}, 1000);
							$(".show_error").hide().html(response).slideDown("fast");
							$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> Terima Pendaftaran').attr('disabled',false);
							$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> Tolak Pendaftaran').attr('disabled',false);
							location.reload();
						}
					},
					error: function(xhr, textStatus, errorThrown) {
					}
				});
			}

			function cancel(id) {
				$.ajax({
					type: "POST",
					url: "<?= base_url('eventregister/cancel/') ?>"+id,
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
							$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> Terima Pendaftaran').attr('disabled',false);
							$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> Tolak Pendaftaran').attr('disabled',false);
							location.reload();
						}else{
							setTimeout(function(){
								$("#modal-delete").modal('hide');
							}, 1000);
							$(".show_error").hide().html(response).slideDown("fast");
							$(".btn-approve").removeClass("disabled").html('<i class="fa fa-check-circle"></i> Terima Pendaftaran').attr('disabled',false);
							$(".btn-reject").removeClass("disabled").html('<i class="fa fa-ban"></i> Tolak Pendaftaran').attr('disabled',false);
							location.reload();
						}
					},
					error: function(xhr, textStatus, errorThrown) {
					}
				});
			}
			
			$(function () {

				$("#notesumbit").submit(function(){
					var form = $(this);
					var mydata = new FormData(this);
					$.ajax({
						type: "POST",
						url: form.attr("action"),
						data: mydata,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend : function(){
							$(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
							form.find(".show_error").slideUp().html("");
						},

						success: function(response, textStatus, xhr) {
							var str = response;
							if (str.indexOf("success") != -1){
								form.find(".show_error").hide().html(response).slideDown("fast");
								setTimeout(function(){
									window.location.href = "<?= base_url('event') ?>";
								}, 1000);

								$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled',false);
							}else{
								form.find(".show_error").hide().html(response).slideDown("fast");
								$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled',false);
							}
						},
						error: function(xhr, textStatus, errorThrown) {
							console.log(xhr);
							$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
							form.find(".show_error").hide().html(xhr).slideDown("fast");
						}
					});
					return false;
				});
			});

		</script>