<?php 

// 3eme page d'enregistrement si l'utilisateur n'est pas encore membre:
// (Ajout de compétences)...
 
session_start();
$email =$_SESSION["email"];			//identifie le membre connecté

require("moduleFonction.php");					
connexionChoixBase();				//fonction se connecte à la base							 


$nuplet= infosMembreParEmail($email); 	//fonction récupère tous les infos du membre connecté
$IDM=$nuplet["IDM"];


			 
If ($_SESSION["COUNT"]!=0)				//si le membre vient de cette même page 
{
$IDC=$_GET["competence"];				//on récupère la compétences et niveau à ajouter 	 
$niv=$_GET["niveau"];

//on vérifie que le membre n'a pas déjà la compétence, dans ce cas on l'ajoute dans la base
$requetCheckCom="SELECT IDC FROM AVOIR WHERE IDC= '$IDC' AND IDM='$IDM'";
$curseurCheckCom=mysql_query($requetCheckCom);
$nbCom=mysql_num_rows($curseurCheckCom);
 If ($nbCom ==0)   //si il n'a pas encore la compétence
 {
 	 				 				//on lui ajoute dans la base avec le niveau correspondant
$requeteInsererComp = "INSERT INTO AVOIR VALUES('$IDM','$IDC','$niv')";
$result=mysql_query($requeteInsererComp);

  if ($result==0)
  {
$msg=mysql_error();
echo("$msg");
  }

 }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Enregistrer3</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="style"> 
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
    <h4 align="right" color="#E3E3E3"> <a href="Deconnexion.php" >Connexion</a></h4>
  </div>
  <div class="contenu"><br>
    <h3 align="center">Selectionnez une compétence à ajouter ...</h3>
    <!--création d'un 1er formulaire qui renvoie à cette même page-->
    <form action ="Enregistrer3.php" method="GET">
      <table align="center">
        <tr>
          <td>Compétence:</td>
          <td><select name="competence">
              <?php
//affichage d'une liste déroulante avec toutes les compétences existantes dans la base
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
        <option value="Expert">Expert</option></td></tr><tr><td></td><td><input type="submit" value="Ajouter"></td></tr>
      </table>
    </form>
    <h3 align="center">Votre compétence n'est pas dans la liste? <br>
      Saisissez la ici ...</h3>
    <!-- 2eme formulaire qui renvoie à cette même page-->
    <form action="AjouteNouvCompetence.php" method="GET">
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
    <?php If ($_SESSION["COUNT"]!=0)  //si le membre provient de cette même page par les formumaires:
{
$queryCompNiv="SELECT c.NOMC , a.NIVEAU FROM COMPETENCES c,  AVOIR a WHERE c.IDC=a.IDC AND a.IDM ='$IDM'";
$resultat=mysql_query($queryCompNiv);
$nbcomp= mysql_num_rows ($resultat);
echo ("<h3 align='center'>Vos compétences actuels ...</h3>");

//création d'une table qui affiche la liste de ses compétences déjà ajoutés:
echo ("<Table align='center' border=1><tr><td><h3>Compétence</h3></td>");
echo ("<td><h3>Niveau</h3></td></tr>");

	for ($i = 1;$i<=$nbcomp;$i++)					 																 
	{
	$nuplet=mysql_fetch_array($resultat);
	$c=$nuplet["NOMC"];
	$n=$nuplet["NIVEAU"];

	echo ("<tr><td>"."$c"."</td>"."<td>"."$n"."</td></tr>");
	}
echo ("</table>");
}

$_SESSION["COUNT"]=+1; 			// si c'est la 1ere fois que l'utilisateur arrive sur cette page..
														// ...on signale que ce ne sera plus le cas à l'avenir							
?>
    <form action = "Accueil.php" >
      <br>
      <input type="submit"  value="Connectez vous">
    </form>
  </div>
</div>
</body>
</html>
