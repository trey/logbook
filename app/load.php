<?php
  

  define('APP_DIR',     dirname(__FILE__).'/');
  define('PUBLIC_DIR',  dirname(__FILE__).'/../public/');
  define('CONTENT_DIR', dirname(__FILE__).'/../content/');
  
  require_once(APP_DIR.'spyc.php');
  $config = Spyc::YAMLLoad(APP_DIR.'config.yaml');
    
  require_once('markdown.php');
  
  foreach(scandir(CONTENT_DIR) as $year) {
    $year_dir = CONTENT_DIR.$year;
    if(preg_match("/\d\d\d\d/", $year) && is_dir($year_dir)) {
      $months = array();
      foreach(scandir($year_dir) as $month) {
        $month_dir = $year_dir.'/'.$month;
        if(preg_match("/\d\d/", $month) && is_dir($month_dir)) {
          $days = array();
          foreach(scandir($month_dir) as $day) {
            $day_dir = $month_dir.'/'.$day;
            if(preg_match("/\d\d/", $day) && is_dir($day_dir)) {
              $entries = array();
              foreach(scandir($day_dir) as $entry) {
                $entry_path = $day_dir.'/'.$entry;
                if(is_file($entry_path) && preg_match("/^\d{10,}$/", $entry)) {
                  $entries[$entry] = $entry_path;
                }
              }
              $days[$day] = $entries;
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
  
  function get_entries($date) {
    global $config;
    global $years;
    if(empty($date)) {
      return "Please choose and entry.";
    } else {
      if(preg_match("/\d{4}-\d{2}-\d{2}/", $date) == 0) {
        return "<h1>Invalid Date</h1>";
      } else {
        list($y, $m, $d) = explode('-', $date);
        $html = "<h1>Entries for ".date("l, F j, Y", strtotime("$y-$m-$d"))."</h1>";
        foreach($years[$y][$m][$d] as $entry => $path) {
          $time = date('g:i:s a', $entry);
          $html .= "<h2 class='timestamp'>$time</h2>";
          $html .= Markdown(file_get_contents($path));
        }
        return $html;
      }
    }
  }
  

?>