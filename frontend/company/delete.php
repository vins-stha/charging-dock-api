<?php
include('../Controller/ApiCall.php');
$id = $_GET['id'];

$apiCall = new ApiCall(ApiCall::COMPANY_BASEURL.$id, $method="DELETE", null);
$response = $apiCall->createCURLRequest();

if(is_array($response)
    && array_key_exists('data', $response)
    || strcmp($response['data'], 'Not found') == 0
)
  echo "Error deleting ";

else
  header("Location: /frontend/company");


?>

