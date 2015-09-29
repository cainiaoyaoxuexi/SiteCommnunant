 <!--  2eme page d'enregistrement si l'utilisateur n'est pas encore membre:
     Récupération des infos saisies, vérifications, insertion , confirmation -->
<?php
session_start();
$_SESSION["email"] = $_POST["txt_email"];  //email servira d'identifiant pour le reste de l'enregistrement
$_SESSION["COUNT"]=0;
require("moduleFonction.php");
connexionChoixBase();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
<title>Enregistrement 2</title>
<link href="style.css" rel="stylesheet" type="text/css">
 </head>
 <body>
  <div class="style"> 
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3> </div>
  <?php
  //récupération des données saisies dans Enregistrer.php :
  $nom=$_POST["txt_nom"];
  $prenom=$_POST["txt_pre"];
  $pseudo=$_POST["txt_pes"];
  $email=$_POST["txt_email"];
  $mdp=$_POST["txt_mdp"];
  $confirm=$_POST["txt_Confirmdp"];

  //requete compte le nombre de membres correspondant à l'email saisie
  $query = "SELECT IDM FROM MEMBRES WHERE EMAIL = '$email'";
  $resultat=mysql_query($query);
  $nbrows=mysql_num_rows($resultat);

  IF ($mdp==$confirm)  //si le mot de passe est correctement confirmé
    {
    IF ($nbrows==0)			 //et si il n'y a pas encore membres dans la base possèdant l'email saisie
	  {
	  $requeteCreationMembre = "INSERT INTO MEMBRES VALUES('','$nom','$prenom','$pseudo', '$email', '$mdp')";
      $result=mysql_query($requeteCreationMembre);
										 //insertion d'un membre dans la base											
      if ($result==0)			 //en cas d'erreur lors de l'insertion
         {
		 $msg=mysql_error();	 
		 echo("$msg");				 //affichage du message d'erreur			
		 }
         else				 			 	 //sinon texte de confirmation d'insertion
         {
		 echo("<div class='contenu'>");
		 echo("<br><h3>Votre profil a été crée !</h3>");
		 echo ("<h3>Récapitulatif de vos informations...</h3>");
?>
		<!-- création table récapitulatif infos -->
		<table border=1 ; cellpadding=2; align="center" ; text-align:center ; vertical-align:center> 
		<tr>
			<td><b>Nom</b></td>
			<td><b>Prenom</b></td>
			<td><b>Pseudo</b></td>
			<td><b>Email</b></td>
			<td><b>Mot de Passe</b></td>
		</tr>
		<tr>
			<td> 
			<?php 
		//fonction récupère tous les infos d'un membre:
		$nupletMembre = infosMembreParEmail($email);  

		//insertion des infos dans la table :					 
		echo (" &nbsp&nbsp ".$nupletMembre["NOMM"]." &nbsp&nbsp </td><td> &nbsp&nbsp ".$nupletMembre["PRENOM"]." &nbsp&nbsp </td><td> &nbsp&nbsp ".$nupletMembre["PSEUDO"]." &nbsp&nbsp </td>");
		echo ("<td> &nbsp&nbsp ".$nupletMembre["EMAIL"]." &nbsp&nbsp </td><td> &nbsp&nbsp ".$nupletMembre["PASSWORD"]." &nbsp&nbsp </td></tr>");
		echo ("</table>");

		//bouton pur aller à la page Enregistrer3.php pour ajouter des compétences
		echo ("<form action = \"Enregistrer3.php\" >");
		echo ("<br><input type=\"submit\" value=\"Ajouter des compétences à votre profil\"></form>");

		//bouton pur aller à la page Accueil.php 
		echo ("<form action = \"Accueil.php\" >");
		echo ("<br><input type=\"submit\" value=\"Connectez vous\"</form>");
		echo("</div>");
		}
		}

		else 					 //si l'email saisie existait déjà :
		{
		echo ("<h2 align='center'>L'adresse email selectionnée existe déjà dans notre base.<br> Veuillez choisir une autre addresse email.</h2>");
		echo ("<form action=\"Enregistrer.php\" method=\"get\">");
		echo ("<p align='center'><input type=\"submit\" value=\"Revenir changer votre email\"/></p>");
		echo ("</form>");
		}
	}

	else 					 //si le texte saisie dans "confirmer MdP" est diffèrent du mot de passe saisie :
		{ 
		echo("<h2 align='center'>Confirmer votre mot de pass!</h2>");
		echo ("<form action=\"Enregistrer.php\" method=\"get\">");
		echo ("<p align='center'><input type=\"submit\" value=\"Revenir changer votre email\"/></p>");
		echo ("</form>");
		}

?>
</div>
</body>
</html>
