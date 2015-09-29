<?php
require("moduleFonction.php");
connexionChoixBase();
session_start();


$sousCommentaire=$_GET["souscommentaire"];
$IDM = $_SESSION["IDM"];
$IDCOMP=$_GET["IDCOMP"];

$requetesousCommentaire="insert into COMMENTAIRES values ('', '$sousCommentaire',now(), '$IDM','$IDCOMP')";
$curseursousCommentaire=mysql_query($requetesousCommentaire);
$msg=mysql_error();
echo("$msg");



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>ConfirmationSousCom</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="style">
<div class="entete"> &nbsp 
</div><div class="contenu">
<h2>Votre réaction au commentaire a été posté !</h2>
<form action="Accueil.php" method="get">
<input type="submit" value="Retourner sur le profil de la personne" />
</form>
</div></div>
</body>
</html>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Untitled</title>
</head>
<body>

</body>
</html>
