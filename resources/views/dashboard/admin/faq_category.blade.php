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
                        data-target="#add_faq_category">Add Faq Category</button>
                    </div>
                    <div class="table-responsive">
                        @isset($categories)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Title</th>
                                    <th class="border-bottom-0">Description</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Date Added</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $cate)
                                    <tr>
                                        <td>{{$cate->category_name}}</td>
                                        <td>{{$cate->description}}</td>
                                        <td>
                                            @switch($cate->status)
                                                @case(1)
                                                <span class="badge badge-success">Active</span>
                                                @break
                                                @default
                                                <span class="badge badge-dark">Inactive</span>
                                            @endswitch
                                        </td>
                                        <td>{{$cate->created_at}}</td>
                                        <td>
                                            <a href="{{url('admin/faq_category/edit/'.$cate->id)}}" class="btn btn-outline-info">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{url('admin/faq_category/delete/'.$cate->id)}}" class="btn btn-outline-danger">
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

<!-- Add Faq Category-->
<div class="modal" id="add_faq_category">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title">Add Faq Category</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" action="{{url('admin/faq_category/addcategory')}}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Title <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Title"
                                       name="title" id="amount">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Description <span class="text-red">*</span></label>
                                <textarea class="form-control form-control-lg" id="exampleInputPassword1" name="description"></textarea>
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
