 <header class="header_section">
      <a class="btn btn-info" style="position:absolute; top:25px;left:15px;" href="{{ url('/') }}">Change mode</a>

            <div class="container">
               <nav class="navbar navbar-expand-lg custom_nav-container ">
                  <a class="navbar-brand" href="#"><img width="250" src="images/logo.png" alt="#" /></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class=""> </span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav">
                        <li class="nav-item active">
                           <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
                        </li>
                       
                        <li class="nav-item">
                           <a class="nav-link" href="{{url('home.product')}}">Products</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="blog_list.html">Blog</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="{{url('contact')}}">Contact</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="{{url('show_cart')}}">Cart</a>
                        </li>
                        
                        @if (Route::has('login'))

                        @auth
                           
                        <li class="nav-item">
                           <x-app-layout>

                           </x-app-layout>
                        </li>
                        @else
                        <!-- <li class="nav-item">
                           <a class="btn  btn-primary" id="logincss" href="{{ route('login') }}">login</a>
                        </li> -->
                        <li class="nav-item">
                        @if(isset($mode) && $mode == 'secure')
                           <a class="btn btn-primary" id="logincss" href="{{ route('loginSec') }}">Login</a>
                        @elseif(isset($mode) && $mode == 'insecure')
                           <a class="btn btn-primary" id="logincss" href="{{ route('loginNotSec') }}">Login</a>
                        @endif

                        </li>
                        <!-- <li class="nav-item">
                           <a class="btn btn-success" href="{{ route('register') }}">Register</a>
                        </li> -->
                        <li class="nav-item">
                        @if(isset($mode) && $mode == 'secure')
                           <a class="btn btn-success" href="{{ url('registerSec') }}">Register</a>
                        @elseif(isset($mode) && $mode == 'insecure')
                           <a class="btn btn-success" href="{{ url('registerNotSec') }}">Register</a>
                        @endif
                        </li>
                        @endauth
                        @endif
                     </ul>
                  </div>
               </nav>
            </div>
         </header>