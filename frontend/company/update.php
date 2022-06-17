<?php
session_start();
include('../headLayout.php');
include('../Controller/ApiCall.php');


if (!isset($_SESSION['company_id']) || $_SESSION['company_id'] == null) {
  $_SESSION['company_id'] = $_GET['id'];
}

// retrieve parent companies
$companies = json_decode(file_get_contents(ApiCall::COMPANY_BASEURL));
$company = json_decode(file_get_contents(ApiCall::COMPANY_BASEURL . $_SESSION['company_id']));

// Checking for a PUT request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

  $name = $_POST["name"];
  $parent_company_name = $_POST["parent_company_name"];
  $data = array('name' => $name, 'parent_company_name' => $parent_company_name);
  $data = json_encode($data);

  $id = $_GET['id'] == null ? $_SESSION['company_id'] : $_GET['id'];

  $apiCall = new ApiCall(ApiCall::COMPANY_BASEURL . $id, $method = "PUT", $data);
  $response = $apiCall->createCURLRequest();

  if (!empty(json_decode($response))) {

    session_destroy();

    header("Location: /frontend/company");
  } else {
    echo "Error updating " . $response;
  }

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
        <button class="btn btn-primary" name="submit" type="submit" class="btn btn-default">Update</button>
      </div>
    </div>
  </form>

</body>


</div>

