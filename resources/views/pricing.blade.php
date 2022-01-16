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

<!-- Start Pricing Area -->
<section class="pricing-area pt-100 pb-70 bg-f4f5fe">
    <div class="container">
        <div class="tab pricing-list-tab">

            <div class="tab_content">
                <div class="tabs_item">
                    <div class="row">
                        @foreach($currencies as $currency)
                            <div class="col-lg-4 col-md-6 col-sm-6 mx-auto">
                                <div class="single-pricing-table">
                                    <div class="pricing-header">
                                        <h3>{{$currency->code}}</h3>
                                    </div>
                                    <ul class="pricing-features">
                                        <li><i class="bx bxs-badge-check"></i> {{$currency->internalCharge}}%
                                            Escrow Charge
                                            <span class="tooltips bx bxs-info-circle"
                                                  data-toggle="tooltip" data-placement="right"
                                                  title="Capped at a maximum of {{$currency->code}} {{number_format($currency->maxCharge)}}
                                                      and minimum of {{$currency->code}} {{number_format($currency->minCharge)}}"></span></li>
                                        <li><i class="bx bxs-badge-check"></i> {{$currency->charge}}%
                                            Payment Charge
                                            <span class="tooltips bx bxs-info-circle"
                                                  data-toggle="tooltip" data-placement="right"
                                                  title="Capped at a minimum of {{$currency->code}} {{number_format($currency->sendMoneyChargeMin)}}
                                                      and maximum of {{$currency->code}} {{number_format($currency->sendMoneyChargeMax)}}"></span></li>
                                        <li>
                                            <i class="bx bxs-badge-check"></i> {{$currency->nonEscrowCharge}}%
                                            Non Escrow Transfer
                                            <span class="tooltips bx bxs-info-circle"
                                                  data-toggle="tooltip" data-placement="right"
                                                  title="Capped at a minimum of {{$currency->code}} {{number_format($currency->nonEscrowChargeMin)}}
                                                      and maximum of {{$currency->code}} {{number_format($currency->nonEscrowChargeMax)}}"></span>
                                        </li>

                                        <li><i class="bx bxs-badge-check"></i> Unlimited Transactions </li>
                                        <li><i class="bx bxs-badge-check"></i> T +1 Settlement Period </li>
                                    </ul>

                                    <div class="btn-box">
                                        <a href="register" class="default-btn"><i class="bx bxs-hot"></i> Start Now <span></span></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>
<!-- End Pricing Area -->

@include('templates/footer')
