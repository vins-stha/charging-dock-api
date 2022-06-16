<?php
include('../headLayout.php');
$api_url = "http://localhost:8000/api/v1/company";
$companies = json_decode(file_get_contents($api_url));
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
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>


</div>
