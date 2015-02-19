<?php
header('Content-Type: text/html; charset=utf-8');

/**
* créer une bdd "contact" avec une tables "users" avec les champs :
*  id, nom, prenom, email, adresse, ville, cp, phon
*/

// Créer une connexion à la base de données "contact"
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'contacts');

try{
	$db_option = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", // On force l'encodage en utf8
            	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // On récupère tous les résultats en tableau associatif
            	PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
		);
	$db = new PDO('mysql:host='.HOST.';dbname='.DB.'', USER, PASS, $db_option);
}catch(Exception $e){
	exit('<b>MYSQL ERREUR DE CONNEXION </b>=>' . $e->getMessage());
}


// Réceptionner les données du formulaire
$dataForm = array();
if(!empty($_POST['nom'])) $dataForm['nom'] = $_POST['nom'];
if(!empty($_POST['prenom'])) $dataForm['prenom'] = $_POST['prenom'];
if(!empty($_POST['email'])) $dataForm['email'] = $_POST['email'];
$dataForm['adresse'] = !empty($_POST['adresse'])?$_POST['adresse']:'';
$dataForm['cp'] = !empty($_POST['cp'])?$_POST['cp']:'';
$dataForm['ville'] = !empty($_POST['ville'])?$_POST['ville']:'';
$dataForm['phone'] = !empty($_POST['phone'])?$_POST['phone']:'';

// Contrôler les champs obligatoires "nom, prenom, email"
echo '<pre>';
print_r($dataForm);
echo '</pre>';

$error = array();
if($_POST){
	if(empty($dataForm['nom'])) $error['nom'] = "<font color=red><b>Le nom est obligatoire</b></font>";
	if(empty($dataForm['prenom'])) $error['prenom'] = "<font color=red><b>Le prénom est obligatoire</b></font>";
	if(empty($dataForm['email'])) $error['email'] = "<font color=red><b>Le nom est obligatoire</b></font>";



// Créer une requête d'insertion PDO avec les données du formulaire
	if(empty($error)){
		$sql = 'INSERT INTO contact (nom, prenom, email, adresse, ville, cp, phone) VALUES (:nom, :prenom, :email, :adresse, :ville, :cp, :phone)';
		$query = $db->prepare($sql);
		foreach ($dataForm as $key => $data) {
			$query->bindValue($key, $data);
		}

		$query->execute();
	}
}
// Créer un fichier contacts.php qui va afficher la liste des contacts dans un table html

?>

<form action="form_contact.php" method="POST">

	Nom : <input type="text" size="20" name="nom" value="<?= isset($dataForm['nom'])?$dataForm['nom']:'' ?>"> <?= isset($error['nom'])?$error['nom']:'' ?><br><br>
	
	Prenom : <input type="text" size="20" name="prenom" value="<?= isset($dataForm['prenom'])?$dataForm['prenom']:'' ?>"> <?= isset($error['prenom'])?$error['prenom']:'' ?><br><br>

	Email : <input type="text" size="40" name="email" value="<?= isset($dataForm['email'])?$dataForm['email']:'' ?>"> <?= isset($error['email'])?$error['email']:'' ?><br><br>

	Adresse : <input type="text" size="60" name="adresse"><br><br>

	CP : <input type="text" size="10" name="cp"><br><br>

	Ville : <input type="text" size="10" name="ville"><br><br>
	
	Telephone : <input type="text" size="20" name="phone"><br><br>

	<input type="submit" value="Envoyer">

</form>