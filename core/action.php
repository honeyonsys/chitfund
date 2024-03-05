<?php
include('methods.php');
$methods = new Methods();

if(!empty($_POST['action']) && $_POST['action'] == 'addGroup') {
	$methods->addGroup();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getGroupList') {
	$methods->getGroupList();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addMember') {
	$methods->addMember();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getMemberList') {
	$methods->getMemberList();
}
