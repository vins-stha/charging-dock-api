<?php
session_start();
include('../headLayout.php');
$id = $_GET['id'];
if (!isset($_SESSION['id']) || $_SESSION['id'] == null) {
  $_SESSION['id'] = $id;
}

$get_url = "http://localhost:8000/api/v1/company";
$companies = json_decode(file_get_contents($get_url));

$get_put_url = "http://localhost:8000/api/v1/station/$id";
$station = json_decode(file_get_contents($get_put_url));

// Checking for a PUT request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $parent_company_name = $_POST["company_name"];
  $latitude = $_POST["latitude"];
  $longitude = $_POST["longitude"];
  $address = $_POST["address"];
  $data = array(
      'name' => $name,
      'company_name' => $parent_company_name,
      'latitude' => $latitude,
      'longitude' => $longitude,
      'address' => $address
  );
  $put_url = $id == null ? "http://localhost:8000/api/v1/station/" . $_SESSION['id'] : "http://localhost:8000/api/v1/station/$id";

  $data = json_encode($data);

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $put_url);

  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));

// SET Method as a PUT
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

// Pass user data in POST command
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute curl and assign returned data
  $response = curl_exec($ch);
// Close curl
  curl_close($ch);

  header("Location:http://localhost/frontend/station");

}

?>

<body>

<div class="container">
  <div class="sidebar">
    <a class="active" href="/frontend/">Home</a>
    <a class="active" href="/frontend/station/">List</a>
    <a href="/frontend/station/create">Add new</a>
  </div>

  <h3>Add new station</h3>
  <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?= $station->name ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Address:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="address" placeholder="Enter Address"
               value="<?= $station->address ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Latitude:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" name="latitude" placeholder="Enter latitude"
               value="<?= $station->latitude ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Longitude:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" name="longitude" placeholder="Enter longitude"
               value="<?= $station->longitude ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label">Parent company:</label>
      <div class="dropdown btn btn-default dropdown-toggle">
        <select name="company_name">
          <option value="" name=""></option>
          <?php foreach ($companies as $company): ?>
            <?php if ($company->id == $station->company_id): ?>
              <option value="<?= $company->name ?>" selected><?= $company->name; ?></option>
            <?php else: ?>
              <option value="<?= $company->name ?>"><?= $company->name; ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button class="btn btn-primary" type="submit" class="btn btn-default">Update</button>
      </div>
    </div>
  </form>

</body>



