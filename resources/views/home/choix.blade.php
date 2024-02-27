<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Access | Insecure Access</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('home/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('home/css/custom.css') }}" rel="stylesheet">



</head>

<body>



	<!-- Header -->
    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <h1>Choose Your Experience</h1>
                <p>Explore our site in Secure mode or Insecure mode.</p>
                <p> <br>Each path provides a different perspective on the importance of online security.</p>
               
            </div>
           
        </div>
        <a href="{{url('secureMode')}}" class="btn btn-primary btn-lg">Secure Mode</a>
        <a href="{{url('vulnerableMode')}}" class="btn btn2 btn-primary btn-lg">Insecure Mode</a>
    </header> 