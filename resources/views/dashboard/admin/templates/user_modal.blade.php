<!-- Increase Individual Balance account Limit-->
<div class="modal" id="increaseIAccountLimit">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title">Increase {{$users->name}} Individual Account Limit</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" action="{{url('admin/user/increase_i_account_limit')}}">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">New Limit <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Amount"
                                       name="amount">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">ID <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="id" value="{{$users->id}}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Balance <span class="text-red">*</span></label>
                                <select type="text" class="form-control form-control-lg" name="balance">
                                    <option value="">Select a Balance</option>
                                    @foreach($balances as $bals)
                                        <option value="{{$bals->code}}">{{$bals->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn  btn-md btn-indigo">
                                    <i class="fa fa-arrow-circle-o-up"></i> Increase</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div></div>
    </div>
</div>
<!-- Increase Business Balance account Limit-->
<div class="modal" id="increaseBAccountLimit">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title">Increase {{$users->name}} Business Account Limit</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" action="{{url('admin/user/increase_b_account_limit')}}">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">New Limit <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Amount"
                                       name="amount">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">ID <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="id" value="{{$users->id}}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Balance <span class="text-red">*</span></label>
                                <select type="text" class="form-control form-control-lg" name="balance">
                                    <option value="">Select a Balance</option>
                                    @foreach($merchantBalances as $balss)
                                        <option value="{{$balss->code}}">{{$balss->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn  btn-md btn-info">
                                    <i class="fa fa-arrow-circle-o-up"></i> Increase</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div></div>
    </div>
</div>
<!-- Increase Business Balance transaction Limit-->
<div class="modal" id="increaseBTransLimit">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title">Increase {{$users->name}} Business Transaction Limit</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" action="{{url('admin/user/increase_b_trans_limit')}}">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">New Limit <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Amount"
                                       name="amount">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">ID <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="id" value="{{$users->id}}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Balance <span class="text-red">*</span></label>
                                <select type="text" class="form-control form-control-lg" name="balance">
                                    <option value="">Select a Balance</option>
                                    @foreach($merchantBalances as $balss)
                                        <option value="{{$balss->code}}">{{$balss->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn  btn-md btn-info">
                                    <i class="fa fa-arrow-circle-o-up"></i> Increase</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div></div>
    </div>
</div>
<!-- Increase Individual Balance account Limit-->
<div class="modal" id="increaseITransLimit">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title">Increase {{$users->name}} Individual Transaction Limit</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" action="{{url('admin/user/increase_i_trans_limit')}}">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">New Limit <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Amount"
                                       name="amount">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">ID <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="id" value="{{$users->id}}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Balance <span class="text-red">*</span></label>
                                <select type="text" class="form-control form-control-lg" name="balance">
                                    <option value="">Select a Balance</option>
                                    @foreach($merchantBalances as $balss)
                                        <option value="{{$balss->code}}">{{$balss->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn  btn-md btn-info">
                                    <i class="fa fa-arrow-circle-o-up"></i> Increase</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div></div>
    </div>
</div>
