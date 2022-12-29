<?php

class Account
{
	private $id; //string or null
	
	private $name; //string or null

	private $authenticated; //boolean
	
	public function __construct()
	{
		$this->id = NULL;
		$this->name = NULL;
		$this->authenticated = FALSE;
	}
	
	public function __destruct()
	{
		
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function isAuthenticated(): bool
    {
        return $this->authenticated;
    }

    public function isNameValid(string $name): bool
    {
        $valid = TRUE;
        $len = mb_strlen($name);
        $MIN_NAME_LENGTH = 4;
        $MAX_NAME_LENGTH = 64;
        
        if (($len < $MIN_NAME_LENGTH) || ($len > $MAX_NAME_LENGTH))
        {
            $valid = FALSE;
        }
        
        return $valid;
    }

    public function isPasswdValid(string $passwd): bool
    {
        $valid = TRUE;
        $len = mb_strlen($passwd);
        $MIN_PASSWD_LENGTH = 8;
        $MAX_PASSWD_LENGTH = 64;

        if (($len < $MIN_PASSWD_LENGTH) || ($len > $MAX_PASSWD_LENGTH))
        {
            $valid = FALSE;
        }
        
        return $valid;
    }

	public function isIdValid(int $id): bool
	{
		$valid = TRUE;
		$MIN_ID_LENGTH = 1;
        $MAX_ID_LENGTH = 1000000;
		
		if (($id < $MIN_ID_LENGTH) || ($id > $MAX_ID_LENGTH))
		{
			$valid = FALSE;
		}
		
		return $valid;
	}

    public function getIdFromName(string $name): ?int
    {
        global $pdo;
        
        if (!$this->isNameValid($name))
        {
            throw new Exception('Invalid user name. Name must be between 4 and 64 characters.');
        }
        
        $id = NULL;
        
        $query = 'SELECT account_id FROM accounts WHERE (account_name = :name)';
        $values = array(':name' => $name);
        
        try
        {
            $res = $pdo->prepare($query);
            $res->execute($values);
        }
        catch (PDOException $e)
        {
        throw new Exception('Database query error');
        }
        
        $row = $res->fetch(PDO::FETCH_ASSOC);
        
        if (is_array($row))
        {
            $id = intval($row['account_id'], 10);
        }
        
        return $id;
    }

	public function addAccount(string $name, string $passwd): int
	{
		global $pdo;
		
		$name = trim($name);
		$passwd = trim($passwd);
		
		if (!$this->isNameValid($name))
		{
			throw new Exception('Invalid user name');
		}
		
		if (!$this->isPasswdValid($passwd))
		{
			throw new Exception('Invalid password');
		}
		
		if (!is_null($this->getIdFromName($name)))
		{
			throw new Exception('User name not available');
		}
		
		$query = 'INSERT INTO accounts (account_name, account_passwd) VALUES (:name, :passwd)';
		
		$hash = password_hash($passwd, PASSWORD_DEFAULT);
		
		$values = array(':name' => $name, ':passwd' => $hash);
		
		try
		{
			$res = $pdo->prepare($query);
			$res->execute($values);
		}
		catch (PDOException $e)
		{
		   throw new Exception('Database query error');
		}
		
		return $pdo->lastInsertId();
	}
	
	public function deleteAccount(int $id)
	{
		global $pdo;
		
		if (!$this->isIdValid($id))
		{
			throw new Exception('Invalid account ID');
		}
		
		$query = 'DELETE FROM accounts WHERE (account_id = :id)';
		
		$values = array(':id' => $id);
		
		try
		{
			$res = $pdo->prepare($query);
			$res->execute($values);
		}
		catch (PDOException $e)
		{
		   throw new Exception('Database query error');
		}
		
		$query = 'DELETE FROM account_sessions WHERE (account_id = :id)';
		
		$values = array(':id' => $id);
		
		try
		{
			$res = $pdo->prepare($query);
			$res->execute($values);
		}
		catch (PDOException $e)
		{
		   throw new Exception('Database query error');
		}
	}
	
	public function editAccount(int $id, string $name, string $passwd, bool $enabled)
	{
		global $pdo;
		
		$name = trim($name);
		$passwd = trim($passwd);
		
		if (!$this->isIdValid($id))
		{
			throw new Exception('Invalid account ID');
		}
		
		if (!$this->isNameValid($name))
		{
			throw new Exception('Invalid user name');
		}
		
		if (!$this->isPasswdValid($passwd))
		{
			throw new Exception('Invalid password');
		}
		
		/* Check if an account having the same name already exists (except for this one). */
		$idFromName = $this->getIdFromName($name);
		
		if (!is_null($idFromName) && ($idFromName != $id))
		{
			throw new Exception('User name already used');
		}
		
		$query = 'UPDATE accounts SET account_name = :name, account_passwd = :passwd, account_enabled = :enabled WHERE account_id = :id';
		
		$hash = password_hash($passwd, PASSWORD_DEFAULT);
		
		/* Int value for the $enabled variable (0 = false, 1 = true) */
		$intEnabled = $enabled ? 1 : 0;
		
		$values = array(':name' => $name, ':passwd' => $hash, ':enabled' => $intEnabled, ':id' => $id);
		
		try
		{
			$res = $pdo->prepare($query);
			$res->execute($values);
		}
		catch (PDOException $e)
		{
		   throw new Exception('Database query error');
		}
	}

    public function login(string $name, string $passwd): string
    {
        global $pdo;	
        
        $name = trim($name);
        $passwd = trim($passwd);
        
        if (!$this->isNameValid($name))
        {
            return false;
        }
        
        if (!$this->isPasswdValid($passwd))
        {
            return false;
        }
        
        $query = 'SELECT * FROM accounts WHERE (account_name = :name) AND (account_enabled = 1)';
        
        $values = array(':name' => $name);
        
        try
        {
            $res = $pdo->prepare($query);
            $res->execute($values);
        }
        catch (PDOException $e)
        {
        throw new Exception('Database query error');
        }
        
        $row = $res->fetch(PDO::FETCH_ASSOC);
        
        if (is_array($row))
        {
            if (password_verify($passwd, $row['account_passwd']))
            {
                $this->id = intval($row['account_id'], 10);
                $this->name = $name;
                $this->authenticated = TRUE;
                
                $this->registerLoginSession();
                
                return true;
            }
            
        }
        
        return false;
    }

    public function sessionLogin(): bool
    {
        global $pdo;
        
        if (session_status() == PHP_SESSION_ACTIVE)
        {
            $query = 
            
            'SELECT * FROM account_sessions, accounts WHERE (account_sessions.session_id = :sid) ' . 
            'AND (account_sessions.login_time >= (NOW() - INTERVAL 7 DAY)) AND (account_sessions.account_id = accounts.account_id) ' . 
            'AND (accounts.account_enabled = 1)';
            
            $values = array(':sid' => session_id());
            
            try
            {
                $res = $pdo->prepare($query);
                $res->execute($values);
            }
            catch (PDOException $e)
            {
            throw new Exception('Database query error');
            }
            
            $row = $res->fetch(PDO::FETCH_ASSOC);
            
            if (is_array($row))
            {
                $this->id = intval($row['account_id'], 10);
                $this->name = $row['account_name'];
                $this->authenticated = TRUE;
                
                return TRUE;
            }
        }
        
        return FALSE;
    }

    private function registerLoginSession()
    {
        global $pdo;
        
        if (session_status() == PHP_SESSION_ACTIVE)
        {
           
            $query = 'REPLACE INTO account_sessions (session_id, account_id, login_time) VALUES (:sid, :accountId, NOW())';
            $values = array(':sid' => session_id(), ':accountId' => $this->id);
            
            try
            {
                $res = $pdo->prepare($query);
                $res->execute($values);
            }
            catch (PDOException $e)
            {
            throw new Exception('Database query error');
            }
        }
    }

    public function logout()
    {
        global $pdo;	
        
        if (is_null($this->id))
        {
            return;
        }
        
        $this->id = NULL;
        $this->name = NULL;
        $this->authenticated = FALSE;
        
        if (session_status() == PHP_SESSION_ACTIVE)
        {
            $query = 'DELETE FROM account_sessions WHERE (session_id = :sid)';
            
            $values = array(':sid' => session_id());
            
            try
            {
                $res = $pdo->prepare($query);
                $res->execute($values);
            }
            catch (PDOException $e)
            {
            throw new Exception('Database query error');
            }
        }
    }
}

