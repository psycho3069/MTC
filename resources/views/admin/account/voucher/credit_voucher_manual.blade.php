@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header row">
                  <div class="col-md-6">
                    <a href="{{URL::to('/account/voucher/vouchers')}}" class="btn btn-primary">BACK</a>
                  </div>
                  <div class="col-md-6">
                    <strong><big>Credit Voucher</big></strong>
                  </div>
                    
                    
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
   
                 @if (count($errors) > 0)
                  <div class="alert alert-danger" style="padding: 0 30px 0 30px;">
                   Upload Validation Error<br><br>
                   <ul>
                    @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                    @endforeach
                   </ul>
                  </div>
                 @endif
                 @if ($message = Session::get('success'))
                 <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                         <strong>{{ $message }}</strong>
                 </div>
                 @endif

                <!--form-->
               
                <form class="" action="{{ url('/save_credit_manual') }}" method="post" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
                  @csrf

                  <p class="alert-success" style="font-size: 20px; color: white; background:#149278; padding: 0 30px 0 30px;">
                      @php
                        $message=Session::get('message');
                          if($message) {
                            echo $message;
                            Session::put('message',null);
                          }
                      @endphp
                    </p>

                    <div class="form-group">
                        <div class="form-group row">
                          <label for="fund" class="col-md-6 col-form-label text-md-left">Funding Organization</label>
                          <div class="col-md-6">
                            <select id="fund" name="fund" class="form-control" required>
                              <option value>--Choose One--</option>
                              {{-- @foreach($room_info as $row)
                                <option value="{{ $row->id }}">{{ $row->room_no }}</option>
                              @endforeach --}}
                            </select>
                          </div>
                        </div>
                        
                        <div class="form-group row">
                          <label for="date" class="col-md-6 col-form-label text-md-left">Date</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="date" name="date" autocomplete="off" value="@php
                              echo date("Y-m-d");
                            @endphp" required readonly="true">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="credit_amount" class="col-md-6 col-form-label text-md-left">Credit Amount</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="credit_amount" name="credit_amount" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="debit_account" class="col-md-6 col-form-label text-md-left">Debit Account</label>
                          <div class="col-md-6">
                            <select id="debit_account" name="debit_account" class="form-control" required>
                              <option value>--Choose One--</option>
                              {{-- @foreach($room_info as $row)
                                <option value="{{ $row->id }}">{{ $row->room_no }}</option>
                              @endforeach --}}
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="credit_account" class="col-md-6 col-form-label text-md-left">Credit Account</label>
                          <div class="col-md-6">
                            <select id="credit_account" name="credit_account" class="form-control" required>
                              <option value>--Choose One--</option>
                              {{-- @foreach($room_info as $row)
                                <option value="{{ $row->id }}">{{ $row->room_no }}</option>
                              @endforeach --}}
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="details" class="col-md-6 col-form-label text-md-left">Details</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="details" name="details" required>
                          </div>
                        </div>
                    </div>

                      <!-- Button -->
                      <div class="form-group">
                          <button type="submit" class="btn btn-success" >ADD</button>
                          <button type="reset" class="btn btn-danger" >RESET</button>
                      </div>

                      
                  </form>
                  <table id="debit" class="table table-bordered table-primary table-hover">
                    <thead>
                        <tr>
                            <th class="">Ledger Head</th>
                            <th class="">Amount</th>           
                            <th class="">Details</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection