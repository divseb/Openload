<?php 
//
// #Script Remote upload utilisant l'api Openload.co
// #Envoi l'url pour Remote et Récupère Le Lien openload généré.
// #Le cas présent ci-dessous sert à soumettre un lien openload qui n'est pas utilisable car l'uploader d'origine à activer l'anti leech.
// #On génère donc un nouveau lien du même fichier qui cette fois est sous notre contrôle.
// #A noter que dans ce cas ci, il n'y a pas d'attente pour le résultat, si un fichier volumineux est envoyé, il faudra mettre un temps d'attente entre les 2 requêtes curl.
// #La doc de l'api openload: https://openload.co/api
// 

$login = ''; // L'API Login openload
$key = '';   // l'API key openload
$urls = 'https://openload.co/embed/p7FYqml-W1g/e5ffefc8f86b63b229f3b8f5c28021f8'; //Le lien à uploader à distance

	$curl = curl_init();
	$opts = [
		CURLOPT_URL => 'https://api.openload.co/1/remotedl/add?login='.$login.'&key='.$key.'&url='.$url.'', //On envoi l'url
		CURLOPT_RETURNTRANSFER => true,
	];
	curl_setopt_array($curl, $opts);
	$response = json_decode(curl_exec($curl), true);
	
	echo '<pre>';
	print_r($response);//Affichage du json de retour (pour infos)
	echo '</pre>';
	
	$id = $response['result']['id'];
	
	$curl2 = curl_init();
	$opts = [
		CURLOPT_URL => 'https://api.openload.co/1/remotedl/status?login='.$login.'&key='.$key.'&limit=1&id='.$id.'', //on récup les infos de notre dernier remote upload (limit=1)
		CURLOPT_RETURNTRANSFER => true,
	];
	curl_setopt_array($curl2, $opts);
	$response = json_decode(curl_exec($curl2), true);
	
	echo '<pre>';
	print_r($response);//Affichage du json de retour (pour infos)
	echo '</pre>';
	
	$lien = $response['result'][''.$id.'']['url'];
	
	echo $lien;
?>
