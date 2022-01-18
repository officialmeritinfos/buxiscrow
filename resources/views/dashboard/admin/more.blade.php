@include('dashboard.admin.templates.header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{$pageName}}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}" class="d-flex">
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                        <path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/>
                        <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/>
                    </svg>
                    <span class="breadcrumb-icon"> Home</span></a>
            </li>
            <li class="breadcrumb-item active"><a href="#">{{$pageName}}</a></li>
        </ol>
    </div>
</div>
<!--End Page header-->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <a href="{{url('admin/faq_category')}}" class="btn btn-sm btn-outline-info" style="margin-bottom:5px;">FAQs Category</a>
                <a href="{{url('admin/faqs')}}" class="btn btn-sm btn-outline-primary" style="margin-bottom:5px;">FAQs</a>
                <a href="{{url('admin/currency')}}" class="btn btn-sm btn-outline-warning" style="margin-bottom:5px;">Accepted Currency</a>
                <a href="{{url('admin/business_type')}}" class="btn btn-sm btn-outline-secondary" style="margin-bottom:5px;">Business Type</a>
                <a href="{{url('admin/business_category')}}" class="btn btn-sm btn-outline-success" style="margin-bottom:5px;">Business Category</a>
                <a href="{{url('admin/business_subcategory')}}" class="btn btn-sm btn-orange" style="margin-bottom:5px;">Business Subcategory</a>
                <a href="{{url('admin/delivery_services')}}" class="btn btn-sm btn-yellow" style="margin-bottom:5px;">Delivery Services</a>
                <a href="{{url('admin/report_type')}}" class="btn btn-sm btn-teal" style="margin-bottom:5px;">Report Types</a>
                <a href="{{url('admin/general_settings')}}" class="btn btn-sm btn-dark" style="margin-bottom:5px;">General Settings</a>
            </div>
        </div>
    </div>
</div>

</div>
</div><!-- end app-content-->
</div>

@include('dashboard.admin.templates.footer')
