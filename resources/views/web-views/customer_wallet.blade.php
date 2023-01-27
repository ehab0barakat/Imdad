@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Wallet'))

@push('css_or_js')
    <style>
        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif;
        }

        .card {
            border: none
        }

        .totals tr td {
            font-size: 13px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spandHeadO {
            color: #FFFFFF !important;
            font-weight: 600 !important;
            font-size: 14px;

        }

        .tdBorder {
            border- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 1px solid #f7f0f0;
            text-align: center;
        }

        .bodytr {
            text-align: center;
            vertical-align: middle !important;
        }

        .sidebar h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}                                   !important;
            transition: .2s ease-in-out;
        }

        tr td {
            padding: 10px 8px !important;
        }

        td button {
            padding: 3px 13px !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .orderDate {
                display: none;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }


        .wallet {

            background:#fff;
        }


        .wallet-left-one {


            background-color:#f8f8f9;
            width:100%
            
        }


        .wallet-left-one {

            display:flex;
            justify-content:space-around;
            border-radius:10px;
            padding:20px 0 10px 0;
        }


        .wallet-left-one > div {

            text-align:center
        }


        .wallet-left-one > div p {

            font-weight:600;
            padding-top:10px
        }

        .wallet-left-one button {

            border:1px solid #ECEDEE;
            padding:15px;
            background:#fff;
            border-radius:10px
        }


        .wallet-left-two {

            background:#fff;
            border:1px solid #E4E9F2;
            border-radius:10px;
            margin-top:30px;
            text-align:right;
            padding:0 20px 0 20px;
        }

        .wallet-left-two > div {

            margin:25px 0;
        }
        
        #Account , #Locations , #locations, #building , #notifications , #terms_conditions , #terms_conditions, #privacy_police{

            display:none
        }

     

    </style>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
@endpush

@section('content')

@php($user = App\CPU\Helpers::get_customer())

