<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style type="text/css">

    .title_deg
    {
        text-align: center;
        font-size: 25px;
        font-weight: bold;
        padding-bottom: 40px;


    }

    .table_deg
    {

        border: 2px solid white;
        width: 100%;
        margin: auto;
        padding-top: 50px;
        text-align: center;
    }

    .th_deg
    {
        background-color: skyblue;
    }

    .img_size
    {
        width: 200px;
        height: 100px;
    }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <h1 class="title_deg">All Orders</h1>

                <div style="padding-Left:400px; padding-bottom:30px;">

                <form action="{{url('search')}}" method="get">
                @csrf
                <input type="text" name="search" style="color:black;" placeholder="Search For Something">
                <input type="submit" value="Search" class="btn btn-outline-primary">


                </form>


                </div>
                <table class="table_deg">
                    <tr class="th_deg">
                        <th style="padding: 10px;">Name</th>
                        <th style="padding: 10px;">Email</th>
                        <th style="padding: 10px;">Adress</th>
                        <th style="padding: 10px;">Phone</th>
                        <th style="padding: 10px;">Product title</th>
                        <th style="padding: 10px;">Quantity</th>
                        <th style="padding: 10px;">Price</th>
                        <th style="padding: 10px;" >Payment Status</th>
                        <th style="padding: 10px;" >Delivery</th>
                        <th style="padding: 10px;">Image</th>
                        <th style="padding: 10px;">Delivered</th>
                        <th style="padding: 10px;">Print PDF</th>
                        

                    </tr>
                    
                    @foreach ($order as $order)
                        
                    <tr>
                        <td>{{$order->name}}</td>
                        <td>{{$order->email}}</td>
                        <td>{{$order->address}}</td>
                        <td>{{$order->phone}}</td>
                        <td>{{$order->product_title}}</td>
                        <td>{{$order->quantity}}</td>
                        <td>{{$order->price}}</td>
                        <td>{{$order->payment_status}}</td>
                        <td>{{$order->delivery_status}}</td>
                        <td>
                            <img class="img_size" src="/product/{{$order->image}}">

                        </td>

                        <td>
                            @if($order->delivery_status=='processing')

                            <a class="btn btn-primary" onclick="return confirm('Are you sure this product is delivered !!!')" href="{{url('delivered',$order->id)}}">Delivered</a>
                            @else
                            <p style="color: green;">Delivered</p>





                            @endif

                        </td>
                        <td>
                            <a href="{{url('print_pdf',$order->id)}}" class="btn btn-secondary">Print PDF</a>
                        </td>
                    </tr>
                    @endforeach
                </table>


            </div>
        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
        @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>