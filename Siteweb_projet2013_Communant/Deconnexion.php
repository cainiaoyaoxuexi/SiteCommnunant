<?php
//Page de destruction de la session après choix de déconnexion 
session_start();
$_SESSION["CountB"]=0;
session_destroy();
header('location: Login.php');
exit;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>deconnenxion</title>
</head>
<body>
</body>
</html>
