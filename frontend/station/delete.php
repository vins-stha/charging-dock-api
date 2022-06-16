<?php

$id = $_GET['id'];

$delete_url = "http://localhost:8000/api/v1/station/$id";

{
  // curl initiate
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $delete_url);

  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));

// SET Method as a PUT
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');


  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute curl and assign returned data
  $response = curl_exec($ch);

// Close curl
  curl_close($ch);

// See response if data is posted successfully or any error

  header("Location:http://localhost/frontend/station/");

}

?>

