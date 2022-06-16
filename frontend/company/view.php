<!--{{--<form action="{{route('administrator.authenticate')}}" method="post">--}}-->
<!--@include ('headLayout');-->
<?php
include('../headLayout.php');
$id = $_GET['id'];

$api_url = "http://localhost:8000/api/v1/company/$id";
$company = json_decode(file_get_contents($api_url));
var_dump($company);
?>
<div class="sidebar">
  <a class="active" href="/frontend/">Home</a>
  <a class="active" href="/frontend/company/">List</a>
  <a  href="/frontend/company/create">Add new</a>
</div>

<div class="content">
  <h2>Company Detail</h2>


  <section class="" style="background-color: #9de2ff;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-md-9 col-lg-7 col-xl-5">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-4">
              <div class="d-flex text-black">

                <div class="flex-grow-1 ms-3">
                  <p class="mb-1">Name</p>
                  <h5 class="mb-2 pb-1" style="color: #2b2a2a;"><?= $company->name ?></h5>
                  <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
                       style="background-color: #efefef;">
                    <div>
                      <p class="small text-muted mb-1">#stations</p>
                      <p class="mb-0"><?= count($company->stations) ?></p>
                    </div>
                    <div class="px-3">
                      <p class="small text-muted mb-1">#countries</p>
                      <p class="mb-0">0</p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <?php if (count($company->stations) > 0): ?>
            <table class="table table-striped table-dark">
              <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Latitude, Longitude</th>
              </thead>
              <tbody>
              <?php foreach ($company->stations as $station): ?>
                <tr>

                  <th scope="row"><?= $station->id ?></th>
                  <td><?= $station->name ?></td>
                  <td><?= $station->address ?></td>
                  <td><?= $station->latitude ?>, <?= $station->longitude ?></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>

        </div>


      </div>
    </div>
  </section>


</div>

