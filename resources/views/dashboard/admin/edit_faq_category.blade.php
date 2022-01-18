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
    <div class="col-lg-8 col-md-8 col-sm-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$pageName}}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('admin/faq_category/edit')}}">
                    @csrf
                    <div class="">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Title</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Enter title"
                            name="title" value="{{$category->category_name}}">
                        </div>
                        <div class="form-group" style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">Title</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Enter title"
                            name="id" value="{{$category->id}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="form-label">Description</label>
                            <textarea class="form-control form-control-lg" id="exampleInputPassword1" name="description">{{$category->description}}</textarea>
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
