<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//define ( 'DEBUG', TRUE);
/*
 * Dieser Controller enthällt den funktionen welche zur Datenausgabe benötigt werden.
 * Die Datenausgabe erfolgt im Json format
*/

class data extends CI_Controller {

	public function __construct()
    {
    	parent::__construct();
        // Your own constructor code
        
        //Models laden
        $this -> load -> model('Data_model');
		$this -> load -> model('User_model');
		
    }
	// hallo world
	public function index()
	{
		echo 'Hello World!';
	}
	
	public function addUser($userName,$vorname,$nachname,$identifire)
	{
		 	if(!$this -> User_model ->getUserIDByIdentifier($identifire) )
			{
		 		$value = $this -> User_model ->addUser($userName, $vorname, $nachname, $identifire);
		 		echo '{"value":'.$value.'}';
			}
			else
			{
				echo '{"error":"Identifire exist in Database."}';
			}
	}
	
	public function putPosition($lat, $lon, $identifire)
	{
		if ($userID = $this -> User_model ->getUserIDByIdentifier($identifire))
		{
			$value = $this -> Data_model ->putPosition($lat, $lon, $userID);
			echo '{"value":'.$value.'}';
		}
		else {
			echo '{"error":"Identifire not exist in Database."}';
		}
	
	}
	
	public function getLastPositions()
	{
		$data = $this -> Data_model ->getLastPositions();
		echo json_encode($data);
	}
}
?>