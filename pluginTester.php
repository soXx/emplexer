<?php  
	require_once 'lib/dune_core/bootstrap.php';
	require_once 'lib/dune_core/dune_api_nova.php';
	require_once 'lib/dune_core/dune_plugin.php';
	require_once 'lib/dune_core/dune_plugin_fw.php';
	require_once 'AutoLoad.php';

	$xml = simplexml_load_file("dune_plugin.xml");

	// print_r($xml);

	$options = getopt("t:m:");

	$optionType = isset($options['t']) ?  $options['t'] : 'get_folder_view';

	$optionMediaUrl = isset($options['m']) ? $options['m'] :  'main';


	$entry = null;


	// $config =  new Conf('emplexer_plugin_cookies.properties');


	//echo("incluindo arquivo ". (string)$xml->params->program);
	require_once (string)$xml->params->program;

	// print_r($entry);

	// print ($entry->actions->key_enter->type . "\n");
	$output = array(
			'op_type_code' => $optionType ,
			'op_id' => "1",
			'input_data' => array(
				"media_url" => $optionMediaUrl == null ? (string)$entry->media_url :  $optionMediaUrl
			),
			"plugin_cookies" => Config::getInstance()->pluginCookies
		 );
	// print_r(json_encode($output));


	DunePluginFw::$instance->call_plugin(json_encode($output));
	// print (DefaultDunePluginFw::$plugin_class_name ) . "\n";
	// DefaultDunePluginFw::$instace->call_plugin($output);
	// print_r(DunePluginFw::$instance);
	 // {"op_type_code":"get_folder_view","op_id":"1","input_data":{"media_url":"main_menu"},"plugin_cookies":{}}	

function convert($size)
 {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 }	

//echo ("memoria = " .  convert(memory_get_peak_usage(true)) . "\n");

?>