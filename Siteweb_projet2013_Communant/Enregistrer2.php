 <!--  2eme page d'enregistrement si l'utilisateur n'est pas encore membre:
     R�cup�ration des infos saisies, v�rifications, insertion , confirmation -->
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
  //r�cup�ration des donn�es saisies dans Enregistrer.php :
  $nom=$_POST["txt_nom"];
  $prenom=$_POST["txt_pre"];
  $pseudo=$_POST["txt_pes"];
  $email=$_POST["txt_email"];
  $mdp=$_POST["txt_mdp"];
  $confirm=$_POST["txt_Confirmdp"];

  //requete compte le nombre de membres correspondant � l'email saisie
  $query = "SELECT IDM FROM MEMBRES WHERE EMAIL = '$email'";
  $resultat=mysql_query($query);
  $nbrows=mysql_num_rows($resultat);

  IF ($mdp==$confirm)  //si le mot de passe est correctement confirm�
    {
    IF ($nbrows==0)			 //et si il n'y a pas encore membres dans la base poss�dant l'email saisie
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
		 echo("<br><h3>Votre profil a �t� cr�e !</h3>");
		 echo ("<h3>R�capitulatif de vos informations...</h3>");
?>
		<!-- cr�ation table r�capitulatif infos -->
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
		//fonction r�cup�re tous les infos d'un membre:
		$nupletMembre = infosMembreParEmail($email);  

		//insertion des infos dans la table :					 
		echo (" &nbsp&nbsp ".$nupletMembre["NOMM"]." &nbsp&nbsp </td><td> &nbsp&nbsp ".$nupletMembre["PRENOM"]." &nbsp&nbsp </td><td> &nbsp&nbsp ".$nupletMembre["PSEUDO"]." &nbsp&nbsp </td>");
		echo ("<td> &nbsp&nbsp ".$nupletMembre["EMAIL"]." &nbsp&nbsp </td><td> &nbsp&nbsp ".$nupletMembre["PASSWORD"]." &nbsp&nbsp </td></tr>");
		echo ("</table>");

		//bouton pur aller � la page Enregistrer3.php pour ajouter des comp�tences
		echo ("<form action = \"Enregistrer3.php\" >");
		echo ("<br><input type=\"submit\" value=\"Ajouter des comp�tences � votre profil\"></form>");

		//bouton pur aller � la page Accueil.php 
		echo ("<form action = \"Accueil.php\" >");
		echo ("<br><input type=\"submit\" value=\"Connectez vous\"</form>");
		echo("</div>");
		}
		}

		else 					 //si l'email saisie existait d�j� :
		{
		echo ("<h2 align='center'>L'adresse email selectionn�e existe d�j� dans notre base.<br> Veuillez choisir une autre addresse email.</h2>");
		echo ("<form action=\"Enregistrer.php\" method=\"get\">");
		echo ("<p align='center'><input type=\"submit\" value=\"Revenir changer votre email\"/></p>");
		echo ("</form>");
		}
	}

	else 					 //si le texte saisie dans "confirmer MdP" est diff�rent du mot de passe saisie :
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
