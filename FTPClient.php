<?php

Class FTPClient
{
    // *** Class variables
    public $ftpconnection;
    public $downloadPath = "";
    private $loginOk = false;
    private $messageArray = array();

 
    public function __construct() { }

    private function logMessage($message) 
{
    $this->messageArray[] = $message;
}

public function getMessages()
{
    return $this->messageArray;
}

public function connect ($server, $ftpUser, $ftpPassword, $isSecure, $isPassive = false  )
{
    if($isSecure){
        $this->ftpconnection = ftp_ssl_connect($server);
    }
        else{ 
        $this->ftpconnection = ftp_connect($server);
    }
    
    $loginResult = ftp_login($this->ftpconnection, $ftpUser, $ftpPassword);
    $pas=ftp_pasv($this->ftpconnection, $isPassive = true);
    if ((!$this->ftpconnection) || (!$loginResult)) {
        $this->logMessage('FTP connection has failed!');
        $this->logMessage('Attempted to connect to ' . $server . ' for user ' . $ftpUser, true);
        return false;
    } else {
        $this->logMessage('Connected to ' . $server . ', for user ' . $ftpUser);
        $this->loginOk = true;
        return true;
    }

}


public function setDownloadPath($path){
   $this->downloadPath = $path;


}



public function __deconstruct()
{
    if ($this->ftpconnection) {
        ftp_close($this->ftpconnection);
    }
}

}


