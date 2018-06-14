<?php
class Bidder {
    public $bidderid;
    public $lastname;
    public $firstname;
    public $address;
    public $phone;

    function __construct($bidderid, $lname, $fname, $address, $phone) {
        $this->bidderid = $bidderid;
        $this->lastname = $lname;
        $this->firstname = $fname;
        $this->address = $address;
        $this->phone = $phone;
    }

    function __toString() {
        $output = "<h2>Bidder Number: $this->bidderid</h2>\n" .
                "<h2>$this->lastname, $this->firstname</h2>\n" .
                "<h2>$this->address</h2>\n" .
                "<h2>$this->phone</h2>\n";
        return $output;
    }

    function saveBidder() {
        include("../config/config.php");
        $conn = new mysqli($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
        if (mysqli_connect_errno()) {
            echo ('Connection failed: ' . mysqli_connect_error());
            exit();
        }
        $query = "INSERT INTO bidders VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            trigger_error('Wrong SQL: ' . $query . ' Error: ' . $conn->error, E_USER_ERROR);
        }

        $stmt->bind_param("issss", 
            $Bidderid, 
            $Lastname, 
            $Firstname,
            $Address,
            $Phone);
           
            $Bidderid = $this->bidderid;
            $Lastname = $this->lastname;
            $Firstname = $this->firstname;
            $Address = $this->address;
            $Phone = $this->phone; 

        $result = $stmt->execute();

        $stmt->close();
        $conn->close();
        return $result;
    }

    function updateBidder() {
        include("../config/config.php");        
        $db = new mysqli($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
        $query = "UPDATE bidders SET bidderid = ?, lastname = ?, firstname = ?, " .
                    "address = ?, phone = ? " .
                    "WHERE bidderid = $this->bidderid";
        $stmt = $db->prepare($query);
        $stmt->bind_param("issss", $this->bidderid, $this->lastname, $this->firstname,
                $this->address, $this->phone);
        $result = $stmt->execute();
        $db->close();
        return $result;                
    }

    function removeBidder() {
        include("../config/config.php");
        $db = new mysqli($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
        $query = "DELETE FROM bidders WHERE bidderid = $this->bidderid";
        $result = $db->query($query);
        $db->close();
        return $result;
    }

    static function getBidders() {
        include("../config/config.php");
        $db = new mysqli($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
        $query = "SELECT * FROM bidders";
        $result = $db->query($query);
        if (mysqli_num_rows($result) > 0) {
            $bidders = array();
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $bidder = new Bidder($row['bidderid'], $row['lastname'], $row['firstname'],
                            $row['address'], $row['phone']);
                array_push($bidders, $bidder);
                unset($bidder);
            }
            $db->close();
            return $bidders;
        } else {
            $db->close();
            return NULL;
        }
    }

    static function findBidder($bidderid) {
        include("../config/config.php");
        $db = new mysqli($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
        if (mysqli_connect_errno()) {
            echo ('Connection failed: ' . mysqli_connect_error());
            exit();
        }        
        $query = "SELECT * FROM bidders WHERE bidderid = $bidderid";
        $result = $db->query($query);       
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row) {
            $bidder = new Bidder($row['bidderid'], $row['lastname'], $row['firstname'],
                        $row['address'], $row['phone']);
            $db->close();
            return $bidder;
        } else {
            $db->close();
            return NULL;           
        }
    }

    static function getTotalBidders() {
        include("../config/config.php");
        $db = new mysqli($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
        $query = "SELECT count(bidderid) FROM bidders";
        $result = $db->query($query);
        $row = $result->fetch_array();
        if ($row) {
            return $row[0];
        } else {
            return NULL;
        }
    }
}
?>