@extends('layouts.simple')

@section('content')
<!-- Hero -->
<div class="ac-bg-image bg-white-op-90" style="background-image: url('{{ asset('images/hero.webp') }}')">
    <div class="ac-hero ac-h60  overflow-hidden">
        <div class="hero-inner">
            <div class="content content-full">
                <div class="container">
                    <div class="pt-100 ac-content">
                        <h1 class="ac-capture">
                            Build your skills and expertise
                        </h1>
                        <h2 class="ac-lead h5 text-muted">
                            Learn from our repository of quality educational material
                        </h2>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <p class="text-primary-light ac-description">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus suscipit, neque
                                    est
                                    tempora.
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <form class="push" action="" method="post">
                                    <div class="input-group input-group-lg bg-primary-lighter">
                                        <input type="text" class="form-control ac-14 text-primary bg-primary-lighter"
                                            placeholder="Find courses in your field of interest">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn text-white bg-primary-light">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="content content-full mt-30 p-30 bg-white-op-90">
    <div class="row">
        <div class="col-lg-4 col-md-4 text-center mb-20">
            <i class="si si-layers fa-3x font-w700 text-primary"></i>
            <h6 class="h5 font-w700 mt-3">Lorem ipsum dolor sit amet. </h6>
            <p class="text-primary-light">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Deserunt
                repellat, eveniet corrupti provident vel voluptas quae ullam eaque?</p>
            <button type="button" class="btn btn-outline-primary min-width-125">Find the right course for you <i
                    class="fa fa-angle-right font-w300"></i></button>
        </div>
        <div class="col-lg-4 col-md-4 text-center mb-20">
            <i class="fa fa-bitcoin fa-3x text-primary"></i>
            <h6 class="h5 font-w700 mt-3">Lorem ipsum dolor sit amet. </h6>
            <p class="text-primary-light">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Deserunt
                repellat, eveniet corrupti provident vel voluptas quae ullam eaque?</p>
            <button type="button" class="btn btn-outline-primary min-width-125">Explore Categories <i
                    class="fa fa-angle-right font-w300"></i></button>
        </div>
        <div class="col-lg-4 col-md-4 text-center mb-20">
            <i class="fa fa-share-alt fa-3x text-primary"></i>
            <h6 class="h5 font-w700 mt-3">Lorem ipsum dolor sit amet. </h6>
            <p class="text-primary-light">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Deserunt
                repellat, eveniet corrupti provident vel voluptas quae ullam eaque?</p>
            <button type="button" class="btn btn-outline-primary min-width-125">Become a Tutor <i
                    class="fa fa-angle-right font-w300"></i></button>
        </div>
    </div>
</div>

{{-- bg-white-op-90 --}}

