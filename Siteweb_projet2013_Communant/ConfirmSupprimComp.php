 <?php
//Page de confirmation apr�s "suppression dune comp�tence" dans ModifProfil.php
require("moduleFonction.php");
connexionChoixBase();
session_start();
$IDM = $_SESSION["IDM"];
$comp= $_GET["IDComp�Supprimmer"];

$querySup = "DELETE FROM AVOIR WHERE IDM ='$IDM' AND IDC ='$comp'";
$resultSup = mysql_query ($querySup);
$msg=mysql_error();
echo("$msg");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>ConfirmSupprimComp.php</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="style"> 
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
    <h4 align="right" color="#E3E3E3"><a href="Deconnexion.php" >D�connexion</a></h4>
    <h4 align="right"><a href="Accueil.php">Retourner � page d'Accueil</a></h4>
  </div>
  <div class="contenu"> <br>
    <h3>Vous avez bien supprim� cette comp�tence de votre profil !</h3>
    <form action="ModifProfil.php" method="get">
      <input type="submit" value="Continuez � modifier votre profil" />
    </form>
  </div>
</div>
</body>
</html>
