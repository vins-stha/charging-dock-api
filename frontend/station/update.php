<?php
session_start();
include('../headLayout.php');
include('../Controller/ApiCall.php');

$id = $_GET['id'];
if (!isset($_SESSION['station_id']) || $_SESSION['station_id'] == null) {
  $_SESSION['station_id'] = $_GET['id'];
}

$apiCall = new ApiCall(ApiCall::COMPANY_BASEURL, $method = "GET", null);
$companies = json_decode($apiCall->createCURLRequest());

$apiCall = new ApiCall(ApiCall::STATION_BASEURL . $id, $method = "GET", null);
$station = json_decode($apiCall->createCURLRequest());

// Checking for a PUT request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
  $name = $_POST["name"];
  $parent_company_name = $_POST["parent_company_name"];
  $latitude = $_POST["latitude"];
  $longitude = $_POST["longitude"];
  $address = $_POST["address"];
  $data = array(
      'name' => $name,
      'parent_company_name' => $parent_company_name,
      'latitude' => $latitude,
      'longitude' => $longitude,
      'address' => $address
  );
  $data = json_encode($data);
  $id = $_GET['id'] == null ? $_SESSION['station_id'] : $_GET['id'];
  $apiCall = new ApiCall(ApiCall::STATION_BASEURL . $id, $method = "PUT", $data);
  $response = $apiCall->createCURLRequest();

  if (!empty(json_decode($response))) {

    session_destroy();

    header("Location: /frontend/station");
  } else {
    echo "Error updating " . $response;
  }

}

?>

<body>

<div class="container">
  <div class="sidebar">
    <a class="active" href="/frontend/">Home</a>
    <a class="active" href="/frontend/station/">List</a>
    <a href="/frontend/station/create">Add new</a>
  </div>

  <h3>Update station</h3>
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
        <select name="parent_company_name">
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
        <button class="btn btn-primary" name="submit" type="submit" class="btn btn-default">Update</button>
      </div>
    </div>
  </form>

</body>



