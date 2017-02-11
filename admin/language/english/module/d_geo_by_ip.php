<?php
/*
 *	location: admin/language
 */

//heading
$_['heading_title']     		= '<span style="color:#449DD0; font-weight:bold"><i class="fa fa-globe" aria-hidden="true"></i> Geo by ip</span><span style="font-size:12px; color:#999"> by <a href="http://www.opencart.com/index.php?route=extension/extension&filter_username=Dreamvention" style="font-size:1em; color:#999" target="_blank">Dreamvention</a></span>';
$_['heading_title_main']		= 'Geo by ip';
$_['text_edit']					= 'Module settings';
$_['text_module']               = 'Modules';

//entry
$_['entry_status']				= 'Status';
$_['entry_config_files']		= 'Config files';
$_['entry_select']              = 'Select';
$_['entry_text']                = 'Text';
$_['entry_radio']               = 'Radio';
$_['entry_checkbox']            = 'Checkbox';
$_['entry_color']               = 'Color';
$_['entry_image']               = 'Image';
$_['entry_textarea']            = 'Textarea';

//radio
$_['text_radio_1']              = 'Yes';
$_['text_radio_0']              = 'No';

//field
$_['entry_field']				= 'Fields';
$_['entry_type']                = 'Type';

//button
$_['button_save_and_stay']		= 'Save and stay';

//success
$_['text_success']			    = 'Success: You have modified module Geo by ip!';

//error
$_['error_permission']			= 'Warning: You do not have permission to modify this module!';
$_['error_select']				= 'Select required!';
$_['error_text']                = 'Text required!';

//setting
$_['tab_setting']               = 'Settings';

//update
$_['entry_update']				= 'Your version is %s';
$_['button_update']				= 'Check update';
$_['success_no_update']         = 'Super! You have the latest version.';
$_['warning_new_update']        = 'Wow! There is a new version available for download.';
$_['error_update']         		= 'Sorry! Something went wrong. If this repeats, contact the support please.';
$_['error_failed']        		= 'Oops! We could not connect to the server. Please try again later.';

//debug
$_['tab_debug']					= 'Debug';
$_['entry_debug']				= 'Debug';
$_['entry_debug_file']          = 'Debug file';
$_['success_clear_debug_file']	= 'Debug file cleared successfuly.';

//support
$_['tab_support']               = 'Support';
$_['text_support']              = 'Support';
$_['entry_support']             = 'Support';
$_['button_support_email']      = 'support';

//instruction
$_['tab_instruction']           = 'Instructions';
$_['text_instruction']			= '
<div class="row">
	<div class="col-md-2">
        <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="#in_install"  data-toggle="tab">Settings</a></li>
            <li><a href="#in_show"  data-toggle="tab">Placement</a></li>
            <li style="display:none"><a href="#in_development"  data-toggle="tab">Development</a></li>
        </ul>
	</div>
    <div class="col-md-10">
        <div class="tab-content">
            <div id="in_install" class="tab-pane active">
		        <div class="tab-body">
		            <h2>Installation Geo by ip</h2>
                    <p>The module lets you determine your <strong>location(country and region)</strong> based on your IP address</p>
                    <p>The steps of setting the module up:</p>
                    <ol>
                        <li>Choose the status - <strong>Enabled</strong></li>
                        <li>Choose the country and click on the button - <strong>Update regions</strong></li>
                        <img class="img-responsive img-thumbnail" style="margin-bottom:5px" src="http://image.prntscr.com/image/01f11b7b921c4a88bdfd924436b86fc2.png">
                        <div class="bs-callout bs-callout-info">
                            <h4>Note!</h4>
                            <p>The database of countries and regions is already installed. If your did any customizations with <strong>oc_zone</strong> table, you should update it, it\'s needed for correct determination your IP address. It takes some time. <span class="label label-danger">It should be done only when <strong>oc_zone</strong> table has been changed</span></p>
                        </div>
                        <!-- <div class="bs-callout bs-callout-danger" style="margin-top:20px">
                            <h4>Note!</h4>
                            <p>If you got "Error! The provided API key is invalid.". Please, change the key!</p>
                        </div> -->
                        <li>Select a service provider</li>
                        <img class="img-responsive img-thumbnail" style="margin-bottom:5px" src="http://image.prntscr.com/image/1c5f1c14138a440e81b0fa35305078e7.png">
                        <div class="bs-callout bs-callout-info">
                            <h4>Note!</h4>
                            <p>If the module can not define your location, you might try to change the service</p>
                        </div>
                        <li>Save the settings by clicking on button Save or Save&Stay</li>
                    </ol>
		        </div>
		    </div>
            <div id="in_show" class="tab-pane">
		        <div class="tab-body">
		            <h2>Placement of the module</h2>
                    <p>The controller should return an array with 2 values: <code>country_id</code> and <code>zone_id</code></p>
                    <p>To get the array, you should invoke the controller:</p>
                    <blockquote>
						<p>$this->load->controller(\'module/d_geo_by_ip\');</p>
					</blockquote>
		        </div>
		    </div>
            <div id="in_development" class="tab-pane">
		        <div class="tab-body">
		            <h2>Development</h2>
		            <p>You have an installed base of all countries and regions. If you want to update regions of all countries, enter a url to the browser\'s address bar: <code>'.DIR_APPLICATION. 'index.php?route=module/d_geo_by_ip/ferma</code></p>
		            <div class="bs-callout bs-callout-warning">
                        <h4>Warning!</h4>
                        <p>Make a range from 1 to 120. In total 257 countries. After the execution of the script (1 to 120), change a key("Create project" in API Project), Set the range 120 to 257 and run the script again. <blockquote>$result = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=" . urlencode($zone_name) . "&key=<span class="label label-danger">AIzaSyCoNkDlgIYq9hEblUcnLU9he7fdhEVrlhI</span>");</blockquote></p>
                        File is located in <code>'.DIR_APPLICATION. 'controller/module/d_geo_by_ip.php</code>
                        <blockquote>
                            <p><pre>	public function ferma() {
		for($i = 1; $i <= 120; $i++){
			$this->regions($i);
		}
	}</pre></p>
                        </blockquote>
                    </div>
		        </div>
		    </div>
        </div>
    </div>
</div>
';
$_['text_not_found'] = '<div class="jumbotron">
          <h1>Please install Shopunity</h1>
          <p>Before you can use this module you will need to install Shopunity. Simply download the archive for your version of opencart and install it view Extension Installer or unzip the archive and upload all the files into your root folder from the UPLOAD folder.</p>
          <p><a class="btn btn-primary btn-lg" href="https://shopunity.net/download" target="_blank">Download</a></p>
        </div>';
?>