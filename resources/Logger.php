<?php
class Logger  {
 
        protected $_path;
        protected $_fileName;
        //= 'myLogger.log';
 
        /**
         * @param string $path can be a directory o a file path
         */
        public function __construct() {
            if (empty($path)){
                $path= $_SERVER['DOCUMENT_ROOT'] . "ata/logs";
                //Throw new Exception("Path must be filled");
            }
            $archivo = 'myLogger_'.date("Ymd").'.log';
            
            if (!file_exists($path)) {
                Throw new Exception("The Path doesn't exists.");
            }
            if (!is_writeable($path)) {
                Throw new Exception("You can write on the give path");
            }
            date_default_timezone_set("America/Bogota");
            $this->_fileName = $archivo;
            $this->_path = $this->_parsePath($path);
            
            
        }   
 
        /**
         * Validate the path the add the filename to the path
         * @param String $path
         * @return String
         */
        protected function _parsePath($path) {
            $strLenght = strlen($path);
            $lastChar = substr($path, $strLenght - 1, $strLenght);
            $path = $lastChar != "/" ? $path . "/" : $path;
 
            if ( is_dir($path) ) {
                return $path . $this->_fileName;
            } else {
                return $path;
            }
        }
 
        /**
         * Will save the path on the give path
         * @param String $line
         */
        protected function _save($line) {
            $fhandle = fopen($this->_path, "a+");
            fwrite($fhandle, $line);
            fclose($fhandle);
        }
 
        /**
         * main function to add lines to the logging file
         * @param String $line
         */
        public function addLine($line){
            $line = is_array($line) ? print_r($line, true) : $line;
            $line = date("d-m-Y H:i:s") . ": $line\r\n";
            $this->_save($line);
        }
    }
?>    
    