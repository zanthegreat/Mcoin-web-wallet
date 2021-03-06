@extends('admin_template')

@section('content')

	<div class="block-header">
	    <h2>TRANSACTIONS</h2>
	</div>

	<!-- Horizontal Layout -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">

                	{{-- Form Message --}}
                    <h2>TRANSFER ASSET</h2>

                    {{-- Form Hidden Button --}}
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Reset</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="body">
                    <form class="form-horizontal">

                    	{{-- Wallet Address Field --}}
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="email_address_2">Wallet Address</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="address" class="form-control" placeholder="Enter targeted wallet address" name="address">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Amount Field --}}
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="password_2">Amount</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" id="amount" class="form-control" placeholder="Enter amount" name="amount">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Email Field --}}
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="password_2">Email</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="email" id="email" class="form-control" placeholder="Enter targeted email address" name="email">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Send Button --}}
                        <div class="row clearfix">
                            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                <button type="button" class="btn btn-lg btn-primary m-t-15 waves-effect" onclick="sendForm()">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Horizontal Layout -->

    <script type="text/javascript">
        // Transfer assets to another wallet
        function sendForm (){

            if($('#amount').val() > 0 && $('#address').val() != "" && $('#email').val() != "")
            {
                var apiLink = '/transactions/transfer/add';

                // Get data from form
                var datas = {
                    'address': $('#address').val(),
                    'amount': $('#amount').val(),
                    'email': $('#email').val()
                };

                swal({
                    title: 'Confirm to transfer '+$('#amount').val()+' ETP to <br>',
                    text: $('#address').val()+'\n'+$('#email').val()+' ?',
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    showLoaderOnConfirm: true,
                    preConfirm: function (result) {
                        return new Promise(function (resolve, reject) {
                // Ajax request to the api
                $.ajax({
                    url: apiLink,
                    type:'post',
                    data: datas,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(result){
                        resolve(result);
                    }
                });
                })
                    },
                    allowOutsideClick: false
                }).then(function (result) {
                    if(result.success){
                        swal('SUCCESS', result.message, 'success').then(function() {
                            window.location = "/wallet";
                        });
                    }else{
                        var msg = "";
                        if(typeof result.message === 'object'){
                            for (var key in result.message) {
                                if (result.message.hasOwnProperty(key)) {
                                    msg += result.message[key][0]+"<br>";
                                }
                            }
                        }else{
                            msg += result.message;
                        }
                        swal('FAILED', msg, 'error');
                    }
                })
            }
            else
            {
                swal('FAILED', 'Please make sure to insert valid amount, email address, and wallet address', 'error');
            }

        }
    </script>

@endsection