<div class="wallet">
    <div class="container">
        <div class="row" style="text-align:right;padding:2rem 0">
        
            <h4>
            👋 {{App\CPU\translate('good_moning')}} {{$user->f_name}} {{$user->l_name}}
            </h4>
        </div>
        <div class="row">
            <div class="col-md-8">

                <div class="wallet-right col-12" style="text-align:right;border:1px solid #E4E9F2;min-height:35rem">

                    <div id="Wallet">
                        <section style="padding:20px;border-bottom:1px solid #E4E9F2;display:flex;direction:rtl;justify-content:space-between">
                        <h5>{{App\CPU\translate('Wallet')}}</h5>
                        <h5>{{$wallet->balance}} ريال</h5>
                        </section>

                        @empty($get_orders)
                        <section style="margin-top:8rem">
                            
                            <div><img src="{{asset('images/empty-wallet.png')}}" alt="" style="display:block;margin:auto"></div>
                            <div><p style="text-align:center">لا توجد عمليات حاليا</p></div>
                        </section>
                        @endempty


                        @isset($get_orders)

                            @foreach($get_orders as $val)
                                <section style="width:90%;margin:auto">

                                <table class="table" style="direction:rtl;text-align:center">
                                    <thead>
                                        <tr>
                                        <th scope="col">العملية</th>
                                        <th scope="col">التاريخ</th>
                                        <th scope="col">القيمة</th>
                                      
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <th scope="row">
                                            @if($val->order_status == 'canceled')
                                            <a href="{{route('customer.transactions.details', ['id' => $val->id])}}"> مرتجع </a>
                                            @endif

                                            @if($val->order_status == 'delivered')
                                                <a href="{{route('customer.transactions.details', ['id' => $val->id])}}"> مشتريات </a>
                                            @endif
                                        </th>

                                            @php($myDate = date('d-m-Y', strtotime($val->created_at)))
                                        <td>{{$myDate}}</td>
                                        
                                        <td>
                                        @if($val->order_status == 'canceled')
                                        <span class="badge bg-success">{{number_format($val->order_amount,2)}} </span>
                                        @endif

                                        @if($val->order_status == 'delivered')
                                        <span class="badge bg-danger">{{number_format($val->order_amount,2)}} </span>
                                        @endif

                                        </td>
                                        
                                        </tr>
                                        <tr>
                                       
                                    </tbody>
                                </table>


                                    <div>
                                       
                                    </div>
                                  
                                </section>
                            @endforeach

                        @endisset
                        
                        
                    </div>

                    <div id="Account" class="tabcontent">

                        <section style="padding:20px;border-bottom:1px solid #E4E9F2;display:flex;justify-content:space-between">
                            <button type="submit" form="customer_account" formaction="{{route('customer.account.update')}}" id="account_submit" class="btn btn-primary" disabled>{{App\CPU\translate('save')}}</button>
                            <h5>{{App\CPU\translate('my_account')}}</h5>
                        </section>

                        <section style="text-align:right;direction:rtl;width:90%;margin:30px auto 0 auto">
                           <form action="{{route('customer.account.update')}}" method="post" id="customer_account">
                                @csrf

                                <input type="hidden" name="myId" value="{{$get_user->id}}">
                           <div class="row">
                                <div class="col">
                                    <label for="">{{App\CPU\translate('name')}}</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{$get_user->name}}" id="" aria-label="First name">
                                </div>
                                <div class="col">
                                    <label for="">{{App\CPU\translate('email')}}</label>
                                    @isset($get_user->email)
                                    <input type="email" id="email" name="email" value="{{$get_user->email}}" class="form-control"  aria-label="Last name">
                                    @endisset

                                    @empty($get_user->email)
                                    <input type="email" id="email" name="email" class="form-control"  aria-label="Last name">
                                    @endempty
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col">
                                    <label for="">{{App\CPU\translate('account_phone_number')}}</label>
                                    <input type="number" name="phone" class="form-control" value="{{$get_user->phone}}" disabled aria-label="First name">
                                </div>

                                @isset($get_user->whats)
                                <div class="col">
                                    <label for="">{{App\CPU\translate('whats_app_no')}}</label>
                                    <input type="number" id="whats" value="{{$get_user->whats}}" name="whats" class="form-control" aria-label="First name">
                                </div>
                                @endisset 

                                @empty($get_user->whats)
                                <div class="col">
                                    <label for="">{{App\CPU\translate('whats_app_no')}}</label>
                                    <input type="number" id="whats" name="whats" class="form-control" aria-label="First name">
                                </div>
                                @endempty
                               
                            </div>

                            <br>

                            <div class="row">
                            <div class="col">
                                    <label for="">{{App\CPU\translate('job')}}</label>
                                    <select name="position" id="position" class="form-control">
                                        <option value="صاحب منشاة">{{App\CPU\translate('owner')}}</option>
                                        <option value="مدير مبيعات">{{App\CPU\translate('sales_manager')}}</option>
                                        <option value="مدير مشتريات">{{App\CPU\translate('purchasing_manager')}}</option>
                                        <option value="مدير تشغيلي">{{App\CPU\translate('production_manager')}}</option>
                                        <option value="اخري">{{App\CPU\translate('other')}}</option>
                                    </select>
                                </div>
                            </div>
                                                         
                           </form>
                        </section>

                    </div>


                    <div id="locations" class="tabcontent">
                        <section style="padding:20px;border-bottom:1px solid #E4E9F2;display:flex;justify-content:space-between">
                            <a href="{{route('customer.add.new.location')}}" id="account_submit" class="btn btn-primary">اضافة مكان جديد</a>
                            <h5>{{App\CPU\translate('Location')}}</h5>
                        </section>
                        @foreach($CustomerLocations as $val)
                        <div class="card" style="width: 18rem;margin:10px">
                            <img src="{{asset('users/'.$val->building_image)}}" class="card-img-top" alt="...">
                            <a href="#" style="position:absolute;top:0.5rem;left:0.5rem" id="{{$val->id}}" class="delete_location">
                            <img src="{{asset('images/delete.png')}}" alt="" width="32" height="32" >
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{{$val->name}}</h5>
                            </div>
                        </div>
                        @endforeach
                        
                    </div>


                    <div id="building" class="tabcontent">
                        <form method="post" action="{{route('customer.building.update')}}" id="customer_buliding_update" style="width:90%;margin:20px auto;direction:rtl">
                            @csrf

                            <input type="hidden" name="myId" value="{{$get_user->id}}">

                            @isset($get_user->building_name)
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">{{App\CPU\translate('building_name')}}</label>
                                    <input type="text" name="building_name" value="{{$get_user->building_name}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                
                                </div>
                            @endisset 

                            @empty($get_user->building_name)
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">{{App\CPU\translate('building_name')}}</label>
                                    <input type="text" name="building_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                
                                </div>
                            @endempty

                            @isset($get_user->building_email)
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">{{App\CPU\translate('company_email')}}</label>
                                <input type="email" value="{{$get_user->building_email}}" name="building_email" class="form-control" id="exampleInputPassword1">
                            </div>
                            @endisset

                            @empty($get_user->building_email)
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">{{App\CPU\translate('company_email')}}</label>
                                <input type="email" name="building_email" class="form-control" id="exampleInputPassword1">
                            </div>
                            @endempty

                            <div class="row">

                                <div class="mb-3 col-6">
                                    <label for="exampleInputPassword1" class="form-label">{{App\CPU\translate('business_type')}}</label>
                                        <select name="building_type" id="" class="form-control">
                                            <option value="البقالات">{{App\CPU\translate('markets')}}</option>
                                            <option value="المطاعم">{{App\CPU\translate('resutrans')}}</option>
                                            <option value="المقاهي">{{App\CPU\translate('coffe')}}</option>
                                            <option value="الفنادق">{{App\CPU\translate('hotels')}}</option>
                                            <option value="القاعات">{{App\CPU\translate('halls')}}</option>
                                            <option value="الكفتيريا">{{App\CPU\translate('sub_coffe')}}</option>
                                            <option value="المدارس">{{App\CPU\translate('schools')}}</option>
                                            <option value="المكاتب">{{App\CPU\translate('libary')}}</option>
                                        </select>
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="exampleInputPassword1" class="form-label">{{App\CPU\translate('business_size')}}</label>
                                        <select name="building_size" id="" class="form-control">
                                            <option value="فرع واحد">{{App\CPU\translate('one_branche')}}</option>
                                            <option value="2 فرع">{{App\CPU\translate('two_branch')}}</option>
                                            <option value=" 3 فروع فاكثر">{{App\CPU\translate('three_branch')}}</option>
                                        </select>
                                </div>

                            </div>
                        

                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">{{App\CPU\translate('month_purchasing')}}</label>
                                        <select name="month_purchasing" id="" class="form-control">
                                            <option value="اكثر من 150,000">{{App\CPU\translate('more_than_150000')}}</option>
                                            <option value="من 50,000 الي 100,000">{{App\CPU\translate('between_two_no')}}</option>
                                            <option value=" اقل من 50,000">{{App\CPU\translate('less_than_50000')}}</option>
                                        </select>
                            </div>

                            @isset($get_user->tax_no)
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">{{App\CPU\translate('tax_no')}}</label>
                                <input type="number" name="tax_no" value="{{$get_user->tax_no}}" class="form-control" id="exampleInputPassword1">
                            </div>
                            @endisset

                            @empty($get_user->tax_no)
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">{{App\CPU\translate('tax_no')}}</label>
                                <input type="number" name="tax_no" class="form-control" id="exampleInputPassword1">
                            </div>
                            @endempty

                            @isset($get_user->commercial_no)
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">{{App\CPU\translate('tax_no_res')}}</label>
                                <input type="number" value="{{$get_user->commercial_no}}" name="commercial_no" class="form-control" id="exampleInputPassword1">
                            </div>
                            @endisset 

                            @empty($get_user->commercial_no)
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">{{App\CPU\translate('tax_no_res')}}</label>
                                <input type="number" name="commercial_no" class="form-control" id="exampleInputPassword1">
                            </div>
                            @endempty
                           
                            <button type="submit" class="btn btn-primary">{{App\CPU\translate('save')}}</button>
                        </form>
                    </div>


                    <div id="notifications" class="tabcontent">
                        <div class="row">
                            
                            @foreach($get_banner as $banner)
                            <div class="card col-md-5" style="padding:0;justify-content:space-evenly;margin:20px auto">
                                <img src="{{asset('banner/'.$banner->photo)}}" class="card-img-top" alt="..." style="width:100%;height:200px">
                                <div class="card-body">
                                    @php($myDate = date('d-m-Y', strtotime($banner->expire)))
                                    @php($current_date = date("d-m-Y"))
                                    <h6 style="margin:bottom:2rem;text-align:right">{{$banner->title}}</h6>
                                    <section style="display:flex;justify-content:space-between;direction:rtl">
                                    <p>{{$myDate}}</p>
                                    @if($myDate > $current_date) 
                                    <a href="#" class="btn btn-danger">{{App\CPU\translate('Inactive')}}</a>
                                    @else 
                                    <a href="#" class="btn btn-success">{{App\CPU\translate('active')}}</a>
                                    </section>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>


                    <div id="terms_conditions" style="direction:rtl;padding:20px 10px;text-align:justify">
                       {!! $terms_condition->value !!}
                    </div>



                    <div id="privacy_police" style="direction:rtl;padding:20px 10px;text-align:justify">
                        {!! $privacy_police->value !!}
                    </div>

                </div>
            </div>

            <div class="col-md-4 wallet-left-side">

                <section class="wallet-left-one">

                    <div>
                        <button class="account"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-uop-c154="" d="M15.9997 15.9998C19.6816 15.9998 22.6663 13.0151 22.6663 9.33317C22.6663 5.65127 19.6816 2.6665 15.9997 2.6665C12.3178 2.6665 9.33301 5.65127 9.33301 9.33317C9.33301 13.0151 12.3178 15.9998 15.9997 15.9998Z" stroke="#6E7579" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round"></path><path _ngcontent-uop-c154="" d="M27.4535 29.3333C27.4535 24.1733 22.3202 20 16.0002 20C9.6802 20 4.54687 24.1733 4.54687 29.3333" stroke="#6E7579" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>
                    <p>{{App\CPU\translate('my_account')}}</p>
                    </div>
                    
                    <div>
                    <button class="locations"><svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path _ngcontent-uop-c154="" d="M16.4998 17.9064C18.7973 17.9064 20.6598 16.0439 20.6598 13.7464C20.6598 11.4489 18.7973 9.58643 16.4998 9.58643C14.2023 9.58643 12.3398 11.4489 12.3398 13.7464C12.3398 16.0439 14.2023 17.9064 16.4998 17.9064Z" stroke="#6E7579" stroke-width="1.875"></path><path _ngcontent-uop-c154="" d="M5.3266 11.3198C7.95327 -0.226826 25.0599 -0.213493 27.6733 11.3332C29.2066 18.1065 24.9933 23.8398 21.2999 27.3865C18.6199 29.9732 14.3799 29.9732 11.6866 27.3865C8.0066 23.8398 3.79327 18.0932 5.3266 11.3198Z" stroke="#6E7579" stroke-width="1.875"></path></svg></button>
                    <p>{{App\CPU\translate('Location')}}</p>
                    </div>
                    
                    <div>
                        <button class="building"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.667 29.3336L5.44029 29.3336C3.89362 29.3336 2.62695 28.0936 2.62695 26.5736L2.62695 6.78697C2.62695 3.29364 5.22695 1.70697 8.41362 3.26697L14.3336 6.17364C15.6136 6.8003 16.667 8.46697 16.667 9.8803L16.667 29.3336Z" stroke="#6E7579" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round"></path><path _ngcontent-uop-c154="" d="M29.2937 20.0802L29.2937 25.1202C29.2937 28.0002 27.9603 29.3336 25.0803 29.3336L16.667 29.3336L16.667 13.8936L17.2937 14.0269L23.2937 15.3736L26.0003 15.9736C27.7603 16.3602 29.2003 17.2669 29.2803 19.8269C29.2937 19.9069 29.2937 19.9869 29.2937 20.0802Z" stroke="#6E7579" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round"></path><path _ngcontent-uop-c154="" d="M7.33301 12L11.9597 12" stroke="#6E7579" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path _ngcontent-uop-c154="" d="M7.33301 17.3335L11.9597 17.3335" stroke="#6E7579" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path _ngcontent-uop-c154="" d="M23.293 15.3735L23.293 19.6669C23.293 21.3202 21.9463 22.6669 20.293 22.6669C18.6396 22.6669 17.293 21.3202 17.293 19.6669L17.293 14.0269L23.293 15.3735Z" stroke="#6E7579" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path _ngcontent-uop-c154="" d="M29.2796 19.8269C29.1996 21.4002 27.893 22.6669 26.293 22.6669C24.6396 22.6669 23.293 21.3202 23.293 19.6669L23.293 15.3735L25.9996 15.9735C27.7596 16.3602 29.1996 17.2669 29.2796 19.8269Z" stroke="#6E7579" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>
                    <p>{{App\CPU\translate('building')}}</p>
                    </div>
                    
                </section>


                <section class="wallet-left-two">

                    <div>
                        <strong><a href="#" id="wallet_customer">{{App\CPU\translate('Wallet')}}</a></strong>
                        <img src="{{asset('images/notifications.svg')}}" alt="" style="background:#f0f4fc;padding:12px;border-radius:45%">
                    </div>

                    <div>
                        <strong><a href="#" id="customer_notifications">{{App\CPU\translate('Notifications')}}</a></strong>
                        <img src="{{asset('images/notifications.svg')}}" alt="" style="background:#f0f4fc;padding:12px;border-radius:45%">
                    </div>
                    
                    <div>
                        <strong><a href="#" id="customer_privacy_police">{{App\CPU\translate('privacy_policy')}}</a></strong>
                        <img src="{{asset('images/shield.svg')}}" alt="" style="background:#f0f4fc;padding:12px;border-radius:45%">
                    </div>

                    
                    <div>
                        <strong><a href="#" id="customer_terms_conditions">{{App\CPU\translate('terms_and_condition')}}</a></strong>
                        <img src="{{asset('images/info.svg')}}" alt="" style="background:#f0f4fc;padding:12px;border-radius:45%">
                    </div>

                    
                    <div>
                        <strong><a target="_blank" href="https://play.google.com/store/apps/details?id=com.emdad.yemenb2b">{{App\CPU\translate('download_app')}}</a></strong>
                        <img src="{{asset('images/arrow-down.svg')}}" alt="" style="background:#f0f4fc;padding:12px;border-radius:45%">
                    </div>

                </section>
            </div>
        </div>
    </div>
