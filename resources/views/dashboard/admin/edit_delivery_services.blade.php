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

@inject('option','App\Custom\CustomChecks')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$pageName}}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('admin/delivery_services/edit')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="name" value="{{$delivery->name}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Phone</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="phone" value="{{$delivery->phone}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Logo</label>
                                <input type="file" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="logo">
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">id</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                            placeholder="Enter title"
                            name="id" value="{{$delivery->id}}">
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-red">*</span></label>
                                <select class="form-control form-control-lg" name="status">
                                    <option value="">Select Status</option>
                                    <option value="1" selected>Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
</div><!-- end app-content-->
</div>


@include('dashboard.admin.templates.footer')
