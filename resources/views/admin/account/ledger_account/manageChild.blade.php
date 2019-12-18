
@foreach($childs as $child)
	<tbody>
		<tr>
				<td>
						@php
	                          echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
	                    @endphp
						<img src="{{asset('img')}}/right-arrow.png" alt="--->" height="20px" width="20px">
	        		{{ $child->name }}
	        
	    		</td>
	    		<td>
					{{ $child->code }}
				</td>
				<td>
					@foreach($heads as $head)
						@if($head->code == $child->parent_code)
							{{ $head->name }}
						@endif
					@endforeach
				</td>
				<td>
					<a href="{{URL::to('/maintenance')}}" class="" title="Add"><img src="{{asset('img')}}/add.png" alt="add" height="20px" width="20px"></a>
                    <a href="{{URL::to('/maintenance')}}" class="" title="Edit"><img src="{{asset('img')}}/edit.png" alt="edit" height="20px" width="20px"></a>
                    <a href="{{URL::to('/maintenance')}}" class="" title="Delete" id="delete"><img src="{{asset('img')}}/delete.png" alt="delete" height="20px" width="20px"></a>
				</td>
	  	</tr>
	  			@if(count($childs) && $child->code == 1100)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $asset_fixed,'fixed_land_and_building' => $fixed_land_and_building,'fixed_furniture_and_fixture' => $fixed_furniture_and_fixture,'fixed_office_equipments' => $fixed_office_equipments,'fixed_vehicles' => $fixed_vehicles,'fixed_electronic_equipments' => $fixed_electronic_equipments,'fixed_other_fixed_assets' => $fixed_other_fixed_assets])
	            @elseif(count($childs) && $child->code == 1500)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $asset_current,'current_loan_with_members' => $current_loan_with_members,'current_others_loan' => $current_others_loan,'current_advance' => $current_advance,'current_others_investment' => $current_others_investment,'current_cash_and_bank' => $current_cash_and_bank,'cash_and_bank_cash_in_hand' => $cash_and_bank_cash_in_hand,'cash_and_bank_cash_at_bank' => $cash_and_bank_cash_at_bank,'current_loan_to_project' => $current_loan_to_project,'current_other_current_asset' => $current_other_current_asset,'current_fund_with_branch' => $current_fund_with_branch])
	            @elseif(count($childs) && $child->code == 3100)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $current_liability_member_savings,'general_savings' => $general_savings,'jagaron' => $jagaron,'agrashor' => $agrashor,'buniad' => $buniad,'mfmsf' => $mfmsf,'sufalon' => $sufalon,'efrrap' => $efrrap,'fsp' => $fsp,'enrich_iga' => $enrich_iga,'enrich_lil' => $enrich_lil,'enrich_acl' => $enrich_acl,'education' => $education,'special_savings' => $special_savings,'monthly_savings' => $monthly_savings,'emergency_fund' => $emergency_fund,'health_savings' => $health_savings,'fixed_general_savings' => $fixed_general_savings])
	            @elseif(count($childs) && $child->code == 3200)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $other_savings,'other_special_savings' => $other_special_savings,'other_staff_welfare' => $other_staff_welfare])
	            @elseif(count($childs) && $child->code == 3300)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $long_term_liability,'long_fund' => $long_fund])
	            @elseif(count($childs) && $child->code == 3400)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $current_account_principal,'current_inter_transaction' => $current_inter_transaction])
	            @elseif(count($childs) && $child->code == 3500)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $others_liability,'other_reserve_and_provision' => $other_reserve_and_provision,'other_other_fund' => $other_other_fund])
	            @elseif(count($childs) && $child->code == 3600)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $capital_fund,'capital_retained_surplus' => $capital_retained_surplus,'capital_capital_fund' => $capital_capital_fund])
	            @elseif(count($childs) && $child->code == 3700)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $loan_with_others,'loan_loan_with_others' => $loan_loan_with_others])
	            @elseif(count($childs) && $child->code == 4100)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $income_general,'general_service_charge_member' => $general_service_charge_member,'general_service_charge_branch' => $general_service_charge_branch])
	            @elseif(count($childs) && $child->code == 4200)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $income_other,'other' => $other,'bank' => $bank])
	            @elseif(count($childs) && $child->code == 7700)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $income_reimburse])
	            @elseif(count($childs) && $child->code == 4500)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $income_training])
	            @elseif(count($childs) && $child->code == 5100)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $expense_financial,'financial_service_charge' => $financial_service_charge,'financial_interest_group_savings' => $financial_interest_group_savings])
	            @elseif(count($childs) && $child->code == 5200)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $expense_current,'current_service_charge_ho' => $current_service_charge_ho])
	            @elseif(count($childs) && $child->code == 5300)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $expense_salary,'salary_and_allowance' => $salary_and_allowance])
	            @elseif(count($childs) && $child->code == 5400)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $expense_operating,'operating_cost' => $operating_cost,'bank_charge' => $bank_charge])
	            @elseif(count($childs) && $child->code == 5600)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $expense_non_operating,'non_operating_cost' => $non_operating_cost])
	            @elseif(count($childs) && $child->code == 5700)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $expense_training_centre])
	            @elseif(count($childs) && $child->code == 5001)
	            	@include('admin.account.ledger_account.manageChild2',['childs' => $expense_loss_on_sale_of_land])
	        	@endif
	</tbody>
@endforeach