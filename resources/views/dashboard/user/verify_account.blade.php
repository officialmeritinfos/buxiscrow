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
<div class="card col-md-6 mx-auto" id="tabs-style3">
    <div class="card-header">
        <div class="card-title">
            {{$pageName}}
        </div>
    </div>
    <div class="card-body">
        @if($user->isVerified == 2)
        <p class="text-center text-indigo">Fill the form below to submit your account for verification</p>
        <form method="Post" action="{{url('account/documents/verify')}}" id="verificationForm"
              enctype="multipart/form-data">
            @csrf
            <div class="">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label">Select Document Available</label>
                    <select  class="form-control" id="exampleInputEmail1" name="document_type">
                        <option value="">Select Document</option>
                        @foreach($documents as $document)
                            @if($document->type ==2)
                                <option value="{{$document->id}}">{{$document->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="front_image"
                               accept="image/*" id="ImageBrowse">
                        <label class="custom-file-label">Image</label>
                    </div>
                </div>
                <div class="form-group" style="display: none;" id="back_image">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="back_image"
                               accept="image/*" id="ImageBrowse">
                        <label class="custom-file-label">Back Image</label>
                    </div>
                </div>
                <div class="form-group" style="display: none;" id="date_issued">
                    <label for="exampleInputPassword1" class="form-label">Date issued</label>
                    <input type="date" class="form-control" id="exampleInputPassword1"
                           name="date_issued">
                </div>
                <div class="form-group" style="display: none;" id="date_expire">
                    <label for="exampleInputPassword1" class="form-label">Date of Expiration</label>
                    <input type="date" class="form-control" id="exampleInputPassword1"
                           name="date_expire">
                </div>
                @foreach($documents as $doc)
                    @if($doc->type ==1)
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="form-label">{{$doc->name}}</label>
                            <input type="text" class="form-control" id="exampleInputPassword1"
                                   name="{{$doc->code}}">
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-4 mb-0" id="submit_verify">Submit</button>
            </div>
        </form>
        @endif
        @if($user->isVerified ==1)
                <p class="text-primary">
                    Your account has been verified — this means you can make higher payments until
                    you reach the account limit designated for your account.
                    <br>
                    <b>Note :</b> This limit can be increased upon request by contacting our support.
                </p>
        @elseif($user->isVerified == 4)
                <p class="text-info">
                    Your documents are currently being processed. You will receive a feedback soon.
                </p>

        @endif
    </div>
</div>



<!-- Row -->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.user.templates.footer')
