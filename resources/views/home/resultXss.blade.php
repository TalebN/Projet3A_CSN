<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- @if(isset($mode) && $mode == 'secure')
     <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://trusted.cdn.com; object-src 'none';"> 
     @elseif(isset($mode) && $mode == 'insecure')
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    @endif -->
      <!-- Site Metas -->
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
  <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
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
      <div class="">
         @include('home.header')

       
          @if(isset($message))
          <div class="alert alert-success">
          Thank you for your message, we will get back to you shortly
          </div>
          @endif

      <div class="center">
      @if(isset($mode) && $mode == 'secure')
          <p>Message: {{ $message }}</p>
      @elseif(isset($mode) && $mode == 'insecure')
          <p>Message: {!! $message !!}</p>
      @endif
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