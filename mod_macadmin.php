<?php
defined('_JEXEC') or die('Access denied');
require(dirname(__FILE__).DS.'helper.php');
$formpage=JURI::current();
if(isset($_POST['mac_send'])) {
	$jinput = JFactory::getApplication()->input;
	//$mac = ModMACAdmin::convertToMAC($jinput->get('macaddress','','STRING'));
	if(true) {
		echo '<h3 style="color:#1A6E1B;;">MAC znaleziony.</h3>';
		echo print_r(ModMACAdmin::selectData("ab:12:34:56:78:90"));


		echo '<a href="'.$formpage.'">Powrót do formularza</a>';
	}else{
		echo '<h3 style="color:red;">Takiego MAC nie ma w bazie! Spróbuj ponownie.</h3>';
		echo '<a href="'.$formpage.'">Powrót do formularza</a>';
	}
} else {
	require(JModuleHelper::getLayoutPath('mod_macadmin'));
}
?> 
