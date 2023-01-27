
@extends('layouts.back-end.app-seller')

@section('title', 'الاعدادات')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">الاعدادات</h1>
                </div>
                @php($shop=\App\Model\Shop::where(['seller_id'=>auth('seller')->id()])->first())

                @isset($shop)
                <strong>{{$shop->name}}</strong>
                @endisset
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-12">
                @include('seller-views.settings.sidebar')
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                <div class="card-header">
                        <h3>اختار الفرع</h3>
                        <select name="branche_id" id="branch_id_notifications" class="form-control rounded-pill" style="width: 115px;">
                            <option selected>اختر الفرع</option>
                            @foreach ($branches as $branche)
                                <option value="{{ $branche->id }}">{{ $branche->branche_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-body" id="alert_card_body">
                     
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
