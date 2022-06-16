<?php
include('../headLayout.php');
$url = "http://localhost:8000/api/v1/company";
$companies = json_decode(file_get_contents($url));

// Checking for a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $parent_company_name = $_POST["parent_company_name"];
  $data = array('name' => $name, 'parent_company_name' => $parent_company_name);
  $data = json_encode($data);

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);

  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

// SET Method as a POST
  curl_setopt($ch, CURLOPT_POST, 1);

// Pass user data in POST command
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute curl and assign returned data
  $response = curl_exec($ch);
  var_dump($response);
// Close curl
  curl_close($ch);


}

?>
<body>

<div class="container">
  <div class="sidebar">
    <a class="active" href="/frontend/">Home</a>
    <a class="active" href="/frontend/company/">List</a>
  </div>

  <h3>Add new company</h3>
  <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="name" placeholder="Enter name">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label">Parent company:</label>
      <div class="dropdown btn btn-default dropdown-toggle">
        <select name="parent_company_name">
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

