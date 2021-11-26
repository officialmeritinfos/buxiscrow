@include('dashboard.merchant.templates.header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{$pageName}}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('merchant/dashboard')}}" class="d-flex">
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
<!-- Row -->
<div class="row">
    <div class="col-12">
        <!--div-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{$pageName}}</div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="table-responsive">
                        @isset($beneficiaries)
                            <div class="text-center">
                                <button class="btn btn-outline-warning" data-toggle="modal"
                                        data-target="#add_new_beneficiary" data-backdrop="static" data-keyboard="false"
                                        style="margin-bottom: 5px;">
                                    <i class="fa fa-plus-square"></i> Add New Receipient
                                </button>
                            </div>
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Bank</th>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Account Number</th>
                                    <th class="border-bottom-0">Currency</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Date Added</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($beneficiaries as $bene)
                                    <tr>
                                        <td>{{$bene->bank}}</td>
                                        <td>{{$bene->accountName}}</td>
                                        <td>{{$bene->accountNumber}}</td>
                                        <td>{{$bene->currency}}</td>
                                        <td>
                                            @switch($bene->status)
                                                @case(1)
                                                <span class="badge badge-success">Active</span>
                                                @break
                                                @default
                                                <span class="badge badge-dark">Inactive</span>
                                            @endswitch
                                        </td>
                                        <td>{{$bene->created_at}}</td>
                                        <td>
                                            <button class="btn btn-outline-warning" data-toggle="modal"
                                                    data-target="#remove_Beneficiary" data-backdrop="static"
                                                    data-keyboard="false" data-id="{{$bene->beneficiaryId}}"
                                                    data-name="{{$bene->accountName}}">
                                                <i class="fa fa-times-circle"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

    </div>
</div>
<!-- /Row -->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.merchant.templates.beneficiary_modal')
@include('dashboard.merchant.templates.footer')
