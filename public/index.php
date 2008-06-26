<?php require_once('../app/load.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="Content-Language" content="en-us" />
	<meta name="rating" content="General" />
	<meta name="MSSmartTagsPreventParsing" content="true" />
	<meta http-equiv="imagetoolbar" content="no" />

	<link href="css/reset.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/all.css" rel="stylesheet" type="text/css" media="all" />
	<!--[if IE]><link href="css/all_ie.css" rel="stylesheet" type="text/css" media="all" /><![endif]-->

	<meta name="description" content="" />
	<meta name="keywords" content="" />

	<title>Logbook</title>
</head>

<body>
<div id="wrapper">
<div id="header">
</div><!--end #header-->
<div id="main">
  <div id="nav">
    <h1>Dates</h1>
    <ul>
      <?php foreach($years as $year=>$months) { ?>
      <li class="year"><?php echo $year; ?>
        <ul>
          <?php foreach($months as $month=>$days) { ?>
          <li class="month"><?php echo get_month($month); ?>
            <ul>
              <?php foreach($days as $day=>$date) { ?>
              <li class="day"><a href="/?date=<?php echo $date; ?>"><?php echo date("l, \\t\h\e dS", strtotime("$year-$month-$day")); ?></a></li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>
    </ul>
  </div>
  <div id="entries">
    <?php echo get_entry(); ?>
  </div>
</div><!--end #main-->
<div id="footer">
</div><!--end #footer-->
</div><!--end #wrapper-->
</body>
</html>