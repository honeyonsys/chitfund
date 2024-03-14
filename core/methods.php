<?php
session_start();
class Methods {	
    protected $hostName = 'localhost';
    protected $userName = 'root';
    protected $password = '';
	protected $dbName = 'chitfund';
	private $userTable = 'users';
	private $groupTable = 'groups';
	private $membersTable = 'members';
	private $paymentTable = 'payments';
    private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 		
			$conn = new mysqli($this->hostName, $this->userName, $this->password, $this->dbName);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            } else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}	
	public function adminLoginStatus (){
		if(empty($_SESSION["adminUserid"])) {
			header("Location: index.php");
		}
	}
	public function isLoggedin (){
		if(!empty($_SESSION["adminUserid"])) {	
			return true;
		} else {
			return false;
		}
	}
	public function adminLogin(){		
		$errorMessage = '';
		if($_POST["email"]!=''&& $_POST["password"]!='') {	
			$email = $_POST['email'];
			$password = $_POST['password'];
			$sqlQuery = "SELECT * FROM ".$this->userTable." 
				WHERE Email='".$email."' AND Password='".md5($password)."' AND Status = '1'";
			$resultSet = mysqli_query($this->dbConnect, $sqlQuery) or die("error".mysql_error());
			$isValidLogin = mysqli_num_rows($resultSet);	
			if($isValidLogin){
				$userDetails = mysqli_fetch_assoc($resultSet);
				$_SESSION["adminUserid"] = $userDetails['ID'];
				$_SESSION["admin"] = $userDetails['Name'];
				//header("location: dashboard.php"); 		
                $errorMessage = 'success';
			} else {		
				$errorMessage = "Invalid login!";		 
			}
		} else if(!empty($_POST["login"])){
			$errorMessage = "Enter Both user and password!";	
		}
		echo $errorMessage; 		
	}


    public function addGroup() {
        if (isset($_POST['groupname']) && isset($_POST['groupamount'])) {
            // Check if groupId is set, if set, update existing record
            if (isset($_POST['groupId']) && !empty($_POST['groupId'])) {
                $groupId = $_POST['groupId'];
                
                // Prepare SQL statement for updating
                $sql = "UPDATE " . $this->groupTable . " SET Name=?, Amount=?, CreatedDate=?, Status=? WHERE id=?";
                
                // Prepare and bind parameters
                $stmt = $this->dbConnect->prepare($sql);
                $currentDateTime = date("d-m-Y H:i:s");
                $status = 1;
                $stmt->bind_param("sssii", $_POST['groupname'], $_POST['groupamount'], $currentDateTime, $status, $groupId);
            } else {
                // Prepare SQL statement for insertion
                $sql = "INSERT INTO " . $this->groupTable . " (Name, Amount, CreatedDate, Status) VALUES (?, ?, ?, ?)";
                
                // Prepare and bind parameters
                $stmt = $this->dbConnect->prepare($sql);
                $currentDateTime = date("d-m-Y H:i:s");
                $status = 1;
                $stmt->bind_param("sssi", $_POST['groupname'], $_POST['groupamount'], $currentDateTime, $status);
            }
            
            // Execute the statement
            if ($stmt->execute()) {
                $response = array("status" => "success", "message" => "Group " . (isset($groupId) ? "updated" : "added") . " successfully");
            } else {
                $response = array("status" => "error", "message" => "Failed to " . (isset($groupId) ? "update" : "add") . " group");
            }
            
            // Close the statement
            $stmt->close();
        } else {
            $response = array("status" => "error", "message" => "Missing required fields");
        }
        
        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    
    

    public function getGroupList() {
        $sqlQuery = "SELECT * FROM ".$this->groupTable;
        
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $numRows = mysqli_num_rows($result);
        
        $groupList = array();
        while ($group = mysqli_fetch_assoc($result)) {        
            $groupRow = array();
            $groupRow['ID'] = $group['ID'];
            $groupRow['Name'] = $group['Name'];
            $groupRow['Amount'] = $group['Amount'];
            $groupRow['CreatedDate'] = $group['CreatedDate'];
            $groupRow['Status'] = $group['Status'];
            $groupList[] = $groupRow;
        }
        
        // Encode each group individually as JSON
        $jsonResponse = array();
        foreach ($groupList as $group) {
            $jsonResponse[] = json_encode($group);
        }
        
        // Return the response as JSON
        header('Content-Type: application/json');
        echo '[' . implode(',', $jsonResponse) . ']';
    }

    
    public function getGroupSingle() {
        // Check if memberId is set and is numeric
        if(isset($_POST["groupId"]) && is_numeric($_POST["groupId"])) {
            $sqlQuery = "SELECT * FROM ".$this->groupTable." WHERE id = ?";
            $stmt = mysqli_prepare($this->dbConnect, $sqlQuery);
            mysqli_stmt_bind_param($stmt, "i", $_POST["groupId"]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            mysqli_stmt_close($stmt);
            if($row) {
                header('Content-Type: application/json');
                echo json_encode($row);
            } else {
                echo json_encode(array("error" => "No group found with the provided ID"));
            }
        } else {
            echo json_encode(array("error" => "Invalid groupId"));
        }
    }

    public function addMember() {
        // Check if all required fields are set
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zip']) && isset($_POST['group'])) {
            
            // Check if editId is set, if set, update existing record
            if(isset($_POST['editId']) && !empty($_POST['editId'])) {
                $editId = $_POST['editId'];
                
                // Prepare SQL statement for updating
                $sql = "UPDATE ".$this->membersTable." SET GroupID=?, Name=?, Email=?, Phone=?, Address=?, City=?, State=?, Zip=?, ContributionAmount=?, Status=? WHERE id=?";
                
                // Prepare and bind parameters
                $stmt = $this->dbConnect->prepare($sql);
                $stmt->bind_param("isssssssssi", $_POST['group'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['contributionAmount'], $_POST['status'], $editId);
            } else {
                // Prepare SQL statement for insertion
                $sql = "INSERT INTO ".$this->membersTable." (GroupID, Name, Email, Phone, Address, City, State, Zip, ContributionAmount, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                // Prepare and bind parameters
                $stmt = $this->dbConnect->prepare($sql);
                $stmt->bind_param("isssssssss", $_POST['group'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['contributionAmount'], $_POST['status']);
            }
            
            // Execute the statement
            if ($stmt->execute()) {
                $response = array("status" => "success", "message" => "Member ". (isset($editId) ? "updated" : "added") ." successfully");
            } else {
                $response = array("status" => "error", "message" => "Failed to ". (isset($editId) ? "update" : "add") ." member");
            }
            
            // Close the statement
            $stmt->close();
        } else {
            $response = array("status" => "error", "message" => "Missing required fields");
        }
        
        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function updateGroupInMember() {
        if(isset($_POST['memberId']) && isset($_POST['groupId'])) {
            $sql = "UPDATE ".$this->membersTable." SET GroupID=? WHERE id=?";
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->bind_param("ii", $_POST['groupId'], $_POST['memberId']);
            if ($stmt->execute()) {
                $response = array("status" => "success", "message" => "Member updated successfully");
            } else {
                $response = array("status" => "error", "message" => "Failed to member");
            }
            // Close the statement
            $stmt->close();
        }
    }
    
    public function getMemberList() {
        $sqlQuery = "SELECT members.*, groups.Name as GroupName FROM ".$this->membersTable ." JOIN groups ON members.GroupId = groups.ID";
        
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $numRows = mysqli_num_rows($result);
        
        $memberList = array();
        while ($group = mysqli_fetch_assoc($result)) {        
            $memberRow = array();
            $memberRow['ID'] = $group['ID'];
            $memberRow['GroupID'] = $group['GroupID'];
            $memberRow['GroupName'] = $group['GroupName'];
            $memberRow['Name'] = $group['Name'];
            $memberRow['Email'] = $group['Email'];
            $memberRow['Phone'] = $group['Phone'];
            $memberRow['Address'] = $group['Address'];
            $memberRow['City'] = $group['City'];
            $memberRow['State'] = $group['State'];
            $memberRow['Zip'] = $group['Zip'];
            $memberRow['ContributionAmount'] = $group['ContributionAmount'];
            $memberRow['Status'] = $group['Status'];
            $memberList[] = $memberRow;
        }
        
        // Encode each group individually as JSON
        $jsonResponse = array();
        foreach ($memberList as $member) {
            $jsonResponse[] = json_encode($member);
        }
        
        // Return the response as JSON
        header('Content-Type: application/json');
        echo '[' . implode(',', $jsonResponse) . ']';
    }
    
    public function getMemberSingle() {
        // Check if memberId is set and is numeric
        if(isset($_POST["memberId"]) && is_numeric($_POST["memberId"])) {
            $sqlQuery = "SELECT * FROM ".$this->membersTable." WHERE id = ?";
            $stmt = mysqli_prepare($this->dbConnect, $sqlQuery);
            mysqli_stmt_bind_param($stmt, "i", $_POST["memberId"]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            mysqli_stmt_close($stmt);
            if($row) {
                header('Content-Type: application/json');
                echo json_encode($row);
            } else {
                echo json_encode(array("error" => "No member found with the provided ID"));
            }
        } else {
            echo json_encode(array("error" => "Invalid memberId"));
        }
    }
    
    public function getMembersPaymentWithGroup() {
        if(isset($_POST['groupId'])) {
            $sqlQuery = "SELECT members.*, groups.Name as GroupName, groups.Amount as GroupAmount, groups.CreatedDate as GroupCreatedDate FROM ".$this->membersTable ." JOIN groups ON members.GroupId = groups.ID WHERE members.GroupId = ". $_POST['groupId'];
            $result = mysqli_query($this->dbConnect, $sqlQuery);
            $numRows = mysqli_num_rows($result);
            
            $memberList = array();
            while ($group = mysqli_fetch_assoc($result)) {        
                $memberRow = array();
                $memberRow['ID'] = $group['ID'];
                $memberRow['GroupID'] = $group['GroupID'];
                $memberRow['GroupName'] = $group['GroupName'];
                $memberRow['GroupAmount'] = $group['GroupAmount'];
                $memberRow['GroupCreatedDate'] = $group['GroupCreatedDate'];
                $memberRow['Name'] = $group['Name'];
                $memberRow['Email'] = $group['Email'];
                $memberRow['Phone'] = $group['Phone'];
                $memberRow['Address'] = $group['Address'];
                $memberRow['City'] = $group['City'];
                $memberRow['State'] = $group['State'];
                $memberRow['Zip'] = $group['Zip'];
                $memberRow['ContributionAmount'] = $group['ContributionAmount'];
                $memberRow['Status'] = $group['Status'];
                $memberList[] = $memberRow;
            }
            
            // Encode each group individually as JSON
            $jsonResponse = array();
            foreach ($memberList as $member) {
                $jsonResponse[] = json_encode($member);
            }
            
            // Return the response as JSON
            header('Content-Type: application/json');
            echo '[' . implode(',', $jsonResponse) . ']';           
        }
    }
}