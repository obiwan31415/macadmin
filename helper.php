<?php
defined('_JEXEC') or die('Access denied');
/*class macAdminComputer {
	private $macaddress; //id
	private $firstname;
	private $lastname;
	private $email;
	private $room;
	private $fixedIP;
	private $comment;

	public function getMACaddress() {
		return $this->macaddress;
	}
	public function getFirstname(){
		return $this->firstname;
	}
	public function getLastname(){
		return $this->lastname;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getRoom(){
		return $this->room;
	}
	public function getFixedIP(){
		return $this->fixedIP;
	}
	public function getComment(){
		return $this->comment;
	}
	public function setMACaddress($mac) {
		$this->macaddress = $this->convertToMAC($mac);
	}
	public function setFirstname($firstname) {
		$this->firstname=$firstname;
	}
	public function setLastname($lastname) {
		$this->lastname=$lastname;
	}
	public function setEmail($email) {
		$this->email=$email;
	}
	public function setRoom($room) {
		$this->room=$room;
	}
	public function setFixedIP($fixedIP) {
		$this->fixedIP=$fixedIP;
	}
	public function setComment($comment) {
		$this->comment=$comment;
	}
	private function convertToMAC($input) {
		$pattern="/^([0-9a-fA-F]{2}[:-]){5}([0-9a-fA-F]{2})$/";
		if(preg_match($pattern,$input) == 1) {
			$chars = explode("-", $input);
		} else { //$pattern =  "/^[0-9a-fA-F]{12}$/"
			$chars = str_split($input, 2);
		}
		$result = implode(":", $chars);
		return strtolower($result);
	}
}
*/
// UPDATE  `joomla`.`f43gp_comp_register` SET  `firstname` =  'Darek',
// `lastname` =  'Dabacki',
// `email` =  'abc',
// `room` =  '123',
// `fixedip` =  'yes' WHERE  `f43gp_comp_register`.`id` =146;

class ModMACAdmin {
	public static function selectData($input, $params) {
		$mac = 'ab:12:34:56:78:90'; //$this->convertToMAC();

		//$db = JFactory::getDBO();
		//$query = $db->getQuery(true);
		//$query->select($db->quoteName(array('macaddress', 'firstname', 'lastname', 'email', 'room', 'fixedip', 'comment')));
		//SELECT `firstname`, `lastname`, `email` FROM `f43gp_comp_register` WHERE `macaddress` = 'ab:12:34:cd:78:ef'
		//$query->select('macaddress');
		//$query->from($db->quoteName('#__comp_register'));
		//$query->where($db->quoteName('macaddress').' = '.'ab:12:34:56:78:90');
		//$query2 = "SELECT `firstname`, `lastname`, `email` FROM  `#__comp_register` WHERE `macaddress` = 'ab:12:34:cd:78:ef'";
		//$db->setQuery($query2);
		//$result = $db->loadRow();
		$result = "dupa";
		return $result;
	}

	private function convertToMAC() {
		/*$pattern1="/^([0-9a-fA-F]{2}[-]){5}([0-9a-fA-F]{2})$/";
		$pattern2="/^([0-9a-fA-F]{2}[:]){5}([0-9a-fA-F]{2})$/";
		if(preg_match($pattern1,$input) == 1) {
			$chars = explode("-", $input);
		} else if(preg_match($pattern2,$input) == 1) {
			$chars = explode(":", $input);
		} else { //$pattern =  "/^[0-9a-fA-F]{12}$/"
			$chars = str_split($input, 2);
		}
		$result = implode(":", $chars);*/
		return "ab:12:34:56:78:90";
		//return strtolower($result);
	}

	public static function updateData($computer, $params) {
		$db = JFactory::getDBO();
		$query="UPDATE `#__comp_register` SET 
				`firstname` = '$firstname',
				`lastname` = '$lastname',
				`email` = '$email',
				`room` = '$room',
				`fixedip` = '$fixedip',
				`comment` = '$comment'
			WHERE 'macaddress' = $macaddress";
				
				// VALUES ('"
				// .$computer->getMACaddress()		."', '"
				// .$computer->getFirstname()		."', '"
				// .$computer->getLastname()		."', '"
				// .$computer->getEmail()			."', '"
				// .$computer->getRoom()			."', '"
				// .$computer->getFixedIP()		."', '"
				// .$computer->getComment()		."')"

		$db->setQuery($query);
		if($db->query()) {
			return true;
		}else{
			return false;
		}
	}

	public static function findMAC($mac) {
		$db=JFactory::getDBO();
		$query="SELECT COUNT(*) FROM `#__comp_register` WHERE macaddress = '$mac'";
		$db->setQuery($query);
		$count = $db->loadResult();
		if($count==0) {
			return false;
		} else {
			return true;
		}
	}

	public static function sendEmailNotification($computer,$params) {
		$mailer=JFactory::getMailer();
		$config=JFactory::getConfig();
		$sender=array($params->get('sender_email'),$params->get('sender_name'));
		$mailer->setSender($sender);
		$mailer->addRecipient($params->get('receiver_email'));
		$mailer->setSubject("Nowy formularz rejestracji komputera.");
		
		$body="<h3>Przysłano nowy formularz rejestracji:</h3><br />";
		$body.="Czas rejestracji: ".date("Y-m-d H:i:s")."<br />";
		$body.="Adres MAC: ".$computer->getMACaddress()."<br />";
		$body.="Stały IP: ".$computer->getFixedIP()."<br />";
		$body.="Użytkownik: ".$computer->getLastname()." ".$computer->getFirstname()."<br />";
		$body.="Email użytkownika: ".$computer->getEmail()."@ippt.pan.pl<br />";
		$body.="Miejsce podłączenia: pokój ".$computer->getRoom()."<br />";
		$body.="Uwagi: ".$computer->getComment()."<br />";
		$body.="<br />";
		$body.="<h3>Wpis do <em>dhcp.conf:</em></h3><br />";
		$body.="<br />";
		$body.="# ".date("d.m.Y")."; ".$computer->getFirstname()." ".$computer->getLastname()
			."; p".$computer->getRoom()."<br />";
		$body.="host "."komp".date("YmdHis")." { hardware ethernet ".$computer->getMACaddress();
		/*if($computer->getFixedIP() == "yes") {
			$body.="; fixed-address 0.0.0.0";
		}*/
		$body.="; }";
		$body.="<br />";

		$mailer->setBody($body);
		$mailer->isHTML(true);
		$mailer->send();
	}
}


?>