</div>


@endsection

@push('script')
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9NsykqPN9rg4y4MR4wad3DMkkJvRyGFI&callback=initMap&v=weekly"
      defer
    ></script>
    <script>
        function cancel_message() {
            toastr.info('{{\App\CPU\translate('order_can_be_canceled_only_when_pending.')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>

 <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script>

           
        $(document).ready(function() {

            
           

            $('#wallet_customer').click(function(){

                $('#Account').css('display', 'none');
                $('#Wallet').css('display', 'block');
                $('#locations').css('display', 'none');
                $('#building').css('display', 'none');
                $('#notifications').css('display', 'none');
                $('#terms_conditions').css('display', 'none');
                $('#privacy_police').css('display', 'none');
                

            })

            $('.account').click(function(){

                $('#Account').css('display', 'block');
                $('#Wallet').css('display', 'none');
                $('#locations').css('display', 'none');
                $('#building').css('display', 'none');
                $('#notifications').css('display', 'none');
                $('#terms_conditions').css('display', 'none');
                $('#privacy_police').css('display', 'none');

            });


            $('.locations').click(function(){

                $('#Account').css('display', 'none');
                $('#Wallet').css('display', 'none');
                $('#building').css('display', 'none');
                $('#locations').css('display', 'block');
                $('#notifications').css('display', 'none');
                $('#terms_conditions').css('display', 'none');
                $('#privacy_police').css('display', 'none');
                
            });


            $('.building').click(function(){
               
                $('#Account').css('display', 'none');
                $('#Wallet').css('display', 'none');
                $('#locations').css('display', 'none');
                $('#building').css('display', 'block');
                $('#notifications').css('display', 'none');
                $('#terms_conditions').css('display', 'none');
                $('#privacy_police').css('display', 'none');
                

            });


            $('#customer_notifications').click(function(){

                $('#Account').css('display', 'none');
                $('#Wallet').css('display', 'none');
                $('#locations').css('display', 'none');
                $('#building').css('display', 'none');
                $('#notifications').css('display', 'block');
                $('#terms_conditions').css('display', 'none');
                $('#privacy_police').css('display', 'none');

            });


            $('#customer_terms_conditions').click(function(){

                $('#Account').css('display', 'none');
                $('#Wallet').css('display', 'none');
                $('#locations').css('display', 'none');
                $('#building').css('display', 'none');
                $('#notifications').css('display', 'none');
                $('#terms_conditions').css('display', 'block');
                $('#privacy_police').css('display', 'none');

            });


            $('#customer_privacy_police').click(function(){

                $('#privacy_police').css('display', 'block');
                $('#Account').css('display', 'none');
                $('#Wallet').css('display', 'none');
                $('#locations').css('display', 'none');
                $('#building').css('display', 'none');
                $('#notifications').css('display', 'none');
                $('#terms_conditions').css('display', 'none');
                

            })
            


        });


        $('#name').on('keyup',function(){

            $('#account_submit').attr('disabled', null);

        });


        $('#email').on('keyup', function(){

            $('#account_submit').attr('disabled', null);

        })


        $('#whats').on('keyup', function(){

        $('#account_submit').attr('disabled', null);

        });


        $('#position').on('change', function(){

        $('#account_submit').attr('disabled', null);

        });
        
        

        $('#customer_account').submit(function(e){

            e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type:'POST',
                    url: "{{ route('customer.account.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        if (response) {
                            this.reset();
                            Swal.fire(
                                'تم تعديل بيانات الحساب'
                                )
                                location.reload();
                        }
                    },
                    error: function(response){
                        $('#image-input-error').text(response.responseJSON.message);
                    }
                });

                // console.log('good');

        });




        $('#customer_buliding_update').submit(function(e){

            e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type:'POST',
                    url: "{{ route('customer.building.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        if (response) {
                            this.reset();
                            Swal.fire(
                                'تم تعديل بيانات المنشاة'
                                )
                                location.reload();
                        }
                    },
                    error: function(response){
                        $('#image-input-error').text(response.responseJSON.message);
                    }
                });

                // console.log('good');


                $('.delete_location').on('click', function(){

                    let myId = $(this).attr('id');

                    $.ajax({
                        type:'GET',
                        url: '/customer/locations/delete/'+ myId +'',
                        success: (response) => {
                            if (response) {
                                Swal.fire(
                                    'تم حذف الموقع بنجاح',
                                    )
                                    location.reload();
                            }
                        },
                    
                    });

                });

        });

        
</script>
@endpush
