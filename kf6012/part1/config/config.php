<?php
  /**
   * php file containing fucntions for error and exception handling and a class autoloader used in index.php

   * @author Tom Hegarty 
   */
  
  /**
   * a function to catch and handle exceptions outputs JSON message with details
   * 
   * @e   any exception that has been thrown
   */
  function exceptionHandler($e) {
    $msg = array("status" => "500", "message" => $e->getMessage(), "file" => $e->getFile(), "line" => $e->getLine());
    $usr_msg = array("status" => "500", "message" => "Sorry! Internal server error!");
    header("Access-Control-Allow-Origin: *"); 
    header("Content-Type: application/json; charset=UTF-8"); 
    header("Access-Control-Allow-Methods: GET, POST");
    echo json_encode($usr_msg);
    logError($msg);

  }

  set_exception_handler('exceptionHandler');

  /**
   * checks to see if error is fatal or not, if not it wont end the program
   * if error is deemed fatal it will throw an exception, outputting JSON data of details
   * 
   * @errno  http status code of erro
   * @errstr string desciption of error
   * @errfile the file that caused the error
   * @errline the line which the error is on
   */
  function errorHandler($errno, $errstr, $errfile, $errline) {
      if ($errno != 2 && $errno != 8) {
        throw new Exception("Fatal Error Detected: [$errno] $errstr line: $errline", 1);
      }
  }
  set_error_handler('errorHandler');


  /**
   * function to auto load classes
   * 
   * @className   the name of the class (within part1\classes directory)
   */
  function autoloadClasses($className) {
      $filename = "classes\\" . strtolower($className) . ".class.php";
      $filename = str_replace('\\', DIRECTORY_SEPARATOR, $filename);
      if (is_readable($filename)) {
        include_once $filename;
      } else {
        throw new exception("File not found: " . $className . " (" . $filename . ")");
        logError($errstr);
      }
  }
  spl_autoload_register("autoloadClasses");

  /**
   *  function to write details from any exceptions or errors to a log file (errorlogs.txt)
   *  errorLogs.txt is designed to be human readable (not JSON or XML etc)
   *
   *  @msg error message details to be written
   */
  function logError($msg){
      $txt = $msg . " at " . date('l jS \of F Y h:i:s A') . "\n ------------------------------------- \n";
      $myfile = file_put_contents('errorlogs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
  }


  $ini['about'] = parse_ini_file("config.ini",true);

  define('BASEPATH', $ini['about']['paths']['basepath']);
  define('CSSPATH', $ini['about']['paths']['css']);
  define('JWTKEY', $ini['about']['keys']['jwt']);

?>