<?php require_once($_SERVER['DOCUMENT_ROOT']."/classes/functions.php");require_once($_SERVER['DOCUMENT_ROOT']."/classes/users.php");
$userClass = new Users();getHeadAdmin();if(isset($_POST['content_mail']) && isset($_POST['subject_mail'])){	if(isset($_POST['is_test']) && ($_POST['is_test']=="1"))		$users = array("gaetan.azema");	else		$users = $userClass->getUsersNotSended(MAIL_DAY);	echo "Début des envois...<br/>";	foreach($users as $user){		$mail = $userClass->getMail($user);		echo $mail." : ";		$content_final = str_replace("{user}", $user, $_POST['content_mail']);		if(sendMail($mail, $_POST['subject_mail'], $content_final)){			$userClass->markAsSended($user);			echo "OK<br/>";		}else{			echo "Erreur !";			if(!empty($error))				echo $error;			echo "<br/>";		}	}}else{	echo "Erreur de remplissage du formulaire!";}?><br/><a href="/admin/">Retour à la console d'administration</a><?php getFootAdmin();?>