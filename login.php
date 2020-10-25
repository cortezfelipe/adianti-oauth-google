<?php
//inclusão arquivo do fw
require_once 'init.php';
//declaração para utilização da classe Graph
use League\OAuth2\Client\Provider\Google;

//inicio a sessão do php
session_start();///

    //chamada a API para autenticar o Token
    $oauthClient = new Google([
    'clientId'                => '77466731204-6obj14kphldhf8nteda7uifue31kjeng.apps.googleusercontent.com',
    'clientSecret'            => 'NNvFiMC2AbyRCzAy3gnGfII0',
    'redirectUri'             => 'http://localhost/adianti-oauth-google/login.php',
    ]);
    
    if (!isset($_GET['code'])) {
    
    $authorizationUrl = $oauthClient->getAuthorizationUrl();

    $_SESSION['oauth2state'] = $oauthClient->getState();

    header('Location: ' . $authorizationUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

    if (isset($_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
    }
    
    exit('Invalid state');

} else {
    
    try {

        //recuperando o token 
        $accessToken = $oauthClient->getAccessToken('authorization_code', [
        'code' => $_GET['code']
        ]);
        
        $usuario = $oauthClient->getResourceOwner($accessToken);

        
        //salva na sessão
        $_SESSION["token"] = $accessToken;
        $_SESSION["email"] = $usuario->getEmail();    
        //redireciona
        header ("Location: index.php");         
        
    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

        // Failed to get the access token or user details.
        exit($e->getMessage());

    }
}