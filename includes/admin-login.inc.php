<?php
session_start();
include 'account-class.inc.php';
// require '../vendor/autoload.php'; 
include_once 'dbh.inc.php';

/* Create a new Account object */
$account = new Account();

if (isset($_POST['login'])) {

    if (empty($_POST['userName']) || empty($_POST['password'])) {
        header("Location: ../admin.php?login=empty");
        exit();
    }
    else {
//         try
// {
// 	$newId = $account->addAccount($_POST['userName'], $_POST['password']);
// }
// catch (Exception $e)
// {
// 	echo $e->getMessage();
// 	die();
// }

// echo 'The new account ID is ' . $newId;

        $login = FALSE;

        try
        {
            $login = $account->login($_POST['userName'], $_POST['password']);
        }
        catch (Exception $e)
        {
            // echo $e->getMessage();
            header("Location: ../admin.php?login=error&msg=" . $e->getMessage());
        }

        if ($login)
        {
            // echo 'Authentication successful.<br>';
            // echo 'Account ID: ' . $account->getId() . '<br>';
            // echo 'Account name: ' . $account->getName() . '<br>';
            header("Location: ../admin-panel.php");
        }
        else
        {
            header("Location: ../admin.php?login=fail");
        }
    }

}
else if (isset($_POST['logout'])) {
    try
    {
        $login = $account->sessionLogin();
        
        if ($login)
        {
            // echo 'Authentication successful.';
            // echo 'Account ID: ' . $account->getId() . '<br>';
            // echo 'Account name: ' . $account->getName() . '<br>';
        }
        else
        {
            // echo 'Authentication failed 1.<br>';
        }
        echo $account->logout();
        
        $login = $account->sessionLogin();
        
        if ($login)
        {
            // echo 'Authentication successful.';
            // echo 'Account ID: ' . $account->getId() . '<br>';
            // echo 'Account name: ' . $account->getName() . '<br>';
        }
        else
        {
            // echo 'Authentication failed 2.<br>';
        }
    }
    catch (Exception $e)
    {
        header("Location: ../admin.php?logout=error&msg=" . $e->getMessage());
        exit();
    }

    // echo 'Logout successful.';
    
    
    header("Location: ../admin.php?logout=success");
    exit();
    } 
else {
    header("Location: ../admin.php?logout=error");
    exit();
}
