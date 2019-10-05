 <div class="content-wrapper">
  <section class="content-header">
    <h1> Pendaftaran Event </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pendaftaran Event</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <div class="show_error"></div>
            <div class="table-responsive">
              <table id="datatable" class="table table-bordered table-striped" >
                <thead>
                  <tr class="bg-success">
                    <th>No</th>
                    <th>Event</th>
                    <th>Team</th>
                    <th>Approve</th>
                    <th>Tanggal Mendaftar</th>
                    <th>Tanggal Approve</th>
                    <th>Note</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1; foreach ($tbl_event_register as $row) {
                    $event = $this->mymodel->selectDataOne('tbl_event', array('id' => $row['event_id']));
                    $file_event =  $this->mymodel->selectDataOne('file', array('table_id' => $row['event_id'], 'table' => 'tbl_event'));
                    $team = $this->mymodel->selectDataOne('tbl_team', array('id' => $row['team_id']));
                    $file_team =  $this->mymodel->selectDataOne('file', array('table_id' => $row['team_id'], 'table' => 'tbl_team'));
                    ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td>
                        <img src="<?= $file_event['url'] ?>" width="150px" height="80px" style="border-radius: 20px">
                        <b> <?=  $event['title'] ?></b>
                        <br><br>
                        <a href="">
                          <button class="btn btn-sm btn-info btn-block">
                            <i class="fa fa-eye"></i>  Lihat Event
                          </button>
                        </a>
                      </td>
                      <td>
                        <img src="<?= $file_team['url'] ?>" width="150px" height="80px" style="border-radius: 20px">
                        <b> <?=  $team['name'] ?></b>
                        <br><br>
                        <a href="">
                          <button class="btn btn-sm btn-info btn-block">
                            <i class="fa fa-eye"></i>  Lihat Team
                          </button>
                        </a>
                      </td>
                      <td align="center">
                        <?php
                        if ($row['approve'] == 'WAITING') {
                          echo '<small class="label bg-yellow"><i class="fa fa-warning"> </i> Menunggu Dikonfirmasi </small>
                          <hr>
                          <div class="row" align="center">
                          <button type="button" class="btn btn-send btn-approve btn-sm btn-sm btn-primary" onclick="approve('.$row['id'].')"><i class="fa fa-check-circle"></i> Terima Pendaftaran</button>
                          <button type="button" class="btn btn-send btn-reject btn-sm btn-sm btn-danger" onclick="reject('.$row['id'].')"><i class="fa fa-ban"></i> Tolak Pendaftaran</button>
                          </div>';
                        } else if($row['approve'] == "APPROVE") {
                          echo '<small class="label bg-green"><i class="fa fa-check"> </i> Pendaftaran Di Terima </small>
                          <hr>
                          <div class="row" align="center">
                          <button type="button" class="btn btn-send btn-approve btn-sm btn-sm btn-success" onclick="finish('.$row['event_id'].')"><i class="fa fa-check-circle"></i> Event Selesai</button>
                          <button type="button" class="btn btn-send btn-reject btn-sm btn-sm btn-danger" onclick="cancel('.$row['event_id'].')"><i class="fa fa-ban"></i> Event Dibatalkan</button>
                          </div>';
                        }else if($row['approve'] == "REJECT") {
                          echo '<small class="label bg-red"><i class="fa fa-ban"> </i> Pendaftaran Di Tolak </small>';
                        }else if($row['approve'] == "FINISH") {
                          echo '<small class="label bg-green"><i class="fa fa-check"> </i> Event Selesai </small>';
                        }else if($row['approve'] == "CANCEL") {
                          echo '<small class="label bg-red"><i class="fa fa-ban"> </i> Event Dibatalkan</small>';
                        }
                        ?>
                      </td>
                      <td>
                        <?php if (!$row['created_at']) { 
                          echo "<p class='help-block'><i>Belum Tersedia</i></p>";
                        } else {
                          echo date('d-m-Y H:i:s', strtotime($row['created_at']));
                        }?>
                      </td>
                      <td>
                        <?php if (!$row['updated_at']) { 
                          echo "<p class='help-block'><i>Belum Tersedia</i></p>";
                        } else {
                          echo date('d-m-Y H:i:s', strtotime($row['updated_at']));
                        }?>
                      </td>
                      <td>
                        <?php if (!$row['note']) { 
                          echo "<p class='help-block'><i>Belum Tersedia</i></p>";
                        } else {
                          echo $row['note'];
                        }?>
                      </td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-info" onclick="view(<?= $row['id']?> )">
                            <i class="fa fa-eye"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                    <?php $i++; } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <script type="text/javascript">

    loadtable($("#select-status").val());

    function view(id) {
      location.href = "<?= base_url('eventregister/view/') ?>"+id;
    }


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
  </script>