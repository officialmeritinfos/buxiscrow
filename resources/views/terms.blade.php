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
        <div class="row ">
            <div class="col-lg-6 col-md-6">
                <div class="about-content text-justify">
                    <h2 class="about-content text-left">Terms and Condition</h2>
                    <p>
                        These Website Terms and Conditions (“Terms”) contained herein on this webpage, shall govern your
                        access to and use of this website, including all pages within this website (collectively referred to as this “Website”).
                        These Terms apply in full force and effect to your use of this Website and by using this Website,
                        you expressly accept all terms and conditions contained herein in full. You must not use this Website,
                        if you have any objection to any of these Terms.
                        PLEASE READ AND UNDERSTAND THE TERMS OF AGREEMENT CAREFULLY BEFORE BEING AGREED TO BE BOUND BY ITS TERMS.<br>
                    </p>
                    <h5 class="about-content text-center text-capitalize"> INTRODUCTION</h5>
                    <p>
                        We are an independent contractor for all purposes, providing this website and our services on
                        an independent service provider basis. We do not have control or assume the liability
                        for the products or services that are paid for with our service. We do not guarantee any user’s
                        identity and cannot ensure that a buyer or seller will complete a transaction, what we do is to
                        ensure that what you ordered for is exactly what you get.
                    </p>
                    <p>This  {{$web->siteName}} Payment Services Terms set out the agreement between us ( MERITINFOS LLC
                        (245 N Highland Ave NE STE 230 #877 Atlanta, GA 30307, US)
                        and MERITINFOS COMPANY LIMITED ( 22 Edozie Street, Uwani, Enugu, Enugu State) Registered Company Number
                        4572299 and RC - 1810921 respectively ) and you, the person who has completed the on-line application
                        process on our secure customer website ({{$web->siteName}}).
                        <br>
                    </p>
                    <p>
                        We will refer in these {{$web->siteName}} Payment Services Terms to us as {{$web->siteName}} or we or us;
                        and, we will refer to you, the user of the services as you.<br>
                    </p>
                    <p>
                        We are an Instant Digital Escrow Service provider.
                    </p>
                    <p>
                        You can request or download a copy of these terms at any time, which includes all the information
                        you are required to be provided with.
                    </p>
                    <p>
                        Any previous terms which were applicable to you are available on the legal section of our website at
                        <a href="{{url('/')}}">{{url('/')}}</a>
                    </p>
                    <h5 class="about-content text-center text-capitalize"> AGE RESTRICTION</h5>
                    <p>
                        Our website and services are not directed to children under 18. We do not knowingly transact or
                        provide any services to children under 18.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> CHARGEBACKS</h5>
                    <p>
                        If you believe that an unauthorized or otherwise problematic transaction has taken place, you
                        agree to notify us immediately, to enable us take action to help prevent financial loss; failure
                        to do so within 24 hours, {{$web->siteName}} will be at liberty of granting this chargeback request,
                        except when the debited amount was processed by our card processors.<br>

                    </p>
                    <h5 class="about-content text-center text-capitalize"> ACCEPTABLE USE POLICY</h5>
                    <p>
                        You are independently responsible for complying with all applicable laws related to your use of
                        our website and services. However, by accessing or using {{$web->sietName}}, you agree to
                        comply with the terms and conditions of our Acceptable Use Policy which you can read on our Acceptable
                        Use Policy section.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> PRIVACY POLICY</h5>
                    <p>
                        {{$web->sietName}}, is committed to managing your Personal Information in line with global industry
                        best practices. You can read our Privacy Policy to understand how we use your information and the
                        steps we take to protect your information.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> USING YOUR ACCOUNT</h5>
                    <p>
                        Your account is for your personal use only, unless we have set you up as a Business customer.
                        You may use it solely for the purpose of making payment transactions to payment recipients.<br>
                        Your account cannot be used in any way to store funds that do not relate to a specific payment
                        transactions you have asked us to make. As all funds that are in your account relate to pending
                        payment transactions, your account is not accessible to you and you cannot ask us to deal with
                        the funds other than by amending or cancelling your payment order for that payment transaction.<br>
                        Your login details enable you to place payment orders (as set out below) with us and see a record
                        of your payment orders and payment transaction, as well as see the status of those orders and
                        transactions. It does not give you access to your account or enable you to control funds within
                        your account. Your account cannot, therefore, be accessed or operated by a third party.<br>
                        You must not use your account for any illegal purpose. This means that you cannot use our
                        services or your account for anything that might violate any laws or regulations. Where you do
                        so we may then decline, cancel or revoke any or all transactions progressing and report such
                        information we hold to law enforcement agencies as detailed in our privacy notice. For information
                        on activities or transactions that are considered for illegal purpose, you may make a direct
                        request from us at <a href="{{route('contact')}}">{{route('contact')}}</a> <br>
                        Funds in your account will be held in accordance with the Escrow section of these
                        {{$web->siteName}} Payment Services Terms. Interest is not paid on funds paid into your account.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> SETTING UP A PAYMENT TRANSACTION</h5>
                    <P>
                        Payment transactions you may make are split into two separate elements:<br>
                    <ul>
                        <li>
                            There is a payment that you will normally arrange with your bank or credit card provider to pay us
                            the amount of the funds you want to pay to a payment recipient in respect of the payment transaction,
                            which will be held by us in your account;
                        </li>
                        <li>
                            There is an instruction you give to us for us to make a payment transaction to a payment recipient.
                            This is the payment order.
                        </li>
                    </ul>
                    The payment order is submitted to us by logging on to the {{$web->siteName}} platform and creating,
                    authorising and authenticating an instruction form using our online platform or mobile application.
                    In order for there to be a valid payment order:
                    <ul>
                        <li>
                            You must provide us with details of the payment recipient comprising their full name, email address
                            and/or mobile phone number as a minimum (it has to be sufficient information to enable us to match
                            their details with the relevant {{$web->siteName}} user or provide the details we need to
                            contact the person you wish to pay);
                        </li>
                        <li>
                            Service Level Agreements on the {{$web->siteName}} includes but not limited to the following:
                        </li>
                        <ol>
                            <li>
                                You will specify the amount of the payment transaction to be made to the payment recipient;
                            </li>
                            <li>
                                You will provide a brief description of the nature and reference for the payment transaction;
                            </li>
                            <li>
                                You will specify the inspection period for the transaction;
                            </li>
                            <li>
                                You will specify the deadline period for the transaction;
                            </li>
                        </ol>
                        <li>
                            When the terms of the transaction have been met - signified by both parties approving (the merchant
                            approving first the delivery of service/product, then the buyer/client approving the authenticity
                            of service/product), the held funds will be released into the merchant's account (pending or available
                            depending on the account limit of the merchant)
                        </li>
                    </ul>

                    Once you submit a transaction we will validate the details and, if the payment recipient is not a
                    {{$web->siteName}} user, we will take steps to on-board them to the {{$web->siteName}} platform.
                    Once those steps are complete, we will confirm that you should fund your account for an amount
                    equal to the amount of the proposed payment transaction.<br>
                    To transfer funds to your account, you should use one of the accepted funding mechanisms specified
                    including: credit or debit card payment, the Pay-By-Bank-App and/or such other funding mechanisms we may make available.
                    It is important that you provide funds exactly equal to the proposed payment transaction
                    (including escrow service charges) – no more, no less. You will not have completed a valid payment
                    order until we have credited the funds corresponding to that payment transaction to your account.
                    Funds received by us will be credited to your account the following day (this is to help us check for any chargebacks,
                    afterwards, we credit you.<br>
                    A payment transaction must be paid to your {{$web->siteName}} account in a single payment to a
                    payment recipient and we will not accept any funding for a payment transaction split into staged or part
                    funding .i.e for a split or milestone transaction, you are expected to make the full payment for the
                    transaction and not pay into {{$web->siteName}} by installments. If we receive funds less or more than
                    the amount of the intended payment transaction to the other {{$web->siteName}} user then
                    we will not make any part or over-payment and will return the entire funded amount to you as soon
                    as possible.<br>
                    If the payment recipient is not registered with {{$web->siteName}} and you have funded your
                    account in respect of the payment transaction and the payment recipient does not register with
                    us within seven business days from our request to register, we will cancel the payment order and
                    return the amount you have funded to you.
                    If a specific date for the payment transaction is not specified and the payment transaction is
                    conditional, you will also specify a long-stop date not exceeding three calendar months by which
                    the payment transaction will be made.<br>
                    If a merchant fails to approve the delivery of the product/service for which a payment has been made after
                    the due date,
                    we will cancel the transaction, and refund the payment to the payer.<br>
                    If the payer fails to approve/report a transaction for which the merchant has approved delivery for
                    after the inspection period, we will approve the transaction and credit the merchant the same.
                    <br> Such refunds as stated above are non-reversal.
                    </P>
                    <h5 class="about-content text-center text-capitalize"> HOW TRANSACTIONS ARE COMPLETED</h5>
                    <p>
                        Once we have received a valid payment order, we will hold the funds relating to that payment order
                        in your account until the time you have asked us to complete the payment transaction, which might
                        be on the date the specific conditions that you have specified are satisfied, on a specified future date,
                        or when a buyer fails to approve/report a transaction before the inspection date expires.
                        At the funds release time, we will complete the payment transaction by making a payment to the
                        nominated account of the payment recipient. We make the payment by the faster payments service or
                        other method elected by are you.
                        Please allow for a minimum of 24 hours from when the transaction was funded, before funds are
                        released to the Seller or Service Provider.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> DISPUTE RESOLUTION</h5>
                    <p>
                        We always advise that both the seller or service provider and the buyer or client reconcile on the
                        dispute among themselves first before proceeding to contact us. <br>
                        However, this is not always the case with seller/service providers and their buyer/client; in which
                        case, {{$web->siteName}} will provide arbitration service. <br>
                        For physical products, and when one of our delivery partners are used for shipment (<span class="text-success">
                            highly recommended</span>), we will first reach out to them
                        to confirm the status of the delivery given to them. If none of our logistics partner was used (<span class="text-danger">
                            not recommended</span>), we will reach out to the logistics company used to get the status of the delivery.
                        Whatever information we get from them, we will use in our arbitration process. <br>However, if none
                        of our logistics partner was used, our help may be limited to the information they gve to us, unless
                        the case is not about delivery time.<br>
                        For Digital products, or services(not products), we will reach out for the description while creating the
                        transaction and check if the service delivered corresponds to the rendered/delivered service/digital product.<br>
                        We may engage the service of a professional to help rectify the problem, and whoever loses the case pays for the
                        extra fee of contacting/hiring the professional.<br>
                        In severe situations, we will take this to a neutral third-party. Such neutral third parties include alternate
                        dispute resolution officials icluding our own Legal Team, licensed by a professional body in Nigeria such as LCA
                        and the Institute of Chartered Mediators.
                        The fees payable to mediators would depend on several factors, including the complexity and technicality of the
                        dispute, the time involved in settling the dispute as well as the number of mediators with the
                        level of experience to handle the dispute in relation to that subject matter within the relevant jurisdiction.
                        Mediator’s fees will be borne by the transacting parties and are negotiated between the parties and mediator at
                        their discretion. Once an agreement has been reached by the parties, the Terms of Settlement are reduced into
                        writing and this constitutes a binding and enforceable contract. Once this is achieved, the transaction funds
                        are released according to this decision, after which the transaction is closed.<br>
                        While the transaction is in the “In Dispute” state, the transaction funds will remain securely held in
                        the transactional escrow account.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> PAYMENT REFUNDS</h5>
                    <p>
                        In the event of a cancelled transaction or a partial refund to the Paying Party, the Paying Party’s
                        funds will be refunded back to the source of the payment method used to fund the transaction.
                        The transaction fee for now will is refunded alongside. This may not be the case at all time, and
                        it is at our sole-discretion to decide when to refund the transaction fee.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> LIABILITY LIMITATION</h5>
                    <p>
                        If anything goes wrong in a payment that we are involved in, but this is due to abnormal or
                        unforeseeable events outside of our control, which would have been unavoidable even if we had
                        taken all steps to prevent them, we will not be responsible to you for any losses and costs
                        caused. Also, if we are unable to meet our obligations to you or perform our services due to
                        legal or regulatory obligations or changes that apply to us, we will not be responsible to you
                        for any losses or costs incurred.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> BREACH OF TERMS</h5>
                    <p>
                        Without prejudice to {{$web->siteName}}’s other rights under these Terms, if you breach these
                        Terms in any way, {{$web->siteName}} may take such action as {{$web->siteName}} deems appropriate
                        to deal with the breach, including suspending your access to the website, prohibiting you from
                        accessing the website, blocking computers using your IP address from accessing the website,
                        contacting your internet service provider to request that they block your access to the website
                        and/or bringing court proceedings against you.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> Money Transfer</h5>
                    <p>
                       You agree to not use {{$web->siteName}} as a mobile money transfer system. It is worth noting that
                        {{$web->siteName}} was never built as a banking system and should not be used as such.
                        Rather, {{$web->siteName}} is a business management solution that helps you transact safely and securely
                        over the Internet. You accept to idemify {{$web->siteName}} of any liability that may arise from using
                        it as a mobile money system.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> Non-escrow Transfers</h5>
                    <p>
                        {{$web->siteName}} allows you send money to your favourite merchant, either for goods/services rendered.
                        However, such type of transaction is not held in escrow and released to the merchant instantly depending
                        on their account limit. {{$web->siteName}} nor her team shall be held responsible if the product/service
                        does not meet your expectation. Only use this means to send money to Merchants you trust.<br>
                        By signing up on {{$web->siteName}}, you agree to pay if any, the charges included in this transfer
                        and to idemify {{$web->siteName}} should any damage arise.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> Governing Rules</h5>
                    <p>
                        These Terms shall be interpreted and governed in accordance with the
                        Laws of the State of Delaware, and the Federal Republic of Nigeria and you submit to the non-exclusive
                        jurisdiction of the State and
                        Federal Courts located in Delaware, and Nigeria for the resolution of any dispute.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="about-content text-justify">
                    <h2 class="about-content text-left">Acceptable Use Policy</h2>
                    <p>
                        By accessing or using {{$web->siteName}}, you agree to comply with the terms and conditions of
                        this Acceptable Use Policy.
                    </p>
                    <h5 class="about-content text-center text-capitalize"> RESTRICTED ACTIVITIES</h5>
                    <p>
                        You may not use {{$web->siteName}} in connection with any product, service, transaction or activity that:
                    <ul>
                        <li> violates any law or government regulation, or promotes or facilitates such by third parties;</li>
                        <li>violates any rule or regulation of Visa, MasterCard, Verve or any other electronic funds transfer network (each, a “Card Network”);
                            is fraudulent, deceptive, unfair or predatory;</li>
                        <li>causes or threatens reputational damage to us or any Card Network;</li>
                        <li>involves any of the business categories listed in clause 2; or
                            results in or creates a significant risk of chargebacks, penalties, damages or other harm or liability.</li>
                    </ul>
                    </p>
                    <h5 class="about-content text-center text-capitalize"> BUSINESS CATEGORIES</h5>
                    <p>
                        You may not use {{$web->siteName}} in connection with any product, service, transaction or activity that:
                    <ul>
                        <li>falls within the Prohibition List of the Nigerian Customs Administration of the Federal Republic of Nigeria</li>
                        <li>relates to the sale and/or purchase of:
                            <ol><li>banned narcotics, steroids, certain controlled substances or other products that present a risk a consumer's safety;</li>
                                <li>blood, bodily fluids or body parts;</li>
                                <li>burglary tools;</li>
                                <li>counterfeit items;</li>
                                <li>illegal drugs and drug paraphernalia;</li>
                                <li>fireworks, destructive devices and explosives;</li>
                                <li>identity documents, government documents, personal
                                    financial records or personal information (in any form, including
                                    mailing lists);</li>
                                <li>lottery tickets, sweepstakes entries or slot machines without the required license;</li>
                                <li>offensive material or hate speech or items that promote
                                    hate, violence, racial intolerance, or the financial exploitation of a
                                    crime;</li>
                                <li>chemicals;</li>
                                <li>recalled items;</li>
                                <li>prohibited services;</li>
                                <li>unlicensed financial services, stocks or other securities;</li>
                                <li>stolen property;</li>
                                <li>items that infringe or violate any copyright, trademark,
                                    right of publicity or privacy or any other proprietary right under the
                                    laws of any jurisdiction;</li>
                                <li>sales of currency without BDC license, cryptocurrency operators;</li>
                                <li>obscene material or pornography;</li>
                                <li>certain sexually oriented materials or services; </li>
                                <li>certain firearms, firearm parts or accessories, ammunition, weapons or knives;</li>
                                <li>any product or service that is illegal or marketed or sold in such a way as to create liability to {{$web->siteName}}; or</li><li>production of military and paramilitary wears and accoutrement, including those of the Police and the Customs, Immigration and Prison Services.</li>
                            </ol></li>
                        <li>relate to transactions that:
                            <ol><li>show the personal information of third parties in violation of applicable law;</li>
                                <li>support pyramid or ponzi schemes, matrix programs, other "get rich quick" schemes or certain multi-level marketing programs;</li>
                                <li>are associated with purchases of annuities or lottery
                                    contracts, lay-away systems, off-shore banking or transactions to
                                    finance or refinance debts funded by a credit card;</li>
                                <li>pertain to ammunitions and arms; and</li>
                                <li>involve gambling, gaming and/or any other activity with an
                                    entry fee and a prize, including, but not limited to casino games,
                                    sports betting, horse or greyhound racing, lottery tickets, other
                                    ventures that facilitate gambling, games of skill (whether or not it is
                                    legally defined as a lottery) and sweepstakes unless the operator has
                                    obtained prior approval from {{$web->siteName}} and the operator and customers are
                                    located exclusively in jurisdictions where such activities are
                                    permitted by law. </li>
                            </ol></li>
                    </ul>
                    </p>
                    <h5 class="about-content text-center text-capitalize"> ACTIONS BY {{$web->siteName}}</h5>
                    <p>
                        If, in our sole discretion, we believe that you may have
                        engaged in any violation of this Acceptable Use Policy, we may (with or
                        without notice to you) take such actions as we deem appropriate to
                        mitigate risk to {{$web->siteName}} and any impacted third parties and to ensure
                        compliance with this Acceptable Use Policy. Such actions may include,
                        without limitation:
                    </p>
                    <ul><li>Blocking the settlement or completion of one or more payments;</li>
                        <li>Suspending, restricting or terminating your access to and use of the {{$web->siteName}}’s Services;</li>
                        <li>Terminating our business relationship with you, including
                            termination without liability to {{$web->siteName}} of any payment service
                            agreement between you and {{$web->siteName}};</li>
                        <li>Taking legal action against you;</li>
                        <li>Contacting and disclosing information related to such
                            violations to (i) persons who have sold/purchased goods or services from
                            you, (ii) any banks or Card Networks involved with your business or
                            transactions, (iii) law enforcement or regulatory agencies, and (iv)
                            other third parties that may have been impacted by such violations; or</li>
                        <li>Assessing against you any fees, penalties, assessments or
                            expenses (including reasonable attorneys’ fees) that we may incur as a
                            result of such violations, which you agree to pay promptly upon notice.</li>
                    </ul>
                    <h2 class="about-content text-left">Terms and Condition</h2>
                    h3>Account Security</h5>
                    <p>You agree not to allow anyone else to have or use your
                        password details and to comply with all reasonable instructions we may
                        issue regarding account access and security. In the event you share your
                        password details, {{$web->siteName}} will not be liable to you for losses or
                        damages. You will also take all reasonable steps to protect the security
                        of the personal electronic device through which you access {{$web->siteName}}’s
                        services (including, without limitation, using PIN and/or password
                        protected personally configured device functionality to access
                        {{$web->siteName}}’s services and not sharing your device with other people).</p>
                    <h5 class="about-content text-center text-capitalize"> Data Compliance</h5>
                    <p>You agree to comply with all data privacy and security
                        requirements of the Payment Card Industry Data Security Standard (PCI
                        DSS Requirements”) and under any applicable law or regulation that may
                        be in force, enacted or adopted regarding confidentiality, your access,
                        use, storage and disclosure of user information. Information on the PCI
                        DSS can be found on the PCI Council’s website. It is your
                        responsibility to comply with these standards.</p>
                    <p>We are responsible for the security and protection of Card
                        Holder Data (CHD) we collect and store. Accordingly, we implement access
                        control measures, security protocols and standards including the use of
                        encryption and firewall technologies to ensure that CHD is kept safe
                        and secure on our servers, in compliance with the PCI DSS Requirement.
                        We also implement periodical security updates to ensure that our
                        security infrastructures are in compliance with reasonable industry
                        standards.</p>
                    <p>We acknowledge that you own all your customers’ data. You
                        hereby grant {{$web->siteName}} a perpetual, irrevocable, sub-licensable,
                        assignable, worldwide, royalty-free license to use, reproduce,
                        electronically distribute, and display your customers’ data for the
                        following purposes: </p>
                    <ol><li>providing and improving our services;</li>
                        <li>internal usage, including but not limited to, data analytics
                            and metrics so long as individual customer data has been anonymized and
                            aggregated with other customer data; </li>
                        <li>complying with applicable legal requirements and assisting
                            law enforcement agencies by responding to requests for the disclosure of
                            information in accordance with local laws; and </li>
                        <li>any other purpose for which consent has been provided by your customer.</li>
                    </ol> <h5 class="about-content text-center text-capitalize"> Software License</h5>
                    <p>We hereby grant you a revocable, non-exclusive,
                        non-transferable license to use {{$web->siteName}}’s APIs, developer’s toolkit,
                        and other software applications (the “Software”) in accordance with the
                        documentation accompanying the Software. This license grant includes all
                        updates, upgrades, new versions and replacement software for your use
                        in connection with the {{$web->siteName}}’s services. If you do not comply with
                        the documentation and any other requirements provided by {{$web->siteName}}, then
                        you will be liable for all resulting damages suffered by you, {{$web->siteName}}
                        and third parties. Unless otherwise provided by applicable law, you
                        agree not to alter, reproduce, adapt, distribute, display, publish,
                        reverse engineer, translate, disassemble, decompile or otherwise attempt
                        to create any source code that is derived from the Software. Upon
                        expiration or termination of this Agreement, you will immediately cease
                        all use of any Software.</p>
                    <h5 class="about-content text-center text-capitalize"> Trademark License</h5>
                    <p>We hereby grant you a revocable, non-exclusive,
                        non-transferable license to use {{$web->siteName}}’s trademarks used to identify
                        our services (the “Trademarks”) solely in conjunction with the use of
                        our services. You agree that you will not at any time during or after
                        this Agreement assert or claim any interest in or do anything that may
                        adversely affect the validity of any Trademark or any other trademark,
                        trade name or product designation belonging to or licensed to {{$web->siteName}}
                        (including, without limitation registering or attempting to register any
                        Trademark or any such other trademark, trade name or product
                        designation). Upon expiration or termination of this Agreement, you will
                        immediately cease all display, advertising and use of all of the
                        Trademarks.</p>
                    <h5 class="about-content text-center text-capitalize"> Intellectual Property</h5>
                    <p>We do not grant any right or license to any {{$web->siteName}}
                        intellectual property rights by implication, estoppel or otherwise other
                        than those expressly mentioned in this Agreement.</p>
                    <p>Each party shall retain all intellectual property rights
                        including all ownership rights, title, and interest in and to its own
                        products and services, subject only to the rights and licenses
                        specifically granted herein.</p>
                    <h5 class="about-content text-center text-capitalize"> Publicity</h5>
                    <p>You hereby grant {{$web->siteName}} permissions to use your name and
                        logo in our marketing materials including, but not limited to use on our
                        website, in customer listings, in interviews and in press releases.
                        Such Publicity does not imply an endorsement for your products and
                        services. </p>
                    <h5 class="about-content text-center text-capitalize"> Confidential Information</h5>
                    <p>The parties acknowledge that in the performance of their
                        duties under this Agreement, either party may communicate to the other
                        (or its designees) certain confidential and proprietary information,
                        including without limitation information concerning each party’s
                        services, know how, technology, techniques, or business or marketing
                        plans (collectively, the “Confidential Information”) all of which are
                        confidential and proprietary to, and trade secrets of, the disclosing
                        party. Confidential Information does not include information that: (i)
                        is public knowledge at the time of disclosure by the disclosing party;
                        (ii) becomes public knowledge or known to the receiving party after
                        disclosure by the disclosing party other than by breach of the receiving
                        party’s obligations under this section or by breach of a third party’s
                        confidentiality obligations; (iii) was known by the receiving party
                        prior to disclosure by the disclosing party other than by breach of a
                        third party’s confidentiality obligations; or (iv) is independently
                        developed by the receiving party.</p>
                    <p>As a condition to the receipt of the Confidential Information
                        from the disclosing party, the receiving party shall: (i) not disclose
                        in any manner, directly or indirectly, to any third party any portion of
                        the disclosing party’s Confidential Information; (ii) not use the
                        disclosing party’s Confidential Information in any fashion except to
                        perform its duties under this Agreement or with the disclosing party’s
                        express prior written consent; (iii) disclose the disclosing party’s
                        Confidential Information, in whole or in part, only to employees and
                        agents who need to have access thereto for the receiving party’s
                        internal business purposes; (iv) take all necessary steps to ensure that
                        its employees and agents are informed of and comply with the
                        confidentiality restrictions contained in this Agreement; and (v) take
                        all necessary precautions to protect the confidentiality of the
                        Confidential Information received hereunder and exercise at least the
                        same degree of care in safeguarding the Confidential Information as it
                        would with its own confidential information, and in no event shall apply
                        less than a reasonable standard of care to prevent disclosure.</p>
                    <h5 class="about-content text-center text-capitalize"> Know Your Customer</h5>
                    <p>You agree that, you are solely responsible for verifying the
                        identities of your customers, ensuring that they are authorised to carry
                        out the transactions on your platform, and determining their
                        eligibility to purchase your products and services. </p>
                    <p>You are also required to maintain information and proof of
                        service or product delivery to your customer. Where a dispute occurs
                        needing resolution, you may be required to provide {{$web->siteName}} with these. </p>
                    <h5 class="about-content text-center text-capitalize"> Card Network Rules</h5>
                    <p>Each card network has its own rules, regulations and
                        guidelines. You are required to comply with all applicable Network Rules
                        that are applicable to merchants. You can review portions of the
                        Network Rules at Mastercard, Visa, Verve and other payment cards. The
                        Card Networks reserve the right to amend the Network Rules.</p>
                    <h5 class="about-content text-center text-capitalize"> Customer Payments</h5>
                    <p>You may only process payments when authorised to do so by your
                        customer. We will only process transactions that have been authorised
                        by the applicable Card Network or card issuer.</p>
                    <p>We do not guarantee or assume any liability for transactions
                        authorised and completed that are later reversed or charged back (see
                        Chargebacks below). You are solely responsible for all reversed or
                        charged back transactions, regardless of the reason for, or timing of,
                        the reversal or chargeback. {{$web->siteName}} may add or remove one or more
                        payment types or networks at any time. If we do so we will use
                        reasonable efforts to give you prior notice of the removal.</p>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="about-content text-justify">
                    <h5 class="about-content text-center text-capitalize"> Our Fees &amp; Pricing Schedule</h5>
                    <p>You agree to pay us for the services we render as a payment
                        gateway for your goods and services. Our Fees will be calculated as
                        demonstrated on the Pricing page on the website and can be calculated on
                        the same page using the “little calculator” we provided. The Fees on
                        our Pricing page is integral to and forms part of this Agreement. </p>
                    <p>We reserve the right to revise our Fees. In the event that we revise our fees we will notify you within 5 days of such change. </p>
                    <h5 class="about-content text-center text-capitalize"> Security and Fraud Controls</h5>
                    <p>{{$web->siteName}} is responsible for protecting the security of Payment
                        Data including CHD in our possession and will maintain commercially
                        reasonable administrative, technical, and physical procedures to protect
                        all the personal information regarding you and your customers that is
                        stored in our servers from unauthorised access and accidental loss or
                        modification. Although, we cannot guarantee that unauthorised third
                        parties will never be able to defeat those measures or use such personal
                        information for improper purposes. We will however take all reasonable
                        and commercially achievable measures to address any security breach as
                        soon as we become aware.</p>
                    <p>You agree to use other procedures and controls provided by us
                        and other measures that are appropriate for your business to reduce the
                        risk of fraud. </p>
                    <p>In the event that you suspect any fraudulent activity by a
                        customer, you agree to notify {{$web->siteName}} immediately and quit the delivery
                        of the service. In addition, where we suspect that there have been
                        frequent fraudulent transactions on your account, we reserve the right
                        to cancel our service to you and/or your account</p>
                    <h5 class="about-content text-center text-capitalize"> Notification of Errors</h5>
                    <p>You agree to notify us immediately any error is detected while
                        reconciling transactions that have occurred using {{$web->siteName}}. We will
                        investigate and rectify the errors where verified. In the event that we
                        notice any errors, we will also investigate and rectify such errors. </p>
                    <p>Where we owe you money as a result of such errors, we will
                        refund the amounts owed to you by a bank transfer to your Bank Account. </p>
                    <p>If a transaction is erroneously processed through your
                        platform, report to us immediately. We will investigate any such reports
                        and attempt to rectify the errors by crediting or debiting your Bank
                        Account as appropriate. </p>
                    <p>Failure to notify us within 45 (forty-five) days of the
                        occurrence of an error will be deemed a waiver of your rights to amounts
                        that are owed to you due to an error.</p>
                    <h5 class="about-content text-center text-capitalize"> Chargebacks</h5>
                    <p>A Chargeback usually happens when a customer files directly
                        with or disputes through his or her credit or debit card issuer a
                        payment on their bill. It may result in the reversal of a transaction.
                        You may be assessed Chargebacks for (i) customer disputes; (ii)
                        unauthorised or improperly authorised transactions; (iii) transactions
                        that do not comply with Card Network Rules or the terms of this
                        Agreement or are allegedly unlawful or suspicious; or (iv) any reversals
                        for any reason by the Card Network, our processor, or the acquiring or
                        issuing banks. Where a Chargeback occurs, you are immediately liable for
                        all claims, expenses, fines and liability we incur arising out of that
                        Chargeback and agree that we may recover these amounts by debiting your
                        Bank Account. Where these amounts are not recoverable through your Bank
                        Account, you agree to pay all such amounts through any other means</p>
                    <h5 class="about-content text-center text-capitalize"> Reserves</h5>
                    <p>In our sole discretion, we may place a Reserve on a portion of
                        your Payouts by holding for a certain period such portion where we
                        believe there is a high level of risk associated with your business. If
                        we take such steps, we will provide you with the terms of the Reserve
                        which may include the percentage of your Payouts to be held back, period
                        of time and any other such restrictions that {{$web->siteName}} may deem
                        necessary. Where such terms are changed, we will notify you. You agree
                        that you will remain liable for all obligations related to your
                        transactions even after the release of any Reserve. In addition, we may
                        require you to keep your Bank Account available for any open
                        settlements, Chargebacks and other adjustments.</p>
                    <p>To secure your performance of this Agreement, you grant
                        {{$web->siteName}} a legal claim to the funds held in the Reserve as a lien or
                        security interest for amounts payable by you.</p>
                    <h5 class="about-content text-center text-capitalize"> Refunds</h5>
                    <p>You agree that you are solely responsible for accepting and
                        processing returns of your products and services. We are under no
                        obligation to process returns of your products and services, or to
                        respond to your customers’ inquiries about returns of your products and
                        services. You agree to submit all Refunds for returns of your products
                        and services that were paid for through {{$web->siteName}} to your customers in
                        accordance with this Agreement and relevant Card Network Rules. </p>
                    <h5 class="about-content text-center text-capitalize"> Termination</h5>
                    <p>You may terminate this Agreement by closing your {{$web->siteName}} Account.</p>
                    <p>We may suspend your {{$web->siteName}} Account and your access to {{$web->siteName}} services and any funds, or terminate this Agreement, if;</p>
                    <ol><li>you do not comply with any of the provisions of this Agreement;</li>
                        <li>we are required to do so by a Law;</li>
                        <li>we are directed by a Card Network or issuing financial institution; or</li>
                        <li>where a suspicious or fraudulent transaction occurs</li>
                    </ol> <h5 class="about-content text-center text-capitalize"> Restricted Activities &amp; Acceptable Use Policy</h5>
                    <p>You are independently responsible for complying with all
                        applicable laws related to your use of our website and services.
                        However, by accessing or using {{$web->siteName}}, you agree to comply with the
                        terms and conditions of our Acceptable Use Policy and are restricted
                        from the activities specified in it which you can read on our Acceptable
                        Use Policy page. </p>
                    <h5 class="about-content text-center text-capitalize"> Disclaimers</h5>
                    <p>WE TRY TO KEEP {{$web->siteName}} AVAILABLE AT ALL TIMES, BUG-FREE AND SAFE, HOWEVER, YOU USE IT AT YOUR OWN RISK.</p>
                    <p>OUR WEBSITE AND SERVICES ARE PROVIDED “AS IS” WITHOUT ANY
                        EXPRESS, IMPLIED AND/OR STATUTORY WARRANTIES (INCLUDING, BUT NOT LIMITED
                        TO, ANY IMPLIED OR STATUTORY WARRANTIES OF MERCHANTABILITY, FITNESS FOR
                        A PARTICULAR USE OR PURPOSE, TITLE, AND NON-INFRINGEMENT OF
                        INTELLECTUAL PROPERTY RIGHTS). WITHOUT LIMITING THE GENERALITY OF THE
                        FOREGOING, {{$web->siteName}} MAKES NO WARRANTY THAT OUR WEBSITE AND SERVICES WILL
                        MEET YOUR REQUIREMENTS OR THAT OUR WEBSITE WILL BE UNINTERRUPTED,
                        TIMELY, SECURE, OR ERROR FREE. NO ADVICE OR INFORMATION, WHETHER ORAL OR
                        WRITTEN, OBTAINED BY YOU THROUGH OUR WEBSITE OR FROM {{$web->siteName}}, ITS
                        PARENTS, SUBSIDIARIES, OR OTHER AFFILIATED COMPANIES, OR ITS OR THEIR
                        SUPPLIERS (OR THE RESPECTIVE OFFICERS, DIRECTORS, EMPLOYEES, OR AGENTS
                        OF ANY SUCH ENTITIES) (COLLECTIVELY, "{{$web->siteName}} PARTIES") SHALL CREATE
                        ANY WARRANTY. </p>
                    <h5 class="about-content text-center text-capitalize"> Limitation of Liability</h5>
                    <p>IN NO EVENT WILL ANY OF THE {{$web->siteName}} PARTIES BE LIABLE FOR
                        (A) ANY INDIRECT, SPECIAL, CONSEQUENTIAL, PUNITIVE, OR EXEMPLARY DAMAGES
                        OR (B) ANY DAMAGES WHATSOEVER IN EXCESS OF THE AMOUNT OF THE
                        TRANSACTION OR TWENTY THOUSAND UNITED STATES DOLLARS (US$20,000.00)
                        DOLLARS, WHICHEVER IS LESSER (INCLUDING, WITHOUT LIMITATION, THOSE
                        RESULTING FROM LOSS OF REVENUES, LOST PROFITS, LOSS OF GOODWILL, LOSS OF
                        USE, BUSINESS INTERRUPTION, OR OTHER INTANGIBLE LOSSES), ARISING OUT OF
                        OR IN CONNECTION WITH {{$web->siteName}}’S WEBSITE OR SERVICES (INCLUDING,
                        WITHOUT LIMITATION, USE, INABILITY TO USE, OR THE RESULTS OF USE OF
                        {{$web->siteName}}’S WEBSITES OR SERVICES), WHETHER SUCH DAMAGES ARE BASED ON
                        WARRANTY, CONTRACT, TORT, STATUTE, OR ANY OTHER LEGAL THEORY.</p>
                    <h5 class="about-content text-center text-capitalize"> Exclusions</h5>
                    <p>Some jurisdictions do not allow the exclusion of certain
                        warranties or the limitation or exclusion of liability for certain
                        damages. Accordingly, some of the above disclaimers and limitations of
                        liability may not apply to you. To the extent that any {{$web->siteName}} Party
                        may not, as a matter of applicable law, disclaim any implied warranty or
                        limit its liabilities, the scope and duration of such warranty and the
                        extent of the {{$web->siteName}}’s Party's liability shall be the minimum
                        permitted under such applicable law.</p>
                    <h5 class="about-content text-center text-capitalize"> Indemnity</h5>
                    <p>You agree to defend, indemnify, and hold {{$web->siteName}}, its
                        officers, directors, employees, agents, licensors, and suppliers,
                        harmless from and against any claims, actions or demands, liabilities
                        and settlements including without limitation, reasonable legal and
                        accounting fees, resulting from, or alleged to result from, your
                        violation of these Agreement.</p>

                    <h5 class="about-content text-center text-capitalize"> Severability</h5>
                    <p>If any portion of these Terms of Use is held by any court or
                        tribunal to be invalid or unenforceable, either in whole or in part,
                        then that part shall be severed from these Terms of Use and shall not
                        affect the validity or enforceability of any other part in this Terms of
                        Use. </p>
                    <h5 class="about-content text-center text-capitalize"> Miscellaneous</h5>
                    <p>You agree that all agreements, notices, disclosures and other
                        communications that we provide to you electronically satisfy any legal
                        requirement that such communications be in writing. Assigning or
                        sub-contracting any of your rights or obligations under these Terms of
                        Use to any third party is prohibited. We reserve the right to transfer,
                        assign or sub-contract the benefit of the whole or part of any rights or
                        obligations under these Terms of Use to any third party.</p>
                    <h5 class="about-content text-center text-capitalize"> Updates, Modifications &amp; Amendments</h5>
                    <p>We may need to update, modify or amend our Acceptable Use
                        Policy at any time. We reserve the right to make changes to this
                        Acceptable Use Policy. </p>
                    <p>We advise that you check this page often, referring to the date of the last modification on the page.</p>

                    <p>Effective Date: <span>Tuesday, Dec 14, 2021</span></p>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End About Area -->

@include('templates/footer')
