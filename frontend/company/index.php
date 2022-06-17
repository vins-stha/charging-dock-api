<?php
include('../headLayout.php');
include('../Controller/ApiCall.php');

$apiCall = new ApiCall(ApiCall::COMPANY_BASEURL, $method="GET",  null);
$companies = json_decode($apiCall->createCURLRequest());
?>
<div class="container">
  <div class="sidebar">
    <a class="active" href="/frontend/">Home</a>
    <a href="create">Add new</a>
  </div>

  <div class="content">
    <h2>Company list</h2>
    <table class="table table-striped table-dark">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Parent</th>
        <th scope="col">Actions</th>
      </tr>
      </thead>
      <tbody>
      <?php if(count($companies) > 0): ?>
      <?php foreach ($companies as $company): ?>
        <tr>

          <th scope="row"><?= $company->id ?></th>
          <td><?= $company->name ?></td>
          <td><?= $company->parent_company_id ?></td>
          <td>
            <a class="btn btn-success" href="view?id=<?= $company->id?>">View</a>
            <a type="button" class="btn btn-danger" href="delete?id=<?= $company->id?>">Delete</a>
            <a type="button" class="btn btn-primary" href="update?id=<?= $company->id?>">Update</a>
          </td>
        </tr>
      <?php endforeach; endif;?>
      </tbody>
    </table>
  </div>


</div>
