<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Famms - Fashion HTML Template</title>
    <link rel="shortcut icon" href="images/favicon.png" type="">
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />
    <style type="text/css">
      .center
      {
        margin: auto;
        width: 70%;
        text-align: center;
        padding: 30px;

      }
      .th_deg
      {
        font-size: 30px;
        padding: 5px;
        background: skyblue;
      }

      .img_deg
      {
        height:200px;
        width:200px;
      }

      .total_deg
      {
        font-size: 20px;
        padding:40px;
      }
    </style>
   </head>
   <body>

<div >
         @include('home.header')  

      <div class="center">
    @if(isset($mode) && $mode == 1)
      <form action="/soumettre-formulaire" method="POST">
    @elseif(isset($mode) && $mode == 0)
      <form action="/soumettre-formulaireNotSec" method="POST">
    @endif

    @csrf
    <label for="message">Message:</label><br>
    <input type="text" id="message" name="message"><br>
    <input type="submit" value="Soumettre">
</form>
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>
