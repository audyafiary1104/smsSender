<?php
require 'vendor/autoload.php';
use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;
include 'index.php';
$regio = explode(PHP_EOL,file_get_contents('region.ini'));
$phone = readline('phone list :');

$get = explode(PHP_EOL,file_get_contents($phone));
foreach ($get as $key => $value) {
try {
    $regions = array_rand($regio,1);
    $region = $regio[$regions];
    
    $sns = SnsClient::factory(array(
        'credentials' => [
            'key'    => $access,
            'secret' => $secret,
        ],
        'region' => $region,
        'version' => 'latest'
        ));
        $args = array(
            'MessageAttributes' => [
                'AWS.SNS.SMS.SenderID' => [
                       'DataType' => 'String',
                       'StringValue' => 'AmaZ0n'
                ]
             ],
            "SMSType" => $type,
            "PhoneNumber" => $value,
            "Message" => $letter
        );
        $result = $sns->publish($args);
        echo "Status : Success -> SEND TO => ". $value.' REGION =>'.$region.PHP_EOL;
} catch (\AwsException $e) {
    //throw $th;
    echo "failed".PHP_EOL;
}
       

}
