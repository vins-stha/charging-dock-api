<?php
include('../headLayout.php');
include('../Controller/ApiCall.php');

// get parent companies
$companies = json_decode(file_get_contents(ApiCall::COMPANY_BASEURL));

// Checking for a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

  $apiCall = new ApiCall(ApiCall::STATION_BASEURL, $method = "POST", $data);
  $response = $apiCall->createCURLRequest();
  var_dump($response);
  if ($response || !empty($response)) {
    header("Location: /frontend/station");
  } else
    echo "Error creating ";
}

?>
<body>

<div class="container">
  <div class="sidebar">
    <a class="active" href="/frontend/">Home</a>
    <a class="active" href="/frontend/station/">List</a>
  </div>
  <h3>Add new station</h3>
  <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-10">
        <input type="text" required class="form-control" name="name" placeholder="Enter name">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Address:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" required name="address" placeholder="Enter Address">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Latitude:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" name="latitude" placeholder="Enter latitude">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Longitude:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" name="longitude" placeholder="Enter longitude">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label">Parent company:</label>
      <div class="dropdown btn btn-default dropdown-toggle">
        <select name="parent_company_name" required>
          <option value="" name=""></option>
          <?php foreach ($companies as $company): ?>
            <option value="<?= $company->name ?>"><?= $company->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button class="btn btn-primary" type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>

</body>


</div>

