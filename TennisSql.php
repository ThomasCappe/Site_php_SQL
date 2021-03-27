<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org"lang="fr">

<head>
	<?php

			//Vérification et création d'un json avec toutes les reservations au mois ou au jour.
			if ($_GET['Check']!=null){
				if ($_GET['jour']!=null){
					$mysqli = new mysqli("localhost", "thomas", "mdp", "tennis");
					$mysqli -> set_charset("utf8");
					$requete = "SELECT * FROM Reservation WHERE Mois= ".$_GET['mois']." AND Jour= ".$_GET['jour'];
					$resultat = $mysqli -> query($requete);
					$response = array();
					while ($ligne = $resultat -> fetch_assoc()) {
						array_push($response,array(
							'id' => $ligne['Id'],
							'mois' => $ligne['Mois'],
							'jour' => $ligne['Jour'],
							'Heure' => $ligne['Heure'],
							'Id_Joueur1' => $ligne['Id_Joueur1'],
							'Id_Joueur2' => $ligne['Id_Joueur2'],
							'Terrain' => $ligne['Terrain'],
						));
					}
					$mysqli->close();
				}else{
					$mysqli = new mysqli("localhost", "thomas", "mdp", "tennis");
					$mysqli -> set_charset("utf8");
					$requete = "SELECT * FROM Reservation WHERE Mois= ".$_GET['mois'];
					$resultat = $mysqli -> query($requete);
					$response = array();
					while ($ligne = $resultat -> fetch_assoc()) {
						array_push($response,array(
							'id' => $ligne['Id'],
							'mois' => $ligne['Mois'],
							'jour' => $ligne['Jour'],
							'Heure' => $ligne['Heure'],
							'Id_Joueur1' => $ligne['Id_Joueur1'],
							'Id_Joueur2' => $ligne['Id_Joueur2'],
							'Terrain' => $ligne['Terrain'],
						));
					}
					$mysqli->close();
				}
				echo json_encode($response);
			}

			//Ajout d'une reservation dans la BDD.
			if ($_GET['Reservation']!=null){
				$mysqli = new mysqli("localhost", "thomas", "mdp", "tennis");
				$mysqli -> set_charset("utf8");
				$requete = "INSERT INTO Reservation (Mois,Jour,Heure,Terrain,Id_Joueur1,Id_Joueur2) VALUES ('".$_GET['mois']."','".$_GET['jour']."','".$_GET['heure']."','".$_GET['terrain']."','".$_GET['id_joueur1']."','".$_GET['id_joueur2']."')";
				$resultat = $mysqli -> query($requete);
				while ($ligne = $resultat -> fetch_assoc()) {
					echo 'Envoi effectué';
				}
				$mysqli->close();
			}

			//Verification du mot de passe
			if ($_GET['Identification']!=null){
				$mysqli = new mysqli("localhost", "thomas", "mdp", "tennis");
				$mysqli -> set_charset("utf8");
				$requete = "SELECT MotDePasse FROM Utilisateur WHERE Identifiant= '".$_GET['identifiant']."'";
				$resultat = $mysqli -> query($requete);
				$response = array();
				while ($ligne = $resultat -> fetch_assoc()) {
					if($ligne['MotDePasse']==$_GET['MotDePasse']){
						$response=array(
						'Verification' =>true,
						);
					}else{
						$response=array(
						'Verification' =>false,
						);
					}
				}
				$mysqli->close();
				echo json_encode($response);
			}
			?>
			</p>
	</head>      
</html>

