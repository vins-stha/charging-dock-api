<!--{{--<form action="{{route('administrator.authenticate')}}" method="post">--}}-->
<!--@include ('headLayout');-->
<?php
include('../headLayout.php');
$id = $_GET['id'];

$api_url = "http://localhost:8000/api/v1/station/$id";
$station = json_decode(file_get_contents($api_url));

?>
<div class="container">
  <div class="sidebar">
    <a class="active" href="/frontend/">Home</a>
    <a class="active" href="/frontend/station/">List</a>
    <a  href="/frontend/station/create">Add new</a>
  </div>

  <div class="content">
    <h2>Station Detail</h2>


    <section class="" style="background-color: #9de2ff;">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col col-md-9 col-lg-7 col-xl-5">
            <div class="card" style="border-radius: 15px;">
              <div class="card-body p-4">
                <div class="d-flex text-black">

                  <div class="flex-grow-1 ms-3">
                    <p class="mb-1">Name</p>
                    <h5 class="mb-2 pb-1" style="color: #2b2a2a;"><?= $station->name ?></h5>
                    <p class="mb-1">Address</p>
                    <h6 class="mb-2 pb-1" style="color: #2b2a2a;"><?= $station->address ?></h6>

                    <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
                         style="background-color: #efefef;">
                      <div>
                        <p class="small text-muted mb-1">latitude</p>
                        <p class="mb-0"><?=$station->latitude ?></p>
                      </div>
                      <div class="px-3">
                        <p class="small text-muted mb-1">longitude</p>
                        <p class="mb-0"><?=$station->longitude ?></p>
                      </div>
                      <div class="px-3">
                        <p class="small text-muted mb-1">Parent company id</p>
                        <p class="mb-0"><?=$station->company_id ?></p>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

          </div>


        </div>
      </div>
    </section>


  </div>

</div>

