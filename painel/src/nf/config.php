<?php

include("/appinc/cBarb.php");

// CONEXAO PDO MySQL
$PDO = new PDO("mysql:host={$cBarb['banco']['HOST']};dbname={$cBarb['banco']['DATABASE']};charset=utf8", "{$cBarb['banco']['USERNAME']}", "{$cBarb['banco']['PASSWORD']}");

// ENDEREÇO DA API
$endpoint = "http://nf.mohatron.com/API-NFE/api-nfe/"; // COM BARRA NO FINAL


ini_set('display_errors', 'On');
