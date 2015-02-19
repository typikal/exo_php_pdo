<?php

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

$sql = 'SELECT * FROM contact';
$query = $db->prepare($sql);
$query->execute();
$results = $query->fetchAll();

?>

<table border="1" cellpadding="10">
	<thead>
		<tr>
			<th>Nom</th>
			<th>Prenom</th>
			<th>Email</th>
			<th>Adresse</th>
			<th>CP</th>
			<th>Ville</th>
			<th>Phone</th>			
		</tr>	
	</thead>

	<tbody>
		<?php
			foreach ($results as $result) {

				echo '<tr><td>'.$result['nom'].'</td>';
				echo '<td>'.$result['prenom'].'</td>';
				echo '<td>'.$result['email'].'</td>';
				echo '<td>'.$result['adresse'].'</td>';
				echo '<td>'.$result['cp'].'</td>';
				echo '<td>'.$result['ville'].'</td>';
				echo '<td>'.$result['phone'].'</td></tr>';
			}
		?>
		
	<tbody>
</table>