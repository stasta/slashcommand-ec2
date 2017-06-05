<?php

require 'aws.php';

// Setup
$command_expected = "/ec2search";

$debug          = $_ENV["DEBUG"];
$token_expected = $_ENV["SLACK_TOKEN"];
$request        = $_POST;

$token_received   = $request["token"];
$command_received = $request["command"];
$response_url     = $request["response_url"];
$text             = $request["text"];

if ( $debug) {
  echo $debug;
  echo $request["token"];
  echo $request["team_id"];
  echo $request["team_domain"];
  echo $request["channel_id"];
  echo $request["channel_name"];
  echo $request["user_id"];
  echo $request["user_name"];
  echo $request["command"];
  echo $request["text"];
  echo $request["response_url"];
}

if ($token_received != $token_expected) {
  echo sprintf("Invalid token!");
  exit;
}

if ($command_received != $command_expected) {
  echo sprintf("Invalid command!");
  exit;
}

// No message was sent. Printing usage
if (!isset($text) || trim($text)==='') {
  echo "Type `/ec2search <search string>` to list IP's of a given EC2\n";
} else {
    // Listing IP's of the given EC2
  echo sprintf("Here is the list of instances '%s':\n", "$text'");
  echo sprintf("%s\t%s\t\t%s\n", "PrivateIP:", "Instance ID:", "Instance Name:");

  $instances = searchInstances($text);
  foreach ($instances as $instance) {
    echo sprintf("%s\t%s\t%s\n",
      $instance['privateIp'],
      str_pad($instance['instanceId'], 20),
      $instance['instanceName']);
  }
}

?>
