<?php
require 'aws-sdk-php/aws-autoloader.php';

// Use the us-west-2 region and latest version of each client.
$sharedConfig = [
    'region'  => 'us-west-2',
    'version' => 'latest'
];

// Create an SDK class used to share configuration across clients.
$sdk = new Aws\Sdk($sharedConfig);

function searchInstances($searchString){
  global $sdk;

  // Create a client using the shared configuration data.
  $ec2 = $sdk->createEc2();

  $result = $ec2->describeInstances([
    'Filters' => array(
        array("Name" => "tag-value", "Values" => array($searchString),
    ))
  ]);

  $instances = array();
  foreach ($result['Reservations'] as $reservation) {
      $instances = $reservation['Instances'];
      foreach ($instances as $instance) {
        $detailInstance = detailInstance($instance);
        array_push($instances, $detailInstance);
      }
  }

  return $instances;
}

function detailInstance($instance){
  $instanceId = $instance['InstanceId'];

  $instanceName = '';
  foreach ($instance['Tags'] as $tag) {
      if ($tag['Key'] == 'Name') {
          $instanceName = $tag['Value'];
      }
  }

  $privateIp = $instance['NetworkInterfaces'][0]['PrivateIpAddress'];

  return array(
    "instanceId" => $instanceId,
    "instanceName" => $instanceName,
    "privateIp" => $privateIp
  );
}

?>
