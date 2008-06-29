<?php
  

  define('APP_DIR',     dirname(__FILE__).'/');
  define('PUBLIC_DIR',  dirname(__FILE__).'/../public/');
  define('CONTENT_DIR', dirname(__FILE__).'/../content/');
  
  require_once(APP_DIR.'spyc.php');
  $config = Spyc::YAMLLoad(APP_DIR.'config.yaml');
    
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
            $day = str_replace($config['ext'], '', $file);
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
    global $config;
    return $config['month_names'][ltrim($month_number, '0')];
  }
  
  function get_entry() {
    global $config;
    if(isset($_GET['date'])) {
      if(!preg_match("/\d\d\d\d\-\d\d\-\d\d/", $date) === false) {
        return "No Entry Found";
      } else {
        $date_parts = explode('-', $_GET['date']);
        return Markdown(file_get_contents(CONTENT_DIR.$date_parts[0].'/'.$date_parts[1].'/'.$date_parts[2].$config['ext']));
      }
    } else {
      return "Please choose and entry.";
    }
  }
  

?>