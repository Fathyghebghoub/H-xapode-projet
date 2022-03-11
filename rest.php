<?php


    ini_set('display_errors', 1);   
    ini_set('display_startup_errors', 1);   
    error_reporting(E_ALL);   


	include_once('model.php');
	$id=ConnectDB();

	$req_type=$_SERVER['REQUEST_METHOD'];
	$req_path=$_SERVER['PATH_INFO'];

	$req_data=explode('/',$req_path);

	$header=apache_request_headers();


////////////////////////////////////////////////////////////////////////////////
/////////////////////////// Requête HTTP : GET //////////////////////////////////
if($req_type==='GET'){
if($req_data['1']=='PARCOURS'&&empty($req_data['2'])){
	  // Je cherche plus d'information sur les parcours
	  $reqNBparcours = "SELECT Count(idPARCOURS) as nbparcours FROM PARCOURS";
	  $resNBparcours=exectuterRequete($id,$reqNBparcours,array());
	  
	  $reqNButilisateur = "SELECT Count(idUtilisateur) as nbutilisateur FROM Utilisateur"; 
	  $resNButilisateur =exectuterRequete($id,$reqNButilisateur,array());
	  
	  $reqNBmvt = "SELECT Count(idMvt) as nbmvt FROM Mvt";
	  $resNBmvt=exectuterRequete($id,$reqNBmvt,array());
	  
	  $reponseAPI['nbparcours'] = $resNBparcours[0]['nbparcours'];
	  $reponseAPI['nbutilisateur'] = $resNButilisateur[0]['nbutilisateur'];
	  $reponseAPI['nbmvt'] = $resNBmvt[0]['nbmvt'];
	  } 

	  	if(isset($req_data['2'] )&& $req_data['2']=='nbparcours')
			{
			  $reqttnbparcours = "SELECT *  FROM PARCOURS";
			  $resttnbparcours=exectuterRequete($id,$reqttnbparcours,array());
			  for($i=0; $i<count($resttnbparcours); $i++)
			  {
				$reponseAPI[$i] = $resttnbparcours[$i]; 
			  }
			}
		
		echo(json_encode($reponseAPI));
}

/////////////////////////// Requête HTTP : POST ////////////////////////////////
if($req_type==='POST'){
		if($req_data['1']=='PARCOURS'){ 					// Insérer un vol
			

			$donneesParcoursAssoc=json_decode(file_get_contents("php://input"),true);

			//$donneesParcoursAssoc=$donneesParcoursJSON['Avancer'];
			//print_r( $donneesParcoursAssoc);
			echo "<br>";
			
			
			// J'extrais les données du json ==> $Identifiant,$time,$etats et $commandes
				//foreach($donneesParcoursAssoc as $v)
				//	$$c=$v;
				//	foreach ($v as $Key => $Value) 
					//		$Key=$Value;
				//print_r($donneesParcoursAssoc["Utilisateur"]);	
				//print_r(array_values($v)); 
				//print_r(array_values($donneesParcoursAssoc)); 
				//echo $Key; 
				//echo  $Value;
				//print_r($v["Identifiant"]);
					//echo "<br>".$Value."<br>";
 
			$reqUtilisateur="select idUtilisateur from Utilisateur where Identifiant=?";
			$res=exectuterRequete($id,$reqUtilisateur,array($donneesParcoursAssoc["Utilisateur"]["0"]["Identifiant"]));
			//print_r($donneesParcoursAssoc);
				if(empty($res)){
					$reqUtilisateur="INSERT into Utilisateur (Identifiant) values(?)";
					$rep=preparerRequete($id,$reqUtilisateur);
					exectuterRequetePrepare($rep,array($Identifiant));
					$idutilisateurs=recupererLeDernierIdInserer($id);
				}
				//echo "<br>".$v["idUtilisateur"]."<br>";


			
			//PUT	/*$reqidParcours="select idParcours from PARCOURS where idUtilisateur=?";
				/*$residParcours=exectuterRequete($id,$reqidParcours,array($v["idUtilisateur"]));*/

			//	echo "<br>".$Value["idUtilisateur"];
						;
						//print_r($donneesParcoursAssoc["infoPARCOURS"]);
					$reqidParcours="Insert into PARCOURS(idUtilisateur,nomParcours) values(?,?)";
					$rep=preparerRequete($id,$reqidParcours);
					exectuterRequetePrepare($rep,array($donneesParcoursAssoc["infoPARCOURS"]["0"]["idUtilisateur"],$donneesParcoursAssoc["infoPARCOURS"]["0"]["nomParcours"]));
					$idParcours=recupererLeDernierIdInserer($id);

					//echo "<br>".$v["nomParcours"]."<br>";

			//PUT		/*$reqTestMvt="select idPARCOURS from Mvt where idPARCOURS=?";
				//	$resTestMvt=exectuterRequete($id,$reqTestMvt,array($idParcours));*/
					//print_r($donneesParcoursAssoc["infoMvt"]["0"]);	
					foreach ($donneesParcoursAssoc["infoMvt"]["0"] as $v) {
						echo "<br>";
						print_r($v);
					}
					$reqMvt="Insert into Mvt(idPARCOURS, Mvt, TimingMvt, ValMvt)
					values(?,?,?,?)";
					//values(:idvol,:pitch,:roll,:yaw,:vgx,:vgy,:vgz,:templ,:temph,:tof,:h,:bat,:baro,:time,:agx,:agy,:agz)";
					
					$resMvt=preparerRequete($id,$reqMvt);
					
				//	echo $idParcours."<br>";
				//	echo $v["Mvt"]."<br>";
				//	echo $v["TimingMvt"]."<br>";
				//	echo $v["ValMvt"];
					$tableauDeDonneesMvt = array($idParcours,$donneesParcoursAssoc["infoMvt"]["0"]["Mvt"],$donneesParcoursAssoc["infoMvt"]["0"]["TimingMvt"],$donneesParcoursAssoc["infoMvt"]["0"]["ValMvt"]);
					exectuterRequetePrepare($resMvt,$tableauDeDonneesMvt);

					
					
					// BOUCLE OU ON DEMANDE A CHAQUE ENTRER DE MVT SI ON EN RAJOUTE UN OU SI LE PARCOURS EST FINIT 
	
			}
		}
/*
	--------json bon----------
	
{ 
    "Entrer":
        
        {
                "Identifiant":"Fathy",
                "idUtilisateur":"2",
                "Mdp":"fathy",
                "nomParcours":"trop cho",
                "Mvt":"TournerG",
                "TimingMvt":"1",
                "ValMvt":"180"
        }
}
	----JSON clean--------
{ 
    "Utilisateur":
        [
            {
                "Identifiant":"Louis",
                "idUtilisateur":"4",
                "Mdp":"louis"
            }
        ],
     "infoPARCOURS":
        [
            {
                "idUtilisateur":"4",
                "nomParcours":"Test2"
            }
        ],
    "infoMvt":
        [
            {
                "Mvt":"Avancer",
                "TimingMvt":"2",
                "ValMvt":"20"
            },
            {
                "Mvt":"Reculer",
                "TimingMvt":"1",
                "ValMvt":""
            }
        ]
}

*/
////////////////////////////////////////////////////////////////////////////////
/////////////////////////// Requête HTTP : PUT /////////////////////////////////
if($req_type==='PUT'){
	$donneesAssoc=json_decode(file_get_contents("php://input"),true);

}

elseif($req_type==='DELETE'){
	$donneesAssoc=json_decode(file_get_contents("php://input"),true);
}//else
		//echo 'Erreur de requête HTTP';


?>
