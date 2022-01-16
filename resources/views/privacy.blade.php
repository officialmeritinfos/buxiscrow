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

<!-- Start About Area -->
<section class="about-area ptb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12">
                <div class="about-content text-justify">
                    <h2 class="about-content text-left">A growth engine for modern businesses in Africa</h2>
                    <p>
                        According to the <b>Nigeria Bureau of Statistics</b>  small and medium scale enterprises <b>(SMEs)</b> in
                        Nigeria have contributed about <b>48%</b> of the national GDP,account for <b>96%</b> of businesses and
                        <b>84%</b> of employment in the last five years. While in South Africa, <b>SMEs</b> account for
                        <b>91%</b> of businesses, <b>60%</b> of employment and contribute <b>52%</b> of total GDP.
                        <br> Despite this high number, a lot of losses and fraud take place especially during online transactions
                        which inlcude clients/customers being unwilling to pay for goods/services that was delivered/rendered to them;
                        merchants not delivering the supposed product purchased, even freelancers not executing the services which they were
                        paid for.<br>
                    </p>

                    <p>{{$web->siteName}}, a payments solutions platform built on
                        escrow technology, help Africa’s businesses grow - from new startups, to market leaders
                        in the commerce industry and beyond.
                    </p>
                    <p>
                        We take pride in interfacing between buyers and sellers, ensuring safety and increasing trust,
                        thereby contributing to commerce growth in Africa.
                        We make transactions safe and flexible, offering several options and tools for businesses to
                        boost customer acquisition and maintain customer retainership.
                    </p>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="about-content">
                    <br>
                    <p>
                        As business owners, and as Africans ourselves, we are driven by the passion and vision of
                        businesses across Africa, and we want to contribute to the growth of online businesses across
                        the continent.
                    </p>
                    <p>
                        Not just that, {{$web->siteName}} is building the perfect and nextGen marketplace that is all inclusive,
                        ensuring a safer transaction as well as eliminating the scenario of <b>What I ordered for </b> vs
                        <b>What I Got.</b>
                    </p>
                    <p>
                        {{$web->siteName}} empowers over thousands of sellers and buyers transact safely, even making accessible
                        the awesome features of both a marketplace and payment solution available to merchants and sellers of all
                        type of commodity.
                    </p>
                    <p>
                        As our <b>CEO</b> will always say, <q>Na merchants wey sabi dey sell with {{$web->siteName}}; and na customer/client
                            wey sabi dey buy with {{$web->siteName}}.</q> We are all inclusive and expanding gradually to other
                        countries within the continent. <br> Our firm belief is that with a healthy and wholesome payment system
                        that respects both the buyers and sellers privacy while maintaining a total credibility in transaction,
                        the <b>commerce</b> sector of the Africa Economy will continue to flourish.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Area -->

@include('templates/footer')
