<?php
require_once "FTPClient.php";

Class FtpDownloader extends FTPClient
{    
    //both functions download the file in the given path, and return an array with the full download path if download it or false in other case. 
    public function downloadRecent()
    {
        $Dirs = ftp_nlist($this->ftpconnection, '/sales');
        $downloadCheck = false;
        $downloadArray = array();
        foreach ($Dirs as $Dir) {
            $files = ftp_nlist($this ->ftpconnection, $Dir);
            $mostRecentAll = array(
            'time' => 0,
            'file' => null
            );
       

           foreach ($files as $file) {
                $time = ftp_mdtm($this->ftpconnection, $file);

                if ($time > $mostRecentAll['time']) {
                    $mostRecentAll['time'] = $time;
                    $mostRecentAll['file'] = $file;
                }
                unset($file);
            }
                if($mostRecentAll['file'] !== NULL){
                    if(ftp_get($this->ftpconnection, $this->downloadPath.basename($mostRecentAll['file'], ".csv")."-".basename($Dir).".csv" , $mostRecentAll['file'], FTP_ASCII)){
                        $downloadCheck = true;
                        $downloadArray[] = $this->downloadPath.basename($mostRecentAll['file'], ".csv")."-".basename($Dir).".csv";
                 }
            }
        }
        if($downloadCheck!==true){
            return false;
        }else{
            return $downloadArray;
        }
    }

    public function downloadAll()
    {
        $Dirs = ftp_nlist($this->ftpconnection, '/sales');
        $downloadCheck = false;
        $downloadArray = array();
        foreach ($Dirs as $Dir)  {
            $files = ftp_nlist($this ->ftpconnection, $Dir);
            
            foreach ($files as $file) {
                $time = ftp_mdtm($this->ftpconnection, $file);
                if($time!==-1){
                if(ftp_get($this->ftpconnection, $this->downloadPath.basename($file, ".csv")."-".basename($Dir).".csv" , $file, FTP_ASCII)){
                    $downloadCheck = true;
                    $downloadArray[] = $this->downloadPath.basename($file, ".csv")."-".basename($Dir).".csv";                
                 }    
                }           
            }
        }
        if($downloadCheck!==true){
            return false;
        }else{
            return $downloadArray;
        }
    }
}
