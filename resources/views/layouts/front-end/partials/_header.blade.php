<style>
    .card-body.search-result-box {
        overflow: scroll;
        height: 400px;
        overflow-x: hidden;
    }

    .active .seller {
        font-weight: 700;
    }

    pb-1:after {

        display:none
    }

    .for-count-value {
        position: absolute;

        right: 0.6875rem;;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        color: {{$web_config['primary_color']}};

        font-size: .75rem;
        font-weight: 500;
        text-align: center;
        line-height: 1.25rem;
    }

    .count-value {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        color: {{$web_config['primary_color']}};

        font-size: .75rem;
        font-weight: 500;
        text-align: center;
        line-height: 1.25rem;
    }

    @media (min-width: 992px) {
        .navbar-sticky.navbar-stuck .navbar-stuck-menu.show {
            display: block;
            height: 55px !important;
        }
    }

    @media (min-width: 768px) {
        .navbar-stuck-menu {
            background-color: {{$web_config['primary_color']}};
            line-height: 15px;
            padding-bottom: 6px;
        }

    }

    @media (max-width: 767px) {
        .search_button {
            background-color: transparent !important;
        }

        .search_button .input-group-text i {
            color: {{$web_config['primary_color']}}                              !important;
        }

        .navbar-expand-md .dropdown-menu > .dropdown > .dropdown-toggle {
            position: relative;
            padding- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 1.95rem;
        }

        .mega-nav1 {
            background: white;
            color: {{$web_config['primary_color']}}                              !important;
            border-radius: 3px;
        }

        .mega-nav1 .nav-link {
            color: {{$web_config['primary_color']}}                              !important;
        }
    }

    @media (max-width: 768px) {
        .tab-logo {
            width: 10rem;
        }
    }

    @media (max-width: 360px) {
        .mobile-head {
            padding: 3px;
        }
    }

    @media (max-width: 471px) {
        .navbar-brand img {

        }

        .mega-nav1 {
            background: white;
            color: {{$web_config['primary_color']}}                              !important;
            border-radius: 3px;
        }

        .mega-nav1 .nav-link {
            color: {{$web_config['primary_color']}} !important;
        }
    }
    #anouncement {
        width: 100%;
        padding: 2px 0;
        text-align: center;
        color:white;
    }

    #can li {

        margin:10px
    }


    #can li a {

        font-weight:600;
        font-size:17px;
       
    }

    #can li a i {

        margin:0 5px
    }

    
</style>
@php($announcement=\App\CPU\Helpers::get_business_settings('announcement'))
@if (isset($announcement) && $announcement['status']==1)
    <div class="d-flex justify-content-between align-items-center" id="anouncement" style="background-color: {{ $announcement['color'] }};color:{{$announcement['text_color']}}">
        <span></span>
        <span style="text-align:center; font-size: 15px;">{{ $announcement['announcement'] }} </span>
        <span class="ml-3 mr-3" style="font-size: 12px;cursor: pointer;color: darkred"  onclick="myFunction()">X</span>
    </div>
@endif


<header class="box-shadow-sm rtl">

    <!-- Topbar-->
<nav class="navbar" style="background:#fff;position:fixed;width:100%;z-index:500000;box-shadow:37px 2px 9px -3px;padding:10px">
  <div class="container-fluid {{Session::get('direction') === "rtl" ? 'flex-row-reverse' : 'flex-row'}}">

        <img style="height: 40px!important; width:auto;"
        src="{{asset('images/logo.png')}}"onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
        alt="{{$web_config['name']->value}}"/>

        <div class="dropdown">
  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Dropdown link
  </a>

  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="#">Action</a></li>
    <li><a class="dropdown-item" href="#">Another action</a></li>
    <li><a class="dropdown-item" href="#">Something else here</a></li>
  </ul>
</div>

        <div class="d-flex" style="flex-direction:row-reverse;margin:0 10px">

        <div style="background:#f8f8f8;border-radius:50%;padding:3px;width:4rem;display:flex;justify-content:center;align-items:center">
        @php( $local = \App\CPU\Helpers::default_lang())
                <div
                    class="topbar-text dropdown disable-autohide  text-capitalize">
                    <a class="topbar-link dropdown-toggle pb-1" style="text-decoration:none;font-weight:600" href="#" data-toggle="dropdown">
                        @foreach(json_decode($language['value'],true) as $data)
                            @if($data['code']==$local)
                              
                                {{$data['name']}}
                            @endif
                        @endforeach
                    </a>
                    <ul class="dropdown-menu dropdown-menu-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"
                        style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        @foreach(json_decode($language['value'],true) as $key =>$data)
                            @if($data['status']==1)
                                <li>
                                    <a class="dropdown-item pb-1" href="{{route('lang',[$data['code']])}}">
                                       
                                        <span style="text-transform: capitalize">{{$data['name']}}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
        </div>
   
        <div id="cart_items">
            @include('layouts.front-end.partials.cart')
        </div>

     
      

        <div style="background:#f8f8f8;border-radius:50%;padding:3px">
        <button class="navbar-toggler" style="border:none" type="button" style="border:none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon" style="border:none"></span>
        </button>

        </div>
        </div>

    
    <div class="offcanvas offcanvas-end" style="direction:rtl" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"> <img style="height: 40px!important; width:auto;"
        src="{{asset('images/logo.png')}}"onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
        alt="{{$web_config['name']->value}}"/></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div style="padding:0 10px;font-size:18px;font-weight:600;text-align:center">
      <p>@php( $user = App\CPU\Helpers::get_customer())
      {{App\CPU\translate('good_moning')}}👋 , {{$user->f_name}} {{$user->l_name}}
      </p>
      </div>
       
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" id="can">
          <li class="nav-item">
          
            <a class="dropdown-item active" style="font-weight:600" aria-current="page" href="{{route('home')}}"><i class="fa-solid fa-store fa-xl"></i>{{App\CPU\translate('store')}}</a>
          </li>
          <li class="nav-item">
            <a class="dropdown-item" href="{{route('account-oder')}}" style="font-weight:600"><i class="fa-solid fa-clipboard-check fa-xl"></i>{{App\CPU\translate('Orders')}}</a>
          </li>

          <li class="nav-item">
            <a class="dropdown-item" href="{{route('customer.wallet')}}" style="font-weight:600"><i class="fa-solid fa-user fa-xl"></i>{{App\CPU\translate('my_page')}}</a>
          </li>
          <hr>
          <li class="nav-item">
            <a class="dropdown-item" href="{{route('customer.auth.logout')}}" style="font-weight:600"><i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>{{ \App\CPU\translate('Sign out')}}</a>
          </li>
          
        
        </ul>
      
      </div>
    </div>
  </div>
</nav>
            
</header>

<script>
function myFunction() {
  $('#anouncement').addClass('d-none').removeClass('d-flex')
}

function get_cate() {

    $('.categoryUl').css('display', 'block');
    // console.log('good');
    
}

function hide_cate() {

$('.categoryUl').css('display', 'none');
// console.log('good');

}
</script>
