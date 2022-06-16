<?php
session_start();
include('../headLayout.php');
$id = $_GET['id'];
if (!isset($_SESSION['id']) || $_SESSION['id'] == null) {
  $_SESSION['id'] = $id;
}

$get_url = "http://localhost:8000/api/v1/company";
$get_put_url = "http://localhost:8000/api/v1/company/$id";

$companies = json_decode(file_get_contents($get_url));
$company = json_decode(file_get_contents($get_put_url));

// Checking for a PUT request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $parent_company_name = $_POST["parent_company_name"];
  $data = array('name' => $name, 'parent_company_name' => $parent_company_name);
  $data = json_encode($data);
  $put_url = $id == null ? "http://localhost:8000/api/v1/company/" . $_SESSION['id'] : "http://localhost:8000/api/v1/company/update/$id";

  // curl initiate
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

// See response if data is posted successfully or any error
  session_destroy();
  header("Location:http://localhost/frontend/company/");
}

?>
<body>

<div class="container">
  <div class="sidebar">
    <a class="active" href="/frontend/">Home</a>
    <a class="active" href="/frontend/company/">List</a>
    <a href="/frontend/company/create">Add new</a>
  </div>

  <h3>Update company</h3>
  <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?= $company->name ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label">Parent company:</label>
      <div class="dropdown btn btn-default dropdown-toggle">
        <select name="parent_company_name">
          <option value="" name=""></option>
          <?php foreach ($companies as $parent): ?>
            <?php if ($parent->id == $company->parent_company_id): ?>
              <option value="<?= $parent->name ?>" selected><?= $parent->name; ?></option>
            <?php else: ?>
              <option value="<?= $parent->name ?>"><?= $parent->name; ?></option>
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


</div>

