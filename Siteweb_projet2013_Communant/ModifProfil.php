<?php
//Page de modification du profil d'un membre (infos persos et infos competences)

require("moduleFonction.php");
connexionChoixBase();
session_start();
$IDM = $_SESSION["IDM"];

$_SESSION["COUNT"]=1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>ModifProfil.php</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript1.1" type="text/javascript" src="function.js">
</script>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="E3E3E3">
<div class="style"> 
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
    <h4 align="right" color="#E3E3E3"><a href="Deconnexion.php" >Déconnexion</a></h4>
    <h4 align="right"><a href="Accueil.php">Retourner à page d'Accueil</a></h4>
  </div>
  <!--  Partie gauche de la page (Modif infos persos) -->
  <div class="lefthalf"> 
    <h3>Voici vos informations actuels : </h3><table  cellpadding=2 border=1 style = "font-size:13px" style ="text-align:center;" align="center" >
    <tr>
      <td><b>Nom</b></td>
      <td><b>Prenom</b></td>
      <td><b>Pseudo</b></td>
      <td><b>Email</b></td>
      <td><b>Mot de Passe</b></td>
    </tr>
    <tr> 
      <?php 

$nupletMembre = infosMembreParID($IDM);

echo ("<td>".$nupletMembre["NOMM"]."  </td><td> ".$nupletMembre["PRENOM"]."</td><td>".$nupletMembre["PSEUDO"]."</td>");
echo ("<td>".$nupletMembre["EMAIL"]."</td><td> ".$nupletMembre["PASSWORD"]."</td></tr>");
echo ("</table>");

echo ("<h3>Modifiez vos infomations personnelles :</h3>");
$nom = $nupletMembre["NOMM"];
$prenom = $nupletMembre["PRENOM"];
$pseudo = $nupletMembre["PSEUDO"];
$email = $nupletMembre["EMAIL"];
$password = $nupletMembre["PASSWORD"];
echo ("<form action =\"ConfirmModifInfosPerso.php\" method=\"POST\">");
echo ("<table border = 1 style = \"font-size:13px;\" style =\"text-align:center;\"; align=\"center\" ><tr><td> Nom : </td><td> <input type=\"text\" name = \"txt_nom\" value = $nom /></td></tr>");
echo (" <tr><td>Prénom : </td><td><input type=\"text\" name = \"txt_prenom\" value=$prenom /></td></tr>");
echo (" <tr><td>Pseudo : </td><td><input type=\"text\" name = \"txt_pseudo\" value=$pseudo /></td></tr>");
echo (" <tr><td>Email : </td><td> <input type=\"text\" name = \"txt_email\" value=$email /></td></tr>");
echo (" <tr><td>Mot de Passe : </td><td><input type=\"text\" name = \"txt_password\" value=$password /></td></tr></table>");
echo ("  <input type=\"submit\" value=\"Confirmer les modifications\" onClick='return saisie10(txt_nom)&&saisie11(txt_prenom)&&saisie12(txt_pseudo)&&saisie13(txt_password)&&saisie14(txt_email)'/></form>");
?>
  </div>
  <!--  Partie droite de la page (Modif infos compétences) -->
  <div class="righthalf"> 
    <?php

$queryCompDetails = "SELECT COMPETENCES.NOMC , COMPETENCES.IDC , AVOIR.NIVEAU FROM  COMPETENCES, AVOIR WHERE AVOIR.IDM = '$IDM' AND COMPETENCES.IDC=AVOIR.IDC";
$resultCompDetails = mysql_query($queryCompDetails);
$nbcomp = mysql_num_rows($resultCompDetails);
$msg=mysql_error();
echo("$msg");

echo ("<h3>Modifiez vos compétences actuels: </h3><table border = 1 cellpadding=2 style = \"font-size:13px;\" ");
echo (" style = \"text-align:center;\" \"font-size:13px;\" align=\"center\" ><tr><td><b> Competence </b></td><td><b>");
echo ("  Niveau </b></td><td align='center'><b>Modifier</b></td></tr>");

for ($i=1; $i<=$nbcomp; $i++)
{
$nupletComp = mysql_fetch_array($resultCompDetails); 
echo ("<tr><td>".$nupletComp["NOMC"]."</td><td>".$nupletComp["NIVEAU"]." </td>");
echo ("<td><form action=\"ConfirmModifNiveau.php\" method=\"get\"><br> &nbsp Modifier niveau:");
$IDcomp = $nupletComp["IDC"];
echo ("<select name=\"niveau\">");
echo ("<option value=\"Junior\">Junior");
echo ("</option><option value=\"Confirmé\">Confirmé</option>");
echo ("<option value=\"Expert\">Expert</option>");
echo ("<input type=\"hidden\" name=\"IDCompàModifier\" value ='$IDcomp'/>");
echo ("<input type=\"submit\" value=\"Modifier\"></form> ");
echo ("<form action=\"ConfirmSupprimComp.php\" method=\"get\">");

echo (" <input type=\"hidden\" name=\"IDCompàSupprimmer\" value ='$IDcomp'/>");
echo ("<input type=\"submit\" value=\"Supprimer cette compétence\"></form></td></tr>");
}
echo ("</table>");
?>
    <h3>Sélectionnez une compétence à ajouter: </h3>
    <form action ="ConfirmNouvelleCompetence.php" method="GET"><table cellpadding=2 border=1 style = "font-size:13px;" style ="text-align:center;" align="center">
      <tr>
        <td> Compétence:</td>
        <td><select name="competence">
            <?php

$requeteNomc="select IDC,NOMC FROM COMPETENCES";
$curseurNomc=mysql_query($requeteNomc);
$nbNomc=mysql_num_rows($curseurNomc);

for ($i=1;$i<=$nbNomc;$i++)
{
$nupletNomc=mysql_fetch_array($curseurNomc);
echo("<option value=\"");
echo($nupletNomc["IDC"]);
echo("\">");
echo($nupletNomc["NOMC"]);
echo("</option>");
}
?>
          </select></td>
      </tr><tr>
      <td>Niveau:</td><td><select name="niveau">
      <option value="Junior">Junior</option>
      <option value="Confirmé">Confirmé</option>
      <option value="Expert">Expert</option></td></tr></table><br>
      <input type="submit" value="Ajouter">
    </form>
    <h3 align="center"> Saisissez une compétence à ajouter:</h3>
    <form action="ModifAjouterNouvCompetence.php" method="GET">
      <table align="center">
        <tr>
          <td>Compétence:</td>
          <td><input type="text" name="txt_com"/></td>
        </tr><tr>
        <td>Niveau:</td><td><select name="niveauAjouter">
        <option value="Junior">Junior</option>
        <option value="Confirmé">Confirmé</option>
        <option value="Expert">Expert</option></td></tr><tr><td></td><td><input type="submit" value="Ajouter"></td></tr>
      </table>
    </form>
  </div>
</div></div>
</body>
</html>
