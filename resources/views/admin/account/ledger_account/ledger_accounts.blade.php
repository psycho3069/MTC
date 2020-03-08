@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>Ledger Accounts</h3></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p class="alert-success" style="font-size: 20px; color: white; background:#149278; padding: 0 30px 0 30px;">
                    @php
                      $message=Session::get('message');
                        if($message) {
                          echo $message;
                          Session::put('message',null);
                        }
                    @endphp
                    </p>

                    <div class="col-md-12 text-sm-left">
                        
                            <table id="tree1" class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th width="60%">Name</th>
                                        <th width="10%">Code</th>
                                        <th width="20%">Account Type</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                </thead>

                                
                                      
                                      @foreach($account_head_types as $account_head_type)
                                      <tbody>
                                        <tr>
                                            <td class="text-primary">
                                                <img src="{{asset('img')}}/admin.png" alt="--->" height="20px" width="20px">
                                                <b><big>{{ $account_head_type->name }}</big></b>
                                                
                                            </td>
                                            <td class="text-primary">
                                                <b><big>{{ $account_head_type->code }}</big></b>
                                            </td>
                                            <td>{{ "" }}</td>
                                            <td></td>
                                        </tr>
                                      <tbody>

                                        @if(count($account_head_types) && $account_head_type->code == 1000)
                                            @include('admin.account.ledger_account.manageChild',['childs' => $assets,'all' => $all,'heads' => $account_head_types,'asset_fixed' => $asset_fixed,'fixed_land_and_building' => $fixed_land_and_building,'fixed_furniture_and_fixture' => $fixed_furniture_and_fixture,'fixed_office_equipments' => $fixed_office_equipments,'fixed_vehicles' => $fixed_vehicles,'fixed_electronic_equipments' => $fixed_electronic_equipments,'fixed_other_fixed_assets' => $fixed_other_fixed_assets,'asset_current' => $asset_current,'current_loan_with_members' => $current_loan_with_members,'current_others_loan' => $current_others_loan,'current_advance' => $current_advance,'current_others_investment' => $current_others_investment,'current_cash_and_bank' => $current_cash_and_bank,'cash_and_bank_cash_in_hand' => $cash_and_bank_cash_in_hand,'cash_and_bank_cash_at_bank' => $cash_and_bank_cash_at_bank,'current_loan_to_project' => $current_loan_to_project,'current_other_current_asset' => $current_other_current_asset,'current_fund_with_branch' => $current_fund_with_branch])
                                        @elseif(count($account_head_types) && $account_head_type->code == 3000)
                                            @include('admin.account.ledger_account.manageChild',['childs' => $liability,'all' => $all,'heads' => $account_head_types,'current_liability_member_savings' => $current_liability_member_savings,'general_savings' => $general_savings,'jagaron' => $jagaron,'agrashor' => $agrashor,'buniad' => $buniad,'mfmsf' => $mfmsf,'sufalon' => $sufalon,'efrrap' => $efrrap,'fsp' => $fsp,'enrich_iga' => $enrich_iga,'enrich_lil' => $enrich_lil,'enrich_acl' => $enrich_acl,'education' => $education,'special_savings' => $special_savings,'other_special_savings' => $other_special_savings,'other_staff_welfare' => $other_staff_welfare,'monthly_savings' => $monthly_savings,'emergency_fund' => $emergency_fund,'health_savings' => $health_savings,'fixed_general_savings' => $fixed_general_savings,'other_savings' => $other_savings,'long_term_liability' => $long_term_liability,'long_fund' => $long_fund,'current_account_principal' => $current_account_principal,'current_inter_transaction' => $current_inter_transaction,'others_liability' => $others_liability,'other_reserve_and_provision' => $other_reserve_and_provision,'other_other_fund' => $other_other_fund,'capital_fund' => $capital_fund,'capital_retained_surplus' => $capital_retained_surplus,'capital_capital_fund' => $capital_capital_fund,'loan_with_others' => $loan_with_others,'loan_loan_with_others' => $loan_loan_with_others])
                                        @elseif(count($account_head_types) && $account_head_type->code == 4000)
                                            @include('admin.account.ledger_account.manageChild',['childs' => $income,'all' => $all,'heads' => $account_head_types,'income_general' => $income_general,'general_service_charge_member' => $general_service_charge_member,'general_service_charge_branch' => $general_service_charge_branch,'income_other' => $income_other,'other' => $other,'bank' => $bank,'income_reimburse' => $income_reimburse,'income_training' => $income_training])
                                        @elseif(count($account_head_types) && $account_head_type->code == 5000)
                                            @include('admin.account.ledger_account.manageChild',['childs' => $expense,'all' => $all,'heads' => $account_head_types,'expense_financial' => $expense_financial,'financial_service_charge' => $financial_service_charge,'financial_interest_group_savings' => $financial_interest_group_savings,'expense_current' => $expense_current,'current_service_charge_ho' => $current_service_charge_ho,'expense_salary' => $expense_salary,'salary_and_allowance' => $salary_and_allowance,'expense_operating' => $expense_operating,'operating_cost' => $operating_cost,'bank_charge' => $bank_charge,'expense_non_operating' => $expense_non_operating,'non_operating_cost' => $non_operating_cost,'expense_training_centre' => $expense_training_centre,'expense_loss_on_sale_of_land' => $expense_loss_on_sale_of_land])
                                        @elseif(count($account_head_types) && $account_head_type->code == 6000)
                                            @include('admin.account.ledger_account.manageChild',['childs' => $equity])
                                        @endif

                                      @endforeach
                                        

                                    {{-- previous  --}}
                                    {{-- @foreach($roles as $role)
                                        <tr>
                                            <td>
                                                {{ $role->id }}
                                            </td>
                                            <td>
                                                <img src="{{asset('img')}}/admin.png" alt="--->" height="20px" width="20px">
                                                <b><big>{{ $role->name }}</big></b>
                                                
                                            </td>
                                        </tr>
                                        @if(count($role->childs))
                                            @include('admin.admin.role_wise_permission.manageChild',['childs' => $role->childs])
                                        @endif
                                    @endforeach --}}
                                    {{-- previous --}}
                                
                            </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('datatable')
    
<!-- datatable -->
{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
{{-- <script>
    $(document).ready(function() {
        $('#tree1').DataTable();
    } );
</script> --}}

@endsection