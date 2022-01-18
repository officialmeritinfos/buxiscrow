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
                <!-- Row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-status bg-primary"></div>
                            <div class="card-body">
                                <h2 class="text-muted font-weight-bold">

                                </h2>
                                @inject('revenues','App\Custom\CustomChecks')
                                <div class="table-responsive push">
                                    <table class="table table-bordered table-hover text-nowrap">
                                        <tr class=" ">
                                            <th>Transaction Type</th>
                                            <th>Amount </th>
                                        </tr>
                                        <tr>
                                            <td colspan="1" class="font-weight-semibold text-left">Withdrawal </td>
                                            <td class="text-left" colspan="1">
                                                <span class="badge badge-primary">
                                                    {{$currency}}
                                                    {{number_format($revenues->withdrawalRevenue($currency),2)}}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" class="font-weight-semibold text-left">Send Money </td>
                                            <td class="text-left" colspan="1">
                                                <span class="badge badge-primary">
                                                    {{$currency}}
                                                    {{number_format($revenues->sendMoneyRevenue($currency),2)}}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" class="font-weight-semibold text-left">Payment Link </td>
                                            <td class="text-left" colspan="1">
                                                <span class="badge badge-primary">
                                                    {{$currency}}
                                                    {{number_format($revenues->paymentLinkPaymentRevenue($currency),2)}}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" class="font-weight-semibold text-left">Escrow </td>
                                            <td class="text-left" colspan="1">
                                                <span class="badge badge-primary">
                                                    {{$currency}}
                                                    {{number_format($revenues->escrowRevenue($currency),2)}}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" class="font-weight-semibold text-left">Internal Business Transfer </td>
                                            <td class="text-left" colspan="1">
                                                <span class="badge badge-primary">
                                                    {{$currency}}
                                                    {{number_format($revenues->payBusinessRevenue($currency),2)}}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" class="font-weight-semibold text-left">Business Api Payment </td>
                                            <td class="text-left" colspan="1">
                                                <span class="badge badge-primary">
                                                    {{$currency}}
                                                    {{number_format($revenues->businessApiPayments($currency),2)}}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" class="font-weight-semibold text-right text-info">Total Revenue </td>
                                            <td class="text-left" colspan="1">
                                                <span class="badge badge-success">
                                                    {{$currency}}
                                                    {{number_format($revenues->totalRevenue($currency),2)}}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End row-->
            </div>
        </div><!-- end app-content-->
    </div>

@include('dashboard.admin.templates.footer')
