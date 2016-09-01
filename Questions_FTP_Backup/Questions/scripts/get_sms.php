<?php
include_once("config/db_connect.php");
include_once("sms.inc"); 

$sms = new Sms();

$sms->get_questions();