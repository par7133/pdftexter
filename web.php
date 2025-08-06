<?PHP

  require("config.inc");

	function htmlBody() {
	?>
		<!DOCTYPE html>
		<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
		<head>

			<meta charset="UTF-8"/>

      <meta name="viewport" content="width=device-width, initial-scale=0.8, minimum-scale=0.8, maximum-scale=0.8"/>

			<title>pdf reader</title> 

			<link rel="shortcut icon" href="/favicon.ico" />
				  
			<meta name="description" content="pdf reader"/>
			<meta name="keywords" content="5 Mode,pdf,reader"/>
			<meta name="robots" content="noindex"/>
			<meta name="author" content="5 Mode and contributors."/>
			
			<style>
				 body {
				   background:#000000;
				   color:#FFFFFF;
				 }
			</style>
			
		</head>
		<body>
	<?PHP
	}  

	function endBody() {
	?>
		</body>
		</html>
	<?PHP
	}  

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
      die("Pdf index was not supplied. You have to redact an idx file for your pdf in the form [chapter]...[frompage][topage]\\n!");
    } else {
      htmlBody();
      echo("<form action='/web.php' method='get'>");
      echo("<input name='pdf' type='hidden' value='".$pdf."'>");
      echo("<br>");
		  $f = file("$pdf.idx"); 
		  foreach($f as $line) {
		    echo($line."<br>");
		  } 
      echo("<br>");
      echo("<br>");
      echo("<br>");
      echo("<br>");
      echo("type a page or range:&nbsp;<input name='input' type='text'>");
      echo("</form>");
      endBody();
      exit(0);
    }
  }
  if ($topage!=="") {
    if ((int)$frompage > (int)$topage) {
      die("&lt;topage&gt; param must be greater than &lt;frompage&gt;");
    }
  }

  $date=date("Ymd-His");

  $rend = exec(PDFTEXTER_PATH." $pdf $date $frompage $topage");
  if ($rend!=="") {
    htmlBody(); 
    $f = file($rend); 
    foreach($f as $line) {
      echo($line."<br>");
    } 
    endBody();
    exit(0);
  } else {
    die("&lt;frompage&gt; and &lt;topage&gt; param have not been supppied!");  
  }
  