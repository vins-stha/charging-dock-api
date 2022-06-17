<?php
include('../headLayout.php');
include('../Controller/ApiCall.php');

  // Checking for a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
  $name = $_POST["name"];
  $parent_company_name = $_POST["parent_company_name"];
  $data = array('name' => $name, 'parent_company_name' => $parent_company_name);
  $data = json_encode($data);

  $apiCall = new ApiCall(ApiCall::COMPANY_BASEURL, $method="POST",  $data);
  $response = $apiCall->createCURLRequest();

  if(!$response)
    echo "Error creating ";

  else
    header("Location: /frontend/company");
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
        <button class="btn btn-primary" name ="submit" type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>

</body>


</div>