<div class="container">
    <div class="content content-full">

        <div class="row">
            <div class="col-12">
                <div class="ac-h-scroll">
                    <ul class="ac-course-nav">
                        <li class="ac-course-li">
                            <a class="btn btn-primary" href="#">
                                Design
                            </a>
                        </li>

                        <li class="ac-course-li">
                            <a href="#">Development</a>
                        </li>
                        <li class="ac-course-li">
                            <a href="#">Entrepreneurship
                            </a>

                        </li>
                        <li class="ac-course-li">
                            <a href="#">Writing</a>

                        </li>
                        <li class="ac-course-li">
                            <a href="#">Marketing</a>

                        </li>
                        <li class="ac-course-li">
                            <a href="#">Project Management</a>

                        </li>
                        <li class="ac-course-li">
                            <a href="#">Photography</a>

                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="row">

            {{-- box 1 --}}
            <div class="col-6 col-lg-3">
                <div class="block block-themed text-center ac-box">
                    <a class="block block-link-pop bg-white-op-90 text-center" href="javascript:void(0)">

                        <div class="block mb-2 ac-sm-box-img">
                            <img class="ac-img" src="{{ asset('images/bg.jpg') }}" alt="">
                        </div>
                        <div class="ac-title-pad">
                            <span class="ac-course-title text-primary">Fundamentals of Typography</span>
                            <span class="font-w300 ac-author">Rachel Okorie</span>
                        </div>

                        <div class="ac-title-pad">
                            <span class="font-w400 ac-time">8 lessons (2hr, 27mins)</span>
                        </div>

                        <div class="ac-title-pad ac-author text-muted">
                            <span class="js-rating">
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                            </span> 5.0 (21,000)
                        </div>

                        <div class="ac-title-pad text-right">
                            <span class="h5 font-w700 text-primary pr-20">$9.99</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- box 2 --}}
            <div class="col-6 col-lg-3">
                <div class="block block-themed text-center ac-box">
                    <a class="block block-link-pop bg-white-op-90 text-center" href="javascript:void(0)">

                        <div class="block mb-2 ac-sm-box-img">
                            <img class="ac-img" src="{{ asset('images/bg.jpg') }}" alt="">
                        </div>
                        <div class="ac-title-pad">
                            <span class="ac-course-title text-primary">Fundamentals of Typography</span>
                            <span class="font-w300 ac-author">Rachel Okorie</span>
                        </div>

                        <div class="ac-title-pad">
                            <span class="font-w400 ac-time">8 lessons (2hr, 27mins)</span>
                        </div>

                        <div class="ac-title-pad ac-author text-muted">
                            <span class="js-rating">
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                            </span> 5.0 (21,000)
                        </div>

                        <div class="ac-title-pad text-right">
                            <span class="h5 font-w700 text-primary pr-20">$9.99</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- box3 --}}
            <div class="col-6 col-lg-3">
                <div class="block block-themed text-center ac-box">
                    <a class="block block-link-pop bg-white-op-90 text-center" href="javascript:void(0)">

                        <div class="block mb-2 ac-sm-box-img">
                            <img class="ac-img" src="{{ asset('images/bg.jpg') }}" alt="">
                        </div>
                        <div class="ac-title-pad">
                            <span class="ac-course-title text-primary">Fundamentals of Typography</span>
                            <span class="font-w300 ac-author">Rachel Okorie</span>
                        </div>

                        <div class="ac-title-pad">
                            <span class="font-w400 ac-time">8 lessons (2hr, 27mins)</span>
                        </div>

                        <div class="ac-title-pad ac-author text-muted">
                            <span class="js-rating">
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                            </span> 5.0 (21,000)
                        </div>

                        <div class="ac-title-pad text-right">
                            <span class="h5 font-w700 text-primary pr-20">$9.99</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- box4 --}}
            <div class="col-6 col-lg-3">
                <div class="block block-themed text-center ac-box">
                    <a class="block block-link-pop bg-white-op-90 text-center" href="javascript:void(0)">

                        <div class="block mb-2 ac-sm-box-img">
                            <img class="ac-img" src="{{ asset('images/bg.jpg') }}" alt="">
                        </div>
                        <div class="ac-title-pad">
                            <span class="ac-course-title text-primary">Fundamentals of Typography</span>
                            <span class="font-w300 ac-author">Rachel Okorie</span>
                        </div>

                        <div class="ac-title-pad">
                            <span class="font-w400 ac-time">8 lessons (2hr, 27mins)</span>
                        </div>

                        <div class="ac-title-pad ac-author text-muted">
                            <span class="js-rating">
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                                <i data-alt="2" class="fa fa-fw fa-star text-warning"></i>
                            </span> 5.0 (21,000)
                        </div>

                        <div class="ac-title-pad text-right">
                            <span class="h5 font-w700 text-primary pr-20">$9.99</span>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <div class="row text-center">
            <div class="col-12">
                <a href="#" class="btn btn-outline-primary min-width-125">View all categories <i
                        class="fa fa-angle-right font-w300"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="bg-image" style="background-image: url('{{ asset('images/bat.png') }}');">
    <div class="bg-black-op-75">
        <div class="content content-top text-center">
            <div class="py-100">
                <h1 class="font-w700 text-white mb-10">Become a D'academi Tutor</h1>
                <h2 class="h4 font-w400 text-white-op">Join to tutors to impact knowledge and earn while you are at it.
                </h2>
                <div class="font-size-md text-muted">
                    <a href="{{ route('tutorSignup') }}" class="btn btn-lg btn-primary min-width-125">Join Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{--
<div class="bg-white-op-75 py-30">
    <div class="content text-center">
        <h3 class="font-w700 mb-10">From Our Students</h3>
        <div class="row text-center">
            <div class="col-12">
                <div class="block-content block-content-full bg-white-op-10">
                    <img class="img-avatar img-avatar-thumb" src="\{{ asset('images/bg.jpg') }}" alt="">
</div>
<span class="ac-testiminial-usr">Okorie Rachel</span>
<div class="container mb-10 col-lg-8">
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus, quibusdam? Est nulla illo
    odio incidunt enim laborum error exercitationem, dolor mollitia cupiditate laboriosam amet
    dicta, ex pariatur ratione odit dolorem.
</div>
</div>
</div>
</div>
</div> --}}


@include('layouts.footer')






<!-- END Hero -->
@endsection
