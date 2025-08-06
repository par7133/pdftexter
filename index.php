<?PHP
  
  require("config.inc");

  $pdf=strip_tags(filter_input(INPUT_GET, "pdf")??"");
  if ($pdf==="") {
    die("You need to supply a &lt;pdf&gt; param.");
  }
  if (!is_readable($pdf)) {
    die("Pdf doesn't exists.");
  }
  $input=strip_tags(filter_input(INPUT_GET,"input")??"");
  if ($input!=="") {
    $a = explode(" ", $input);
    $frompage = $a[0]??"";
    $topage = $a[1]??"";
  } else {
    $frompage=strip_tags(filter_input(INPUT_GET, "frompage")??"");
    $topage=strip_tags(filter_input(INPUT_GET, "topage")??"");
  }
  if ($frompage!=="" && !is_numeric($frompage)) {
    die("&lt;frompage&gt; param must be a number.");
  }

  if ($topage!=="" && !is_numeric($topage)) {
    die("&lt;topage&gt; param must be a number.");
  }
  if ($frompage==="" && $topage!=="") {
    die("You need to supply &lt;frompage&gt; param too.");
  }
  if ($frompage==="" && $topage==="") {
    if (!is_readable("$pdf.idx")) {
      die("Pdf index was not supplied. You have to redact an idx file for your pdf!");
    } else {
      echo("<form action='/index.php' method='get'>");
      echo("<input name='pdf' type='hidden' value='".$pdf."'>");
		  $f = file("$pdf.idx"); 
		  foreach($f as $line) {
		    echo($line."<br>");
		  } 
      echo("");
      echo("");
      echo("");
      echo("");
      echo("type a page or range:&nbsp;<input name='input' type='text'>");
      echo("</form>");
      exit(0);
    }
  }
  if ((int)$frompage > (int)$topage) {
    die("&lt;topage&gt; param must be greater than &lt;frompage&gt;");
  }

  $date=date("Ymd-His");
  //$date=exec("date '+%Y%m%d-%H%M%S'"); 
 
  //echo(APP_PDFTEXTER_PATH." $pdf $date $frompage $topage");
  $rend = exec(PDFTEXTER_PATH." $pdf $date $frompage $topage");
  if ($rend!=="") {
    $f = file($rend); 
    foreach($f as $line) {
      echo($line."<br>");
    } 
  } else {
    die("&lt;frompage&gt; and &lt;topage&gt; param have not been supppied!");  
  }
  