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
<section class="features-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            @if($categories->count() >0)
                @foreach($categories as $category)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="features-box" data-clickable="true"
                        data-href="{{url('faq/'.$category->id.'/details')}}">
                            <div class="icon">
                                <i class='bx bx-reset'></i>
                            </div>
                            <h3>{{$category->category_name}}</h3>
                            <p>
                                {{$category->description}}
                            </p>

                            <div class="back-icon">
                                <i class='bx bx-atom'></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="features-box">
                        <h3>No resource found.</h3>
                        <p>Please use the Help Desk option in the menu.</p>
                        <div class="back-icon">
                            <i class='bx bx-reset'></i>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- End FAQ Area -->

@include('templates/footer')
