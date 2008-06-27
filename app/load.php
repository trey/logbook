<?php

define('APP_DIR',     dirname(__FILE__).'/');
define('PUBLIC_DIR',  dirname(__FILE__).'/../public/');
define('CONTENT_DIR', dirname(__FILE__).'/../content/');
define('EXT',         '.markdown');

$month_names_en = array(
	'1' => 'January',
	'2' => 'February',
	'3' => 'March',
	'4' => 'April',
	'5' => 'May',
	'6' => 'June',
	'7' => 'July',
	'8' => 'August',
	'9' => 'September',
	'10' => 'October',
	'11' => 'November',
	'12' => 'December'
	);

require_once('markdown.php');

foreach(scandir(CONTENT_DIR) as $year) {
	$year_dir = CONTENT_DIR.$year;
	if(is_dir($year_dir) && preg_match("/\d\d\d\d/", $year)) {
		$months = array();
		foreach(scandir(CONTENT_DIR.$year) as $month) {
			$month_dir = $year_dir.'/'.$month;
			if(is_dir($month_dir) && preg_match("/\d\d/", $month)) {
				$days = array();
				foreach(scandir(CONTENT_DIR.$year.'/'.$month) as $file) {
					$day = str_replace(EXT, '', $file);
					$file_path = $month_dir.'/'.$file;
					$date = "$year-$month-$day";
					if(is_file($file_path) && preg_match("/\d\d/", $day)) {
						$days[$day] = $date;
					}
				}
				$months[$month] = $days;
			}
		}
		$years[$year] = $months;
	}
}

// FUNCTIONS
function get_month($month_number) {
	global $month_names_en;
	return $month_names_en[ltrim($month_number, '0')];
}

function get_entry() {
	if(isset($_GET['date'])) {
		if(!preg_match("/\d\d\d\d\-\d\d\-\d\d/", $date) === false) {
			return "No Entry Found";
		} else {
			$date_parts = explode('-', $_GET['date']);

			$filelist = array();
			$content = '';
			while ($file = readdir(CONTENT_DIR.$date_parts[0].'/'.$date_parts[1].'/'.$date_parts[2])) {
				if ( $file{0} == "." )
					continue;

				$file = preg_replace("/(.*?)\.EXT/", "<a href=\"" . SELF . "/\\1\">\\1</a>", $file);
				array_push($filelist, $file);
			}
			closedir($dir);

			return Markdown(file_get_contents(CONTENT_DIR.$date_parts[0].'/'.$date_parts[1].'/'.$date_parts[2].EXT));
		}
	} else {
		return "Please choose and entry.";
	}
}


?>