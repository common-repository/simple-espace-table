<?php 
namespace Espace;

class FragmentsLoader {
	public static function loadFragment($fragment_name, $print = true, $data = []) {
		// check if plugin dir is defined
		if (!defined('SIMPLE_ESPACE_TABLE_PLUGIN_DIR')) {
			return '';
		}

		// init the filename
		$file_name = SIMPLE_ESPACE_TABLE_PLUGIN_DIR . '/fragments/' . $fragment_name;
		// check if fragment exist
		if (!file_exists($file_name)) {
			return '';
		}

		// put the data in include
		if ($data && is_array($data)) {
			extract($data);
		}

		// save html in a var
		ob_start();
			include_once($file_name);
		$html = ob_get_clean();
		
		if ($print) {
			echo $html;
			return;
		}

		return $html;
	}
}