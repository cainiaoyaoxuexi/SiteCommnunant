 <?php
//Page de confirmation après l'envoi d'un commentaire "mère" dans Accueil.php
require("moduleFonction.php");
connexionChoixBase();
session_start();
$IDM = $_SESSION["IDM"];
$comment= $_GET["commentaire"];

$queryinsertComment = "INSERT INTO COMMENTAIRES(IDCOM, CONTENU, DATE, IDM) VALUES('',\"$comment\", now(),'$IDM')";
$resultQIC = mysql_query($queryinsertComment);
$msg=mysql_error();
echo("$msg");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>ConfirmationCommentaire.php</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="style"> 
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
    <h4 align="right" color="#E3E3E3"><a href="Deconnexion.php" >Déconnexion</a></h4>
    <h4 align="right"><a href="Accueil.php">Retourner à page d'Accueil</a></h4>
  </div>
  <div class="contenu"> <br>
    <h3>Votre commentaire a été posté !</h3>
    <form action="Accueil.php" method="get">
      <input type="submit" value="Retourner sur votre page d'accueil" />
    </form>
  </div>
</div>
</body>
</html>
