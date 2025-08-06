# pdftexter
A pdf textual reader for OpenBSD (script and web frontend) 
<br><br>
Acceptable script calls by shell:
<br>
pdftexter Unix1.pdf  (call &lt;pdf&gt;.idx index if exists)  
pdftexter Unix1.pdf -- 10  
pdftexter Unix1.pdf -- 10 15  

Acceptable frontend calls:
<br>
http://myreader.puppy/web.php?pdf=Unix1.pdf  (call &lt;pdf&gt;.idx index if exists)  
http://myreader.puppy/web.php?pdf=Unix1.pdf&frompage=10  
http://myreader.doggy/web.php?pdf=Unix1.pdf&frompage=10&topage=15  

Script web call for debugging purpose:
<br>
t=`date "+%Y%m%d-%H%M%S"`; pdftexter Unix1.pdf $t 10 15

<br>
Screenshot:  

<img src="screenshot1.png">
