function saisie1(txt_nom)
{
 if(txt_nom.value.length==0)
 {alert("saisie votre nom");
	return (false);}
else 
    {return (true);}
}

function saisie2(txt_pre)
{
if(txt_pre.value.length==0)
	{alert("saisie la quantité");
	return (false);}
else
    {return (true);}
}

function saisie3(txt_pes)
{
if(txt_pes.value.length==0)
	{alert("saisie la quantité");
	return (false);}
else
    {return (true);}
}

function saisie4(txt_mdp)
{
if(txt_mdp.value.length==0)
	{alert("saisie la quantité");
	return (false);}
else
    {return (true);}
}

function saisie5(txt_email)
{
 if(txt_email.value.length==0)
	{alert("saisie l'adresse e-mail");
	return (false);}
	else if (txt_email.value.indexOf("@")==-1||adresse.value.indexOf(".")==-1)
    {alert("saisie une adresse e-mail valide");
	return (false);}
 else
	{return (true);}
}

