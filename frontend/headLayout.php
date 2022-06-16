<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!--bootstrap css--->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- Styles -->
    <link rel="stylesheet" href="./assets/css/styles.css"/>

</head>
<section id="header">
    <header class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar">
        <a class="navbar-brand p-l-1 m-l-1" href="#"><i class="fa-solid fa-charging-station"></i>Charging stations</a>
        <div class="navbar-nav-scroll">
            <ul class="navbar-nav bd-navbar-nav flex-row">
                <li class="nav-item">
                    <a class="nav-link " href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="company/">Companies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="station/">Stations</a>
                </li>

            </ul>
        </div>
    </header>
</section>
<body>
