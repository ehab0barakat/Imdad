@php 
$user = App\CPU\Helpers::get_customer();
$cart_count = \App\Model\Cart::where('customer_id', '=', $user->id)->count('id');
@endphp
<div class="feature_header">
    <span>{{ __('messages.product_in_cart')}}</span>
    <small style="color:#c1c1c1;margin:0 5px">{{$cart_count.__('messages.product')}}</small>
</div>

<!-- Grid-->
<hr class="view_border">
@php($shippingMethod=\App\CPU\Helpers::get_business_settings('shipping_method'))
@php($cart=\App\Model\Cart::where(['customer_id' => auth('customer')->id()])->get()->groupBy('cart_group_id'))

<div class="row">
    <!-- List of items-->
    <section class="col-lg-9">
        
            @foreach($cart as $group)
            <div class="cart_information mb-3">
                @foreach($group as $cart_key=>$cartItem)
                @if ($shippingMethod=='inhouse_shipping')
                    <?php
                        
                        $admin_shipping = \App\Model\ShippingType::where('seller_id',0)->first();
                        $shipping_type = isset($admin_shipping)==true?$admin_shipping->shipping_type:'order_wise';
                        
                    ?>
                @else
                    <?php
                        if($cartItem->seller_is == 'admin'){
                            $admin_shipping = \App\Model\ShippingType::where('seller_id',0)->first();
                            $shipping_type = isset($admin_shipping)==true?$admin_shipping->shipping_type:'order_wise';
                        }else{
                            $seller_shipping = \App\Model\ShippingType::where('seller_id',$cartItem->seller_id)->first();
                            $shipping_type = isset($seller_shipping)==true?$seller_shipping->shipping_type:'order_wise';
                        }
                    ?>
                @endif
                
                  
                
                @endforeach
                <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        style="width: 100%;text-align:center">
                      
                            
                @foreach($group as $cartItem)

                
                
                <div class="row">
                    <div class="parent d-flex justify-content-between align-items-center col-12">

                        <div class="cart-items d-flex col-4 justify-content-between align-items-center">
                    
                            <div class="product-quantity d-flex justify-content-between align-items-center">
                                <div
                                    class="d-flex justify-content-center align-items-center"
                                    style="width: 160px;color: {{$web_config['primary_color']}}">
                                    <span class="input-group-btn" style="">
                                        <button class="btn btn-number" type="button"
                                            data-type="minus" onclick="qnatityPlus()" id="quanatiyMinus" data-field="quantity"
                                            disabled="disabled" style="padding: 10px;color: {{$web_config['primary_color']}}">
                                            -
                                        </button>
                                    </span>

                                    <input type="text" name="quantity"
                                    class="form-control input-number text-center cart-qty-field"
                                    placeholder="1"  min="1" max="100" id="proQuantityCart"
                                    style="padding: 0px !important;width: 40%;height: 25px;" value="{{$cartItem->quantity}}">
                                    <input type="hidden" id="cart_item_price" value="{{$cartItem->price}}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-number" type="button" data-type="plus"
                                        data-field="quantity" onclick="qnatityPlus()" id="qnatityPlus" style="padding: 10px;color: {{$web_config['primary_color']}}">
                                            +
                                        </button>
                                    </span>

                                                
                                </div>
                                            
                            </div>

                            <div class="pro-img">
                                <a class="d-block {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}" href="{{route('product.view', ['id' => $cartItem->product_id])}}">
                                    <img width="80" height="80"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset('product/thumbnail/'.$cartItem->thumbnail)}}"
                                        alt="Product"/>
                                </a>
                            </div>


                            <div class="pro-details">
                            <strong>{{$cartItem->name}}</strong>
                            <p>{{$cartItem->product_type}}</p>
                            </div>

                        </div>

                   


                    <div class="pro-unit d-flex">
                        <span>{{$cartItem->unit_numbers}}</span>
                        <span>{{$cartItem->unit}}</span>
                        <span style="margin:0 5px"> x </span>
                        <span>{{$cartItem->price}} ريال</span>
                    </div>


                    <div class="item-total" id="cartTotalItem" style="margin-left:2rem">
                        {{$cartItem->total}} ريال
                    </div>
                    </div>
                   
                </div>
                       
                @endforeach
            </table>
                <div class="mt-3"></div></div>
            </div>
            @endforeach

          

            @if( $cart->count() == 0)
                <div class="d-flex justify-content-center align-items-center">
                    <h4 class="text-danger text-capitalize">{{\App\CPU\translate('cart_empty')}}</h4>
                </div>
            @endif
        
    
        <div class="row pt-2">
            <div class="col-6">
                <a href="{{route('home')}}" class="btn btn-primary">
                    <i class="fa fa-{{Session::get('direction') === "rtl" ? 'forward' : 'backward'}} px-1"></i> {{\App\CPU\translate('continue_shopping')}}
                </a>
            </div>
            
            <div class="col-6">
                <a onclick="checkout()"
                   class="btn btn-primary pull-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                    {{\App\CPU\translate('checkout')}}
                    <i class="fa fa-{{Session::get('direction') === "rtl" ? 'backward' : 'forward'}} px-1"></i>
                </a>
            </div>
        </div>
    </section>
    <!-- Sidebar-->
    @include('web-views.partials._order-summary')
</div>


<script>
    cartQuantityInitialize();

    function set_shipping_id(id, cart_group_id) {
        $.get({
            url: '{{url('/')}}/customer/set-shipping-method',
            dataType: 'json',
            data: {
                id: id,
                cart_group_id: cart_group_id
            },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                location.reload();
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }
</script>
<script>
    function checkout(){
        let order_note = $('#order_note').val();
        //console.log(order_note);
        $.post({
            url: "{{route('order_note')}}",
            data: {
                    _token: '{{csrf_token()}}',
                    order_note:order_note,
                    
                },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                let url = "{{ route('checkout-details') }}";
                location.href=url;

            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }


    function qnatityPlus() {

        let myPrice = $('#cart_item_price').val();

        let myQuantity = $('#proQuantityCart').val();

        let summary_shipping = $('#summary_shipping').attr('name');

        let Total = myPrice * myQuantity;


        $('#cartTotalItem').text(Total + ' ريال');

        $('#summary_sub_total').text(Total + ' ريال');

        $('#cart_value').text((Total + summary_shipping) + ' ريال');


        
        // console.log(summary_shipping);

    }

    
    
</script>

