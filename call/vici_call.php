<?php

  ## AUTHOR: Alisson Pelizaro (alissonpelizaro@hotmail.com)

  // Replace with your server settings if not using the default.
  // If unsure check /etc/asterisk/manager.conf under [general];


if (isset($_REQUEST['action'])) {
  $mysip="cc".$_REQUEST['mysip'];
  print_r($mysip);


  switch ($_REQUEST['action']) {
    case "call":
      $to=$_REQUEST['to'];
      $prefix=$_REQUEST['dial_prefix'];

      $a=file_get_contents("http://192.168.69.11/agc/api.php?source=crm_call&user=".$mysip."&pass=".$mysip."&agent_user=".$mysip."&function=external_pause&value=PAUSE");

      $a=file_get_contents("http://192.168.69.11/agc/api.php?source=crm_call&user=".$mysip."&pass=".$mysip."&agent_user=".$mysip."&function=external_dial&lead_id=".$to."&dial_prefix=".$prefix."&phone_code=&search=YES&preview=NO&focus=NO");
      print_r($a);
      break;
    case "hangup":
  
      $a=file_get_contents("http://192.168.69.11/agc/api.php?source=crm_call&user=".$mysip."&pass=".$mysip."&agent_user=".$mysip."&function=external_pause&value=PAUSE");
      print_r($a."<br>");

      $a=file_get_contents("http://192.168.69.11/agc/api.php?source=crm_call&user=".$mysip."&pass=".$mysip."&agent_user=".$mysip."&function=external_hangup&value=1");
      print_r($a."<br>"); 

      $a=file_get_contents("http://192.168.69.11/agc/api.php?source=crm_call&user=".$mysip."&pass=".$mysip."&agent_user=".$mysip."&function=external_status&value=call");
      print_r($a."<br>");  
  
      break;
    
    default:
      // code...
      break;
  }
}

?>
