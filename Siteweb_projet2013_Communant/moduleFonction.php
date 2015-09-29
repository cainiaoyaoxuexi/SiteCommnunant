<?php

//module de fonctions

define("ID_MYSQL", "21103205");
define("MOTPASSE_MYSQL", "L009V3");
define("URL_MYSQL", "localhost");
define("BASE_MYSQL", "db?21103205");


function connexionChoixBase()					
  {
	mysql_connect(URL_MYSQL, ID_MYSQL, MOTPASSE_MYSQL)
	                OR die("Connexion à MySQL impossible");
	//ici, forcément connecté
	mysql_select_db(BASE_MYSQL)
	                OR die("Acces impossible à la base".BASE_MYSQL);
	
	}
	
function infosMembreParID($IDM)	
	{
	 			$requeteIM= "SELECT * FROM MEMBRES WHERE IDM = '$IDM'";
				$resultIM = mysql_query($requeteIM);
				$nupletIM = mysql_fetch_array($resultIM);

return $nupletIM;
	}
	
function infosMembreParEmail($EMAIL)
	{
	 			$requeteIM= "SELECT * FROM MEMBRES WHERE EMAIL = '$EMAIL'";
				$resultIM = mysql_query($requeteIM);
				$nupletIM = mysql_fetch_array($resultIM);

return $nupletIM;
	}	
	
function doYouLike($idcom, $IDM)	//Vérifie si un membre donné a déjà Liké un commentaire donné
  {
				 $queryYouLike = "SELECT * FROM APPROUVER WHERE IDCOM = '$idcom' AND IDM = '$IDM'";
				 $result= mysql_query($queryYouLike);
				 $YouLike = mysql_num_rows ($result); 
				 
return $YouLike;
  }
	
function nbQuiAiment($idcom)			 //Renvoie le nombre de Likes pour un commentaire donnée				
  {
	 			 $query = "SELECT * FROM APPROUVER WHERE IDCOM = '$idcom'";
				 $result= mysql_query($query);
				 $nbAiment = mysql_num_rows($result);	
					 
return $nbAiment;
  }
	
function nbCommentaires($IDMProfil) //Renvoi le nombre de commentaires mères dun membre donné
  {
				 $infosComment="SELECT * FROM COMMENTAIRES WHERE IDM='$IDMProfil' AND IDCOM_SURCOM IS NULL ORDER BY DATE DESC";
				 $result=mysql_query($infosComment);
				 $nb = mysql_num_rows($result);

return $nb;
  }
	
function nbSousCom($idcom)					//Renvoie le nombre de sous-commentaires DIRECTS à un commentaire donné 
  {
				 $souscom ="SELECT * FROM COMMENTAIRES C, MEMBRES M WHERE C.IDM=M.IDM AND C.IDCOM_SURCOM ='$idcom'ORDER BY C.DATE ASC";
				 $curseursouscom=mysql_query($souscom);
				 $nb=mysql_num_rows($curseursouscom);

return $nb;
  }	
	
function quiRecommande($IDM, $IDC)	//Renvoie le premier Pseudo de la liste de membres ayant recommandé un membre donné pour une compétence donnée			 
  {
				 $queryQR ="SELECT M.PSEUDO FROM RECOMMANDER R, MEMBRES M WHERE R.IDM_RECOMMAND=M.IDM AND R.IDM=$IDM AND R.IDC=$IDC";
				 $curseurQR=mysql_query($queryQR);
				 $nom=mysql_fetch_array($curseurQR);

return $nom;
  }			
	

?>
