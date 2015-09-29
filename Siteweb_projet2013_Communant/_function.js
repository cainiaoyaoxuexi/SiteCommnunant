
// fonctions javascript

function saisie1(txt_nom)
{
 if(txt_nom.value.length==0)
 {alert("Vous devez saisir un nom");
	return (false);}
else 
    {return (true);}
}

function saisie2(txt_pre)
{
if(txt_pre.value.length==0)
	{alert("Vous devez saisir un prénom");
	return (false);}
else
    {return (true);}
}

function saisie3(txt_pes)
{
if(txt_pes.value.length==0)
	{alert("Vous devez saisir un pseudo");
	return (false);}
else
    {return (true);}
}

function saisie4(txt_mdp)
{
if(txt_mdp.value.length==0)
	{alert("Vous devez saisir un mot de passe");
	return (false);}
else
    {return (true);}
}

function saisie5(txt_email)
{
 if(txt_email.value.length==0)
	{alert("Vous devez saisir une adresse email");
	return (false);}
	else if (txt_email.value.indexOf("@")==-1||txt_email.value.indexOf(".")==-1)
    {alert("Veuillez saisir une adresse e-mail valide");
	return (false);}
 else
	{return (true);}
}

function saisie6(commentaire)
{
if(commentaire.value.length==0)
	{alert("Vous devez écrire un commentaire");
	return (false);}
else
  {return (true);}
}

function saisie7(nomMembre)
{
if(nomMembre.value.length==0)
	{alert("Vous devez saisir le nom ou le prénom ou le pseudo de la personne vous cherchez!");
	return (false);}
else
    {return (true);}
}

function saisie8(souscommentaire)
{
if(souscommentaire.value.length==0)
	{alert("Vous devez écrire un commentaire");
	return (false);}
else
    {return (true);}
}

function saisie9(txt_Confirmdp)
{
if(txt_Confirmdp.value.length==0||txt_Confirmdp.value!=txt_mdp.value)
	{alert("Confirmez votre mot de passe!");
	return (false);}
else
    {return (true);}
}

function saisie10(txt_nom)
{
 if(txt_nom.value.length==0)
 {alert("Vous devez saisir un nom");
	return (false);}
else 
    {return (true);}
}

function saisie11(txt_prenom)
{
if(txt_prenom.value.length==0)
	{alert("Vous devez saisir un prénom");
	return (false);}
else
    {return (true);}
}

function saisie12(txt_pesudo)
{
if(txt_pesudo.value.length==0)
	{alert("Vous devez saisir un pseudo");
	return (false);}
else
    {return (true);}
}

function saisie13(txt_password)
{
if(txt_password.value.length==0)
	{alert("Vous devez saisir un mot de passe");
	return (false);}
else
    {return (true);}
}

function saisie14(txt_email)
{
 if(txt_email.value.length==0)
	{alert("Vous devez saisir une adresse email");
	return (false);}
	else if (txt_email.value.indexOf("@")==-1||adresse.value.indexOf(".")==-1)
    {alert("Veuillez saisir une adresse e-mail valide");
	return (false);}
 else
	{return (true);}
}