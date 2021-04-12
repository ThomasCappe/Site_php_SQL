	<?php

			//Vérification et création d'un json avec toutes les reservations au mois ou au jour.
			if ($_GET['Check']!=null){
				if ($_GET['jour']!=null){
					$mysqli = new mysqli("localhost", "pi", "raspberry", "tennis");
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
					$mysqli = new mysqli("localhost", "pi", "raspberry", "tennis");
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
							'Id_Joueur1' => $ligne['Identifiant_1'],
							'Id_Joueur2' => $ligne['Identifiant_2'],
							'Terrain' => $ligne['Terrain'],
						));
					}
					$mysqli->close();
				}
				echo json_encode($response);
			}

			//Ajout d'une reservation dans la BDD.
			if ($_GET['Reservation']!=null){
				$mysqli = new mysqli("localhost", "pi", "raspberry", "tennis");
				$mysqli -> set_charset("utf8");
				$requete = "INSERT INTO Reservation (Mois,Jour,Heure,Terrain,Identifiant_1,Identifiant_2) VALUES ('".$_GET['mois']."','".$_GET['jour']."','".$_GET['heure']."','".$_GET['terrain']."','".$_GET['id_joueur1']."',".$_GET['id_joueur2'].")";
				$resultat = $mysqli -> query($requete);
                                $response=array('Resusltat'=>true);
				$mysqli->close();
                                echo json_encode($response);
			}

			//Verification du mot de passe
			if ($_GET['Identification']!=null){
				$mysqli = new mysqli("localhost", "pi", "raspberry", "tennis");
				$mysqli -> set_charset("utf8");
				$requete = "SELECT MotDePasse,Id,Admin FROM Utilisateurs WHERE Identifiant= '".$_GET['identifiant']."'";
				$resultat = $mysqli -> query($requete);
				$response = array('Verification'=>false);
				while ($ligne = $resultat -> fetch_assoc()) {
					if($ligne['MotDePasse']==$_GET['MotDePasse']){
						$response=array(
						'Verification' =>true,
						'id' => $ligne['Id'],
                                                'admin'=>$ligne['Admin']
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
                        //Liste des utilisateurs
                        if ($_GET['Liste_Joueurs']!=null){
                                $mysqli = new mysqli("localhost", "pi", "raspberry", "tennis");
                                $mysqli -> set_charset("utf8");
                                $requete = "SELECT Identifiant,Id FROM Utilisateurs ";
                                $resultat = $mysqli -> query($requete);
                                $response = array();
                                while ($ligne = $resultat -> fetch_assoc()) {
                                        array_push($response,array(
                                        'Identifiant'=>$ligne['Identifiant'],
                                        'Id'=>$ligne['Id'],
                                        ));
                                }
                                $mysqli->close();
                                echo json_encode($response);
                        }
                        //Ajout d'un utilisateur dans la BDD.
                        if ($_GET['NewUtilisateur']!=null){
                                $mysqli = new mysqli("localhost", "pi", "raspberry", "tennis");
                                $mysqli -> set_charset("utf8");
                                $requete = "INSERT INTO Utilisateurs (Prenom,Nom,Identifiant,DateDeNaissance,MotDePasse,Email,Tel) VALUES ('".$_GET['prenom']."','".$_GET['nom']."','".$_GET['identifiant']."','".$_GET['DateNaissance']."','".$_GET['motdepasse']."','".$_GET['mail']."',".$_GET['tel'].")";
                                $resultat = $mysqli -> query($requete);
                                while ($ligne = $resultat -> fetch_assoc()) {
                                        echo 'Envoi effectué';
                                }
                                $mysqli->close();
                        }
                        //Demande de requete
                        if ($_GET['Requete']!=null){
                                $mysqli = new mysqli("localhost", "pi", "raspberry", "tennis");
                                $mysqli -> set_charset("utf8");
                                $requete = "UPDATE Utilisateurs SET Requete= ".$_GET['etatReq']." WHERE Id='".$_GET['Id']."'";
                                $resultat = $mysqli -> query($requete);
                                $mysqli->close();

                                $mysqli = new mysqli("localhost", "pi", "raspberry", "tennis");
                                $mysqli -> set_charset("utf8");
                                $requete2 = "SELECT Code FROM Utilisateurs WHERE Id= '".$_GET['Id']."'";
                                $resultat = $mysqli -> query($requete2);
                                while($ligne=$resultat-> fetch_assoc()){
                                        $response=array('Code'=>$ligne['Code']);
                                }
                                $mysqli->close();
                                echo json_encode($response);
                        }
                        //Demande l'etat de l'acces 
                        if ($_GET['Acces']!=null){
                                $mysqli = new mysqli("localhost", "pi", "raspberry", "tennis");
                                $mysqli -> set_charset("utf8");
                                $requete = "UPDATE Utilisateurs SET Acces_Auth= ".$_GET['etatAcces']." WHERE Id='".$_GET['Id']."'";
                                $resultat = $mysqli -> query($requete);
                                $mysqli->close();
                        }
                        //Enregistrement du score
                        if ($_GET['Rec_score']!=null){
                                $mysqli = new mysqli("localhost", "pi", "raspberry", "tennis");
                                $mysqli -> set_charset("utf8");
                                $requete = "UPDATE Reservation SET Res_1='".$_GET['res']."' WHERE Identifiant_1='".$_GET['Identifiant_1']."'AND Identifiant_2='".$_GET['Identifiant_2']."'AND mois='".$_GET['mois']."'AND jour='".$_GET['jour']."'";
                                echo($requete);
                                $resultat = $mysqli -> query($requete);
                                $mysqli->close();
                        }
                        //Lecture du score
                        if ($_GET['ViewScore']!=null){
                                $mysqli = new mysqli("localhost", "pi", "raspberry", "tennis");
                                $mysqli -> set_charset("utf8");
                                $requete = "SELECT Res_1 FROM Reservation WHERE Identifiant_1='".$_GET['Identifiant_1']."'AND Identifiant_2='".$_GET['Identifiant_2']."'AND mois='".$_GET['mois']."'AND jour='".$_GET['jour']."'";
                                $resultat = $mysqli -> query($requete);
                                while($ligne=$resultat-> fetch_assoc()){
                                        $response=array('Resultat'=>$ligne['Res_1']);
                                }
                                $mysqli->close();
                                echo json_encode($response);
                        }
			?>


