<?php
class user_model extends CI_Model {

    public function __construct() {
        $this -> load -> database();
    }

    /*
     * function check_user takes the Username and transforme it to lowercase + take the hased and salted PW
     * returns if exists the userID
     */
    public function getUserIDByIdentifier($identifier = FALSE) {

        if ($identifier == FALSE ) {
            return FALSE;
        }

        //first step, get the Salt from DB
        $query = "SELECT ID from `user` WHERE Identifier='" . $identifier . "';";

        $DBAnswer = $this -> db -> query($query);

        if ($tmp = $this -> db -> affected_rows() == 1) {
            $DBAnswer = $DBAnswer -> result_array();
	        return $DBAnswer[0]['ID'];
            
        }// wenn es weniger oder mehr als ein result kommt, abbrechen
		else {
			return False;
		}

    }

    public function getIDfromUsername($userName = FALSE) {
        if ($userName == FALSE) {
            return FALSE;
        }

        $userName = strtolower($userName);

        $query = "SELECT ID FROM `user` WHERE UserName='$userName'";

        $DBAnswer = $this -> db -> query($query);

        if ($tmp = $this -> db -> affected_rows() != 1) {
            return FALSE;
        }// wenn es weniger oder mehr als ein result kommt, abbrechen

        $DBAnswer = $DBAnswer -> result_array();

        return $DBAnswer[0]['ID'];
    }

    public function addUser($userName = FALSE, $vorname = FALSE, $nachname = FALSE,$identifier = FALSE) {
        if (!$userName || !$identifier) {
            return FALSE;
        }
		
        $query = "INSERT INTO `user` (ID, UserName, Name, Vorname, Identifier) VALUES (null,'$userName', '$vorname', 'nachname', '$identifier');";

        $DBAnswer = $this -> db -> query($query);

        if (count($DBAnswer)>0) {
            return $this -> db -> insert_id();
        } else {
            return FALSE;
        }
    }

    public function deleteUser($userID = FALSE) {
        if ($userID == FALSE) {
            return FALSE;
        }

        if (!is_numeric($userID)) {
            $userID = $this -> getIDfromUsername($userID);
        }

        if ($userID == 0) {
            return FALSE;
        }

        $query = "DELETE FROM `user` WHERE ID = $userID";

        $DBAnswer = $this -> db -> query($query);

        if ($this -> db -> affected_rows() != 1) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function getCountOfusers() {

        $query = "SELECT COUNT(ID) AS ANZAHL FROM `user`;";

        $DBAnswer = $this -> db -> query($query);

        $DBAnswer = $DBAnswer -> result_array();

        if (count($DBAnswer)>0) {
            return $DBAnswer[0]['ANZAHL'];
        } else {
            return FALSE;
        }
        return $data;
    }

    public function getAlluser($limitStart = 0, $limitStop = 100) {
        if (!is_numeric($limitStart) || !is_numeric($limitStop)) {
            return FALSE;
        }

        $query = "SELECT ID, UserName FROM `user` LIMIT $limitStart,$limitStop;";

        $DBAnswer = $this -> db -> query($query);

        $DBAnswer = $DBAnswer -> result_array();

        if (count($DBAnswer)>0) {
            return $DBAnswer;
        } else {
            return FALSE;
        }
        return $data;
    }

}
?>
