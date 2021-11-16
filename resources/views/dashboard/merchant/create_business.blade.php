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
       <div class="col-md-10 mx-auto">
           <div class="card">
               <div class="card-body">
                   <form method="POST" id="new_business" action="{{url('merchant/add-business')}}">
                       @csrf
                       <div class="row">
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1" class="form-label">Store Name</label>
                               <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="name">
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1" class="form-label">Type of Business</label>
                               <select class="form-control form-control-lg " id="exampleInputEmail1" name="business_type">
                                   <option value="">Select Type</option>
                                   @foreach($businessTypes as $type)
                                       <option value="{{$type->id}}">{{$type->name}}</option>
                                   @endforeach
                               </select>
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1" class="form-label">Category</label>
                               <select class="form-control form-control-lg " id="exampleInputEmail1" name="category">
                                   <option value="">Select Category</option>
                                   @foreach($categories as $category)
                                       <option value="{{$category->id}}">{{$category->category_name}}</option>
                                   @endforeach
                               </select>
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1" class="form-label">Subcategory</label>
                               <select class="form-control form-control-lg " id="exampleInputEmail1" name="subcategory">

                               </select>
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1" class="form-label">Contact Number</label>
                               <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="phone">
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1" class="form-label">Contact Email <small>(optional)</small></label>
                               <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" name="email">
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1" class="form-label">Contact Country</label>
                               <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="country">
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1" class="form-label">Contact State</label>
                               <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="state">
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1" class="form-label">Contact City</label>
                               <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="city">
                           </div>
                           <div class="form-group col-md-6">
                               <label for="exampleInputEmail1" class="form-label">Zip Code</label>
                               <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="zip">
                           </div>
                           <div class="form-group col-md-12">
                               <label for="exampleInputEmail1" class="form-label">Address
                                   <i class="fa fa-info-circle" data-toggle="tooltip" title="will be used for verification"></i>
                               </label>
                               <textarea class="form-control form-control-lg" id="exampleInputEmail1" name="address"></textarea>
                           </div>
                           <div class="form-group col-md-12">
                               <label for="exampleInputEmail1" class="form-label">Description
                                   <i class="fa fa-info-circle" data-toggle="tooltip"
                                      title="Tell us about your business. This is also what your customers will see."></i>
                               </label>
                               <textarea class="form-control form-control-lg" id="exampleInputEmail1" name="description" rows="6"></textarea>
                           </div>
                           <div class="form-group col-md-12">
                               <label for="exampleInputEmail1" class="form-label">Business Keywords
                                   <i class="fa fa-info-circle" data-toggle="tooltip"
                                      title="Keywords that will reveal your business. Separate each keyword with a comma."></i>
                               </label>
                               <input class="form-control form-control-lg" id="exampleInputEmail1" name="tags">
                           </div>

                       </div>
                       <div class="text-center">
                           <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="add_store">
                               <i class="fa fa-plus-square"></i> Add</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
    </div>
</div>
<!-- /Row -->

</div>
</div><!-- end app-content-->
</div>
@include('dashboard.merchant.templates.business_modal')
@include('dashboard.merchant.templates.footer')
