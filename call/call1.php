<?php

  ## AUTHOR: Alisson Pelizaro (alissonpelizaro@hotmail.com)

  // Replace with your server settings if not using the default.
  // If unsure check /etc/asterisk/manager.conf under [general];
  $ipServer = "192.168.69.213";
  $port = "5038";
  $protocolServer = "tcp";
  // Replace with your username. You can find it in /etc/asterisk/manager.conf.
  // If unsure look for a user with "originate" permissions, or create one as
  $username = "test";
  // Replace with your password (refered to as "secret" in /etc/asterisk/manager.conf)
  $password = "1234";
  // Internal phone line to call from
  $internalPhoneline = $_REQUEST['mysip'];
  $ws = false; //Set 'true' if you use WebSocket protocol transport in your Asterisk Server
  // Context for outbound calls. See /etc/asterisk/extensions.conf if unsure.
  $context = 'default-test';

  if (isset($_REQUEST['caller_id'])) {
    $caller_id=$_REQUEST['caller_id'];
  }else{
    $caller_id="Calling";
  }
  

  //Starting script
  if($ws){
    $port .= "/ws";
  }

  $socket = stream_socket_client("$protocolServer://$ipServer:$port");
  $target = $_REQUEST['to'];
  if($socket)
  {
      echo "Connected to socket, sending authentication request.\n";
      // Prepare authentication request
      $authenticationRequest = "Action: Login\r\n";
      $authenticationRequest .= "Username: $username\r\n";
      $authenticationRequest .= "Secret: $password\r\n";
      $authenticationRequest .= "Events: off\r\n\r\n";
      // Send authentication request
      $authenticate = stream_socket_sendto($socket, $authenticationRequest);
      if($authenticate > 0)
      {
          // Wait for server response
          usleep(200000);
          // Read server response
          $authenticateResponse = fread($socket, 4096);
          // Check if authentication was successful
          if(strpos($authenticateResponse, 'Success') !== false)
          {
              echo "Authenticated to Asterisk Manager Inteface. Initiating call.\n";
              // Prepare originate request
              $originateRequest = "Action: Originate\r\n";
              
              $originateRequest .= "Channel: SIP/$internalPhoneline\r\n";
              $originateRequest .= "CallerId: $caller_id\r\n";
              $originateRequest .= "Exten: $target\r\n";
              $originateRequest .= "Context: $context\r\n";
              $originateRequest .= "Priority: 0\r\n";
              $originateRequest .= "Async: yes\r\n\r\n";
              // Send originate request
              $originate = stream_socket_sendto($socket, $originateRequest);
              if($originate > 0)
              {
                  // Wait for server response
                  usleep(200000);
                  // Read server response
                  $originateResponse = fread($socket, 4096);
                  // Check if originate was successful
                  if(strpos($originateResponse, 'Success') !== false)
                  {
                      echo "Call initiated, dialing.";
                  } else {
                      echo "Could not initiate call.\n";
                  }
              } else {
                  echo "Could not write call initiation request to socket.\n";
              }
          } else {
              echo "Could not authenticate to Asterisk Manager Interface.\n";
          }
      } else {
          echo "Could not write authentication request to socket.\n";
      }
  } else {
      echo "Unable to connect to socket.";
  }
?>
