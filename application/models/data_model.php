<?php
//define ( 'DEBUG', TRUE);
   class Data_model extends CI_Model 
   {
   	
	public function __construct() 
	{
       $this -> load -> database();
    }
	
	public function getLastPositions()
	{
		$query = "SELECT `Latitude`,`Longitude`, `TimeStamp` 
				  FROM `location` 
				  ORDER BY  `TimeStamp` DESC 
				  LIMIT 1";
		
		$DBAnswer = $this -> db -> query($query);
        $DBAnswer = $DBAnswer -> result_array();
		
        if (count($DBAnswer)>0)
		{
            return $DBAnswer;
        } else {
            return FALSE;
        }
		
	}	
	
	public function getAreaValues($userID, $startTime, $endTime)
	{
			
		$query = "SELECT  `Latitude`,`Longitude`, `TimeStamp`
				 FROM  `location` 
				 WHERE  `UserID` = '$userID'
				 AND  `TimeStamp` >=  '$startTime'
				 AND  `TimeStamp` <=  '$endTime'
 				 ORDER BY  `TimeStamp`";
 
		$DBAnswer = $this -> db -> query($query);
        $DBAnswer = $DBAnswer -> result_array();
		
        if (count($DBAnswer)>0) 
        {
            return $DBAnswer;
        } else {
            return FALSE;
        }	
	}
	
	public function putPosition($lat, $lon, $userID)
	{
		if ( !is_numeric($lat) || !is_numeric($lon)) 
		{
			echo "Values not Numeric";
        	return FALSE;
        }
        
		$query = 	"INSERT INTO `location` (`ID`, `UserID`, `Latitude`, `Longitude`, `TimeStamp`)".
						"VALUES (NULL , '$userID', '$lat', '$lon', now());";

		
		If (defined('DEBUG')) {
            echo '<div id="debug">';
            echo "<p>SQL Query PutValue</p>";
            echo "<p>SQL Query: " . $query . '</p>';
            echo '</div>';
        }
				
        $DBAnswer = $this -> db -> query($query);

        if (count($DBAnswer)>0) 
        {
            return TRUE; //$this -> db -> insert_id();
        } else {
            return FALSE;
        }
	}
	
}

?>
