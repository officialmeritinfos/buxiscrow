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
                    <div class="text-center">
                        <button class="btn btn-sm btn-info text-center" data-toggle="modal"
                        data-target="#add_faq">Add Business Subcategory</button>
                    </div>
                    <div class="table-responsive">
                        @isset($subcategories)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Category/Industry</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Date Added</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subcategories as $type)
                                @inject('option','App\Custom\CustomChecks')
                                    <tr>
                                        <td>{{$type->subcategory_name}}</td>
                                        <td>{{$option->getBusinessCategory($type->category_id)}}</td>
                                        <td>
                                            @switch($type->status)
                                                @case(1)
                                                <span class="badge badge-success">Active</span>
                                                @break
                                                @default
                                                <span class="badge badge-primary">Inactive</span>
                                            @endswitch
                                        </td>
                                        <td>{{$type->created_at}}</td>
                                        <td>
                                            <a href="{{url('admin/business_subcategory/edit/'.$type->id)}}" class="btn btn-outline-info">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{url('admin/business_subcategory/delete/'.$type->id)}}" class="btn btn-outline-danger">
                                                <i class="fa fa-times-circle"></i>
                                            </a>
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

<!-- Add Faq-->
<div class="modal" id="add_faq">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title">Add Business Subcategory</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" action="{{url('admin/business_subcategory/add')}}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Category <span class="text-red">*</span></label>
                                <select class="form-control form-control-lg" name="category">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Name <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Title"
                                       name="name" id="amount">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-red">*</span></label>
                                <select class="form-control form-control-lg" name="status">
                                    <option value="">Select Status</option>
                                    <option value="1" selected>Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn  btn-md btn-info">
                                    <i class="fa fa-arrow-circle-o-up"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div></div>
    </div>
</div>
@include('dashboard.admin.templates.footer')
