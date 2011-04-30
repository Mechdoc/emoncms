<?php

  function db_connect()
  {
    // ERROR CODES
    // 1: success!
    // 2: no settings.php file
    // 3: database settings are wrong	
  
    $success = 1;	

  if(!file_exists(dirname(__FILE__)."/settings.php"))
  {
    $success = 2;
  }
  else
  {
    require_once ('settings.php');

    $conn = mysql_connect($server, $username, $password) or $success = 3;
    $db = mysql_select_db($database) or $success = 3;

  }

    return $success;
  }

  function db_query($query)
  {
    return $result = mysql_query($query);
  }

  function db_query_row($query)
  {
    $result = mysql_query($query);
    $row = mysql_fetch_array($result, MYSQL_ASSOC);
    return $row;
  }


?>
