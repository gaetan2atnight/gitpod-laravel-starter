<?phprequire_once($_SERVER['DOCUMENT_ROOT']."/classes/functions.php");require_once($_SERVER['DOCUMENT_ROOT']."/classes/users.php");require_once($_SERVER['DOCUMENT_ROOT'].'/classes/cookies.php');//Préchargement du formulaire et récupération de l'id de l'utilisateur$userClass = new Users();$forgotPwd = false;if(isset($_GET['old'])){	$id = $userClass->getIdByPwd($_GET['old']);	$forgotPwd = true;}else{	$id = $userClass->getConnectedUser();}if($id == false)	header('Location: /');//Traitement du changement de mot de passeif(isset($_POST['btnValider'])){	//Récupération des saisies	$hasErrors = false;	$old = (isset($_POST["old"]))?$_POST["old"]:sha1(trim($_POST['oldPwd']));	$res = $userClass->getIdByPwd($old);	if($res == false){		$error = "L'ancien mot de passe que vous avez saisi est incorrect!";		$hasErrors = true;	}	if($hasErrors == false){		$mdp1 = trim($_POST['pwd1']);		$mdp2 = trim($_POST['pwd2']);		if(empty($mdp1) or empty($mdp2)){			$error = "Veuillez remplir tous les champs!";		}else{			if($mdp1 != $mdp2){				$error = "Veuillez rentrer deux fois le même mot de passe!";			}else{				//Modification du mot de passe				$userClass->changePwd($id, $mdp1);				//Création des cookies				createCookie('idUser', $id);				createCookie('pass', $mdp1);				//Redirection vers l'appli				header('Location: /');			}		}	}}getHead("GStart -> Changement de votre mot de passe");?><div id="maintextarea" class="arroundBox">	<!-----------------Formulaire de changement de mot de passe----------------->	<center>	<div class="titre">Changement de votre mot de passe</div><br/>	<form name="renvoimdp" action="" method="POST">		<table>			<tr>				<td align="right">					Identifiant : 				</td>				<td>					<?php  echo $id; ?>				</td>			</tr>			<?php if($forgotPwd == false){ ?>			<tr>				<td align="right">					Ancien mot de passe : 				</td>				<td>					<input type="password" title="Ancien mot de passe" name="oldPwd" value="" maxlength="100" size="30"/>				</td>			</tr>			<?php }else{ ?>			<input type="hidden" value="<?php echo $_GET['old']; ?>" name="old">			<?php } ?>			<tr>				<td align="right">					Nouveau mot de passe : 				</td>				<td>					<input type="password" title="Mot de passe" name="pwd1" value="" maxlength="100" size="30"/>				</td>			</tr>			<tr>				<td align="right">					Ressaisir le nouveau mot de passe : 				</td>				<td>					<input type="password" title="Ressaisir Mot de passe" name="pwd2" value="" maxlength="100" size="30"/>				</td>			</tr>		</table>		<input type="submit" value="Valider" name="btnValider"/>	</form><br/>	<div class="error"><?php if(isset($error)) echo $error; ?></div>	</center></div><div id="leftContent" class="arroundBox">	<center>		<div id="speechbubble" style="margin-top: 25px">			<div id="speechbubblescrollbar">				<ul class="text_left" style="margin-left: -20px;">					<li>Remplissez le formulaire pour changer votre mot de passe.</li>					<li>Cliquez sur le bouton "Valider".</li>					<li>Et voilà, vous êtes connectés et votre nouveau mot de passe est mémorisé!.</li>				</ul>			</div>		</div>		<img src="/design/images/mascotte.png" alt="Mascotte du site"></img><br/><br/>		<a href="/">Retour à l'accueil</a>		<br/>	</center></div><?php getFoot(); ?>