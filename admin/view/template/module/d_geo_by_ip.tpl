<?php
/*
 *	location: admin/view
 */
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="form-inline pull-right">
				<?php if($stores){ ?>
				<select class="form-control" onChange="location='<?php echo $module_link; ?>&store_id='+$(this).val()">
					<?php foreach($stores as $store){ ?>
					<?php if($store['store_id'] == $store_id){ ?>
					<option value="<?php echo $store['store_id']; ?>" selected="selected" ><?php echo $store['name']; ?></option>
					<?php }else{ ?>
					<option value="<?php echo $store['store_id']; ?>" ><?php echo $store['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
				<?php } ?>
				<button id="save_and_stay" data-toggle="tooltip" title="<?php echo $button_save_and_stay; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
				<button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<h1><?php echo $heading_title; ?> <?php echo $version; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if (!empty($error['warning'])) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['warning']; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (!empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<ul  class="nav nav-tabs">
					<li class="active"><a href="#tab_setting" data-toggle="tab">
						<span class="fa fa-cog"></span>
						<?php echo $tab_setting; ?>
					</a></li>
					<?php if(!empty($setting['support'])){ ?>
					<li><a href="#tab_support" data-toggle="tab">
						<span class="fa fa-support"></span>
						<?php echo $tab_support; ?>
					</a></li>
					<?php } ?>
					<li><a href="#tab_instruction" data-toggle="tab">
						<span class="fa fa-graduation-cap"></span>
						<?php echo $tab_instruction; ?>
					</a></li>
				</ul>

				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
					<div class="tab-content">
						<div class="tab-pane active" id="tab_setting" >
							<div class="tab-body">

								<div class="form-group">
									<label class="col-sm-2 control-label" for="input_status"><?php echo $entry_status; ?></label>
									<div class="col-sm-10">
										<select name="<?php echo $id;?>_status" id="input_status" class="form-control">
											<?php if (${$id.'_status'}) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
											<?php } ?>
										</select>
									</div>
								</div><!-- //status -->
								<div class="form-group">
									<label class="col-sm-2 control-label" for="install_demo_data">Select country</label>
									<div class="col-sm-2" style="padding-right:20px">
										<select class="form-control" id="country_select">
											<option value=""></option>
											<?php foreach ($countries as $country) { ?>
											<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
											<?php } ?>
										</select>
										<div class="countries_list"></div>
									</div>
									<div class="col-sm-2">
										<a id="install_regions_data" class="btn btn-warning btn-block" disabled="disabled"><i class="fa fa-refresh"></i> Update regions</a>
									</div>
									<div class="col-sm-6">
										<div class="install-progress"></div>
									</div>
									<div class="col-sm-10 col-sm-offset-2">
										<div class="bs-callout bs-callout-info" style="margin-top:20px">
											<h4>Note!</h4>
											<p>The database of countries and regions is already installed. If your did any customizations with <strong><?php echo DB_PREFIX . "zone"; ?></strong> table, you should update it, it's needed for correct determination your IP address. It takes some time.</p>
										</div>
									</div>
								</div><!-- //install && info -->

								<div class="form-group">
									<label class="col-sm-2 control-label" for="input_select">Select geoservice</label>
									<div class="col-sm-10">
										<select class="form-control" name="<?php  echo $id; ?>_setting[geolocation_service]" id="geolocation_service">
											<?php foreach ($geolocation_services as $geo_service) { ?>
											<?php if($geo_service == $setting['geolocation_service']) { ?>
											<option value="<?php echo $geo_service ?>" selected="selected"><?php echo $geo_service ?></option>
											<?php } else { ?>
											<option value="<?php echo $geo_service ?>"><?php echo $geo_service ?></option>
											<?php } ?>
											<?php } ?>
										</select>
										<?php if (!empty($error['select'])) { ?>
										<div class="text-danger"><?php echo $error['select']; ?></div>
										<?php } ?>
									</div>
								</div><!-- //geolocation_service -->

								<?php if ($config_files) { ?>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="select_config"><?php echo $entry_config_files; ?></label>
									<div class="col-sm-10">
										<select id="select_config" name="<?php echo $id;?>_setting[config]"  class="form-control">
											<?php foreach ($config_files as $config_file) { ?>
											<option value="<?php echo $config_file; ?>" <?php echo ($config_file == $config)? 'selected="selected"' : ''; ?>><?php echo $config_file; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<?php } ?>
								<!-- //config -->

							</div>
						</div>
				</form>
						<div class="tab-pane" id="tab_support" >
							<div class="tab-body">
							</div>
						</div>
						<div class="tab-pane" id="tab_instruction" >
							<div class="tab-body"><?php echo $text_instruction; ?></div>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--

$(function () {
	$('body').on('click', '#install_regions_data', function(){
		var country_name = $('#country_select > option:selected').html();
		var country_id = $("#country_select").val();

		if(country_id != ''){
			swal({
				title: "Regions for " + country_name + "",
				text: "We are going to update regions, it takes some time... Go?",
				type: "info",
				confirmButtonColor: "#75a74d",
				confirmButtonText: "Yes, update!",
				showCancelButton: true
			}, function (isConfirm) {
				if(isConfirm){
					$.ajax({
						url: '<?php echo $install_regions_data; ?>',
						type: 'post',
						data: 'country_id=' + country_id,
						dataType: 'json',

						beforeSend: function () {
							$('.install-progress').html('');
							$('#form').fadeTo('slow', 0.2);
							$('#content > div.container-fluid > div > div.panel-body').append('<div style="color: #f38733" class="la-ball-scale-multiple la-3x"><div></div><div></div><div></div></div>');
						},

						success: function (json) {
							$('.la-ball-scale-multiple').remove();
							$('#form').fadeTo('slow', 1);

							if (json['error']) {
								swal({
									title: "Error!",
									text: "Something wrong...",
									type: "error",
									showConfirmButton: false,
									timer: 1500
								});
								console.log('geo_by_ip: ' + json['error']);
								$('.install-progress').append('<div class="alert alert-danger"><strong>Error!</strong> ' + json['error'] + '</div>');
							}

							if (json['success']) {
								swal({
									title: "Good job!",
									text: "Regions have been updated",
									type: "success",
									showConfirmButton: false,
									timer: 1200
								});
								$('.install-progress').append('<div class="alert alert-success"><strong>Success!</strong> Regions have been updated.</div>');
								$('.countries_list').append('<input type="hidden" name="<?php echo $id;?>_setting[countries_list][' + country_id + ']" value="' + country_name + '" />');
							}

						}
					});
				}
			});
		}
	});

	//checkbox
	$(".switcher[type='checkbox']").bootstrapSwitch({
		'onColor': 'success',
		'onText': '<?php echo $text_yes; ?>',
		'offText': '<?php echo $text_no; ?>',
	});

	//select country
	$('#country_select').change(function(){
		$("#install_regions_data").removeAttr('disabled');
	});

	$('body').on('change', '#select_config', function(){
		console.log('#select_config changed')
		var config = $(this).val();
		$('body').append('<form action="<?php echo $module_link; ?><?php echo ($stores) ? "&store_id='+$('#store').val() +'" : ''; ?>" id="config_update" method="post" style="display:none;"><input type="text" name="config" value="' + config + '" /></form>');
		$('#config_update').submit();
	});

	$('body').on('click', '#save_and_stay', function(){

		$('.summernote').each( function() {
			$(this).val($(this).code());
		});
		$.ajax( {
			type: 'post',
			datatype:'html',
			url: $('#form').attr('action') + '&save',
			data: $('#form').serialize(),
			beforeSend: function() {
				$('.alert').remove();
				$('#form').fadeTo('slow', 0.5);
			},
			complete: function() {
				$('#form').fadeTo('slow', 1);
			},
			success: function(html) {
				var alert = $(html).find('.alert ');
				$('#content > .container-fluid').prepend(alert);
			}
		});
	});

	$('body').on('click', '#clear_debug_file', function(){ 
		$.ajax( {
			url: '<?php echo $clear_debug_file; ?>',
			type: 'post',
			dataType: 'json',
			data: 'debug_file=<?php echo $debug_file; ?>',

			beforeSend: function() {
				$('#form').fadeTo('slow', 0.5);
			},

			complete: function() {
				$('#form').fadeTo('slow', 1);   
			},

			success: function(json) {
				$('.alert').remove();
				console.log(json);

				if(json['error']){
					$('#debug .tab-body').prepend('<div class="alert alert-danger">' + json['error'] + '</div>')
				}

				if(json['success']){
					$('#debug .tab-body').prepend('<div class="alert alert-success">' + json['success'] + '</div>')
					$('#textarea_debug_log').val('');
				} 
			}
		});
	});
});

//--></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#country_select').select2({
			placeholder: "Select a country"
		});
	});
</script>
<?php echo $footer; ?>