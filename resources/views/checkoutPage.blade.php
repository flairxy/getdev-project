@extends('layouts.student')

@section('content')

<style>
    .mydrop {
        /* background: #76739B; */
        color: #453DA0;
    }

    .mydrop:hover {
        background: #76739B !important;
    }

    .get {
        color: #e0e2e6;
    }

    .user-thumb {
        display: inline-block;
        height: 32px;
        width: 32px;
        line-height: 32px;
        color: #fff;
        border-radius: 50%;
        background: #52a846;
        text-align: center;
    }

    .mt-80 {
        margin-top: 90px !important;
        padding: 30px !important
    }

    #processing {
        display: none
    }
</style>
<div class="container mt-80 bg-white-op-90">
    <div class="row">
        <div class="main-content col-lg-8">
            <div class="col-12">
                <p class="text-danger" id="error"></p>
                <p class="text-success font-w700" id="success"></p>
            </div>
            <div class="content-area bottom-course">
                <form method="POST" action="{{ route('subscribe') }}">
                    @csrf
                    <div class="form-group col-lg-6 col-md-12">
                        <label class="input-item-label">Package</label>
                        <div class="select-wrapper">
                            <select class="form-control" id="cat" required>
                                <option class="mydrop" value>Choose Package</option>
                                @foreach ($plans as $plan)
                                <option class="mydrop" value="{{ $plan->amount }}">{{ $plan->name }}
                                    ({{ $plan->duration }} Months)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" class="input-bordered" id="cat-amount" name="amount" value="" />

                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        <span class="cl1">TOTAL</span>
                                    </span>
                                    <span class="mydrop link-ucap h5"
                                        id="course-value">{{ config('services.bpay.currency') }}0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="processing" class="col-6 col-md-3 mt-3">
                        <i class="fa fa-2x fa-cog fa-spin text-success"></i>
                    </div>
                    <div id="notProc" class="col-6 col-lg-3 mt-3">
                        <button class="btn btn-sm btn-success">Subscribe Now</button>
                    </div>
                </form>
            </div>
            <br>
            <!-- .card -->
            <div class="content-area bottom-course mb-4">
                <h6 class="card-title card-title-sm caps">Account Information</h6>
                <span class="text-sm cl1"><em class="fa fa-check-circle text-success"></em> You are currently logged in
                    as <span class="text-success">{{ auth::user()->email }}</span>
                    <a class="cl1 ml-4" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                        {{ __('Log out') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </span>
            </div>
            <!-- .card -->
        </div>
        <!-- .col -->
        <div class="aside sidebar-right col-lg-4">
            {{-- <div class="bottom-course"> --}}
            <span class="get mb-4">Here's what you'll get...</span>
            <ul class="list-check mt-3">
                <li>Pattens of proven performance on how To Create A Highly Profitable Wealth Machine & Income Streams.
                </li>
                <li>How to structure your personal finances.</li>
                <li>How to become financially independent.</li>
                <li>How to build an Amazing Lifestyle.</li>
                <li>10X Powerful income streams.</li>
                <li>How to invest your wealth.</li>
            </ul>

            {{-- </div>z --}}
        </div>
        <!-- .col -->
    </div>
    <!-- .container -->
</div>

@endsection

@section('js_after')
<script>
    $('#cat').on('change', function() {
         let x =   $( "#cat option:selected" ).val();
         document.getElementById("course-value").innerHTML = '$'+x;
         document.getElementById("cat-amount").value = x;
    });

    $("form").submit(function(e){
        e.preventDefault(); //prevent default action
        $('#notProc').hide();
        $('#processing').show();
        let form_data = $(this).serialize(); //Encode form elements for submission

    $.ajax({
        url : "{{ route('subscribe') }}",
        type: 'POST',
        data : form_data
        }).done(function(response){
            if(response.status == 'error'){
                $("#error").html(response.message);
                $('#notProc').show();
                $('#processing').hide();
            }
            $(function() {
                $('#qrcode a').qrcode({
                    render: 'image',
                    text: "1Agb153xWsbqS9vt8gP4vBFKHkAchLMdSX",
                    ecLevel: 'L',
                    size: "203"
                });
            });
            $("#success").html(response.message);
            $('#notProc').show();
            $('#processing').hide();

        });
    });
</script>

@endsection
