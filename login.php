<?php
//inclusão arquivo do fw
require_once 'init.php';


//inicio a sessão do php
session_start();

















           
//salva na sessão
$_SESSION["token"] = $accessToken;
$_SESSION["email"] = $email;    
//redireciona
header ("Location: index.php");         
        
