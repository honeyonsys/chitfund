<?php
include('methods.php');
$methods = new Methods();

if(!empty($_POST['action']) && $_POST['action'] == 'login') {
	$methods->adminLogin();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addGroup') {
	$methods->addGroup();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getGroupList') {
	$methods->getGroupList();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getGroupSingle') {
	$methods->getGroupSingle();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateGroupInMember') {
	$methods->updateGroupInMember();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addMember') {
	$methods->addMember();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getMemberList') {
	$methods->getMemberList();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getMemberSingle') {
	$methods->getMemberSingle();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getMembersPaymentWithGroup') {
	$methods->getMembersPaymentWithGroup();
}


