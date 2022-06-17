<?php
include('../headLayout.php');
include('../Controller/ApiCall.php');

$apiCall = new ApiCall(ApiCall::STATION_BASEURL, $method="GET",  null);
$stations = json_decode($apiCall->createCURLRequest());

?>
<div class="container">
  <div class="sidebar">
    <a class="active" href="/frontend/">Home</a>
    <a href="/frontend/station/create">Add new</a>
  </div>

  <div class="content">
    <h2>Stations list</h2>
    <table class="table table-striped table-dark">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Address</th>
        <th scope="col">Actions</th>
      </tr>
      </thead>
      <tbody>
      <?php if (count($stations) > 0): ?>
      <?php foreach ($stations as $station): ?>
        <tr>
          <th scope="row"><?= $station->id ?></th>
          <td><?= $station->name ?></td>
          <td><?= $station->address ?></td>

          <td>
            <a class="btn btn-success" href="view?id=<?= $station->id?>">View</a>
            <a type="button" class="btn btn-danger" href="delete?id=<?= $station->id?>">Delete</a>
            <a type="button" class="btn btn-primary" href="update?id=<?= $station->id?>">Update</a>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php endif; ?>
      </tbody>
    </table>
  </div>


</div>
