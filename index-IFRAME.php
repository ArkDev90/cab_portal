<?php 
//iframe Name: CAB PORTAL
//July 14, 2020
?>
<!DOCTYPE html>
<html>
<head> 
<title>CAB PORTAL</title> 
<script type="text/javascript">
	document.cookie='same-site-cookie=foo; SameSite=Lax';
	document.cookie='cross-site-cookie=bar; SameSite=None; Secure';
</script>
</head>

<body style="margin: 0px; overflow:hidden;"> 
<iframe src="http://180.232.152.234/portal" style="border: 0px; overflow: scroll; width:100%;" onload="this.height=window.innerHeight; window.addEventListener('resize', function () { document.querySelector('iframe').height = window.innerHeight; });"></iframe>
</body>
</html>