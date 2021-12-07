@include('templates/headers')
<!-- Start Page Title Area -->
<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2>{{$pageName}}</h2>
            <p>{{$slogan}}</p>
        </div>
    </div>
</div>
<!-- End Page Title Area -->

<!-- Start FAQ Area -->
<section class="faq-area ptb-100">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-12">
                <div class="faq-accordion">
                    <ul class="accordion">
                        @if($faqs->count() >0)
                            @foreach($faqs as $faq)
                                <li class="accordion-item">
                                    <a class="accordion-title active" href="javascript:void(0)">
                                        <i class="bx bx-plus"></i>
                                        {{ $faq->question}}
                                    </a>

                                    <p class="accordion-content">
                                        {!! $faq->answer !!}
                                    </p>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-lg-5 col-md-12">
                <div class="faq-image">
                    <img src="{{ asset('home/img/faq-img1.png')}}" alt="image">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End FAQ Area -->

@include('templates/footer')
