@include('dashboard.user.templates.header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{$pageName}}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('account/dashboard')}}" class="d-flex">
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
                                        @isset($logins)
                                            <div class="text-center">
                                                <a href="{{url('account/activities')}}" class="btn btn-outline-primary text-center" style="margin-bottom: 5px;">
                                                    View Account Activities</a>
                                            </div>
                                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Location</th>
                                                    <th class="border-bottom-0">Device</th>
                                                    <th class="border-bottom-0">Ip</th>
                                                    <th class="border-bottom-0">ISP</th>
                                                    <th class="border-bottom-0">Time Accessed</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($logins as $login)
                                                    <tr>
                                                        <td>{{$login->location}}</td>
                                                        <td>{{$login->agent}}</td>
                                                        <td>{{$login->loginIp}}</td>
                                                        <td>{{$login->isp}}</td>
                                                        <td>{{$login->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="text-center">
                                                <a href="{{url('account/logins')}}" class="btn btn-outline-secondary text-center" style="margin-bottom: 5px;">
                                                    View Account Logins</a>
                                            </div>
                                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                                <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Activity</th>
                                                    <th class="border-bottom-0">Details</th>
                                                    <th class="border-bottom-0">Ip</th>
                                                    <th class="border-bottom-0">Time</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($activities as $activity)
                                                        <tr>
                                                            <td>{{$activity->activity}}</td>
                                                            <td>{!! $activity->details  !!}</td>
                                                            <td>{{$activity->agent_ip}}</td>
                                                            <td>{{$activity->created_at}}</td>
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

@include('dashboard.user.templates.footer')
