<?php
include_once 'dbh.inc.php';

if (isset($_POST['addProduct'])) {
    $query = 
            
    'SELECT * FROM doorbell_designs.account_sessions, doorbell_designs.accounts WHERE (account_sessions.session_id = :sid) ' . 
    'AND (account_sessions.login_time >= (NOW() - INTERVAL 7 DAY)) AND (account_sessions.account_id = accounts.account_id) ' . 
    'AND (accounts.account_enabled = 1)';
    
    /* Values array for PDO */
    $values = array(':sid' => session_id());
    
    /* Execute the query */
    try
    {
        $res = $pdo->prepare($query);
        $res->execute($values);
    }
    catch (PDOException $e)
    {
    /* If there is a PDO exception, throw a standard exception */
    throw new Exception('Database query error');
    }
    
    $row = $res->fetch(PDO::FETCH_ASSOC);
    
    if (is_array($row))
    {}
}
else {
    header("Location: ../admin-panel.php?addProduct=error");
    exit();
}