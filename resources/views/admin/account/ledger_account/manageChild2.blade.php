
@foreach($childs as $child)
	<tbody>
		<tr>
				<td>
						@php
	                          echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
	                    switch ($child->parent_code) {
	                    	case '7700':
	                    	case '4500':
	                    	case '5700':
	                    		@endphp
	                    			<img src="{{asset('img')}}/child.png" alt="--->" height="20px" width="20px">
	                    		@php
	                    		break;
	                    	default:
	                    		@endphp
	                    			<img src="{{asset('img')}}/right-arrow.png" alt="--->" height="20px" width="20px">
	                    		@php
	                    		break;
	                    }
	                    @endphp
	        		{{ $child->name }}
	        
	    		</td>
	    		<td>
					{{ $child->code }}
				</td>
				<td>
					@foreach($all as $heads)
						@if($heads->code == $child->parent_code)
							{{ $heads->name }}
						@endif
					@endforeach
				</td>
				<td>
					<a href="{{URL::to('/maintenance')}}" class="" title="Add"><img src="{{asset('img')}}/add.png" alt="add" height="20px" width="20px"></a>
                    <a href="{{URL::to('/maintenance')}}" class="" title="Edit"><img src="{{asset('img')}}/edit.png" alt="edit" height="20px" width="20px"></a>
                    <a href="{{URL::to('/maintenance')}}" class="" title="Delete" id="delete"><img src="{{asset('img')}}/delete.png" alt="delete" height="20px" width="20px"></a>
				</td>
	  	</tr>
	  			@if(count($childs) && $child->code == 1150)
					@include('admin.account.ledger_account.manageChild3',['childs' => $fixed_land_and_building])
				@elseif(count($childs) && $child->code == 1200)
					@include('admin.account.ledger_account.manageChild3',['childs' => $fixed_furniture_and_fixture])
				@elseif(count($childs) && $child->code == 1250)
					@include('admin.account.ledger_account.manageChild3',['childs' => $fixed_office_equipments])
				@elseif(count($childs) && $child->code == 1300)
					@include('admin.account.ledger_account.manageChild3',['childs' => $fixed_vehicles])
				@elseif(count($childs) && $child->code == 1350)
					@include('admin.account.ledger_account.manageChild3',['childs' => $fixed_electronic_equipments])
				@elseif(count($childs) && $child->code == 1400)
					@include('admin.account.ledger_account.manageChild3',['childs' => $fixed_other_fixed_assets])
				@elseif(count($childs) && $child->code == 1900)
					@include('admin.account.ledger_account.manageChild3',['childs' => $current_loan_with_members])
				@elseif(count($childs) && $child->code == 2000)
					@include('admin.account.ledger_account.manageChild3',['childs' => $current_others_loan])
				@elseif(count($childs) && $child->code == 2100)
					@include('admin.account.ledger_account.manageChild3',['childs' => $current_advance])
				@elseif(count($childs) && $child->code == 2300)
					@include('admin.account.ledger_account.manageChild3',['childs' => $current_others_investment])
				@elseif(count($childs) && $child->code == 1700)
					@include('admin.account.ledger_account.manageChild3',['childs' => $current_cash_and_bank,'cash_and_bank_cash_in_hand' => $cash_and_bank_cash_in_hand,'cash_and_bank_cash_at_bank' => $cash_and_bank_cash_at_bank])
				@elseif(count($childs) && $child->code == 1510)
					@include('admin.account.ledger_account.manageChild3',['childs' => $current_loan_to_project])
				@elseif(count($childs) && $child->code == 1550)
					@include('admin.account.ledger_account.manageChild3',['childs' => $current_other_current_asset])
				@elseif(count($childs) && $child->code == 1600)
					@include('admin.account.ledger_account.manageChild3',['childs' => $current_fund_with_branch])
				@elseif(count($childs) && $child->code == 3120)
					@include('admin.account.ledger_account.manageChild3',['childs' => $general_savings,'jagaron' => $jagaron,'agrashor' => $agrashor,'buniad' => $buniad,'mfmsf' => $mfmsf,'sufalon' => $sufalon,'efrrap' => $efrrap,'fsp' => $fsp,'enrich_iga' => $enrich_iga,'enrich_lil' => $enrich_lil,'enrich_acl' => $enrich_acl,'education' => $education])
				@elseif(count($childs) && $child->code == 3140)
					@include('admin.account.ledger_account.manageChild3',['childs' => $special_savings])
				@elseif(count($childs) && $child->code == 3150)
					@include('admin.account.ledger_account.manageChild3',['childs' => $monthly_savings])
				@elseif(count($childs) && $child->code == 3160)
					@include('admin.account.ledger_account.manageChild3',['childs' => $emergency_fund])
				@elseif(count($childs) && $child->code == 3180)
					@include('admin.account.ledger_account.manageChild3',['childs' => $health_savings])
				@elseif(count($childs) && $child->code == 3190)
					@include('admin.account.ledger_account.manageChild3',['childs' => $fixed_general_savings])
				@elseif(count($childs) && $child->code == 3201)
					@include('admin.account.ledger_account.manageChild3',['childs' => $other_special_savings])
				@elseif(count($childs) && $child->code == 3206)
					@include('admin.account.ledger_account.manageChild3',['childs' => $other_staff_welfare])
				@elseif(count($childs) && $child->code == 3350)
					@include('admin.account.ledger_account.manageChild3',['childs' => $long_fund])
				@elseif(count($childs) && $child->code == 3420)
					@include('admin.account.ledger_account.manageChild3',['childs' => $current_inter_transaction])
				@elseif(count($childs) && $child->code == 3520)
					@include('admin.account.ledger_account.manageChild3',['childs' => $other_reserve_and_provision])
				@elseif(count($childs) && $child->code == 3550)
					@include('admin.account.ledger_account.manageChild3',['childs' => $other_other_fund])
				@elseif(count($childs) && $child->code == 3620)
					@include('admin.account.ledger_account.manageChild3',['childs' => $capital_retained_surplus])
				@elseif(count($childs) && $child->code == 3601)
					@include('admin.account.ledger_account.manageChild3',['childs' => $capital_capital_fund])
				@elseif(count($childs) && $child->code == 3710)
					@include('admin.account.ledger_account.manageChild3',['childs' => $loan_loan_with_others])
				@elseif(count($childs) && $child->code == 4150)
					@include('admin.account.ledger_account.manageChild3',['childs' => $general_service_charge_member])
				@elseif(count($childs) && $child->code == 4400)
					@include('admin.account.ledger_account.manageChild3',['childs' => $general_service_charge_branch])
				@elseif(count($childs) && $child->code == 4250)
					@include('admin.account.ledger_account.manageChild3',['childs' => $other])
				@elseif(count($childs) && $child->code == 4300)
					@include('admin.account.ledger_account.manageChild3',['childs' => $bank])
				@elseif(count($childs) && $child->code == 5130)
					@include('admin.account.ledger_account.manageChild3',['childs' => $financial_service_charge])
				@elseif(count($childs) && $child->code == 5120)
					@include('admin.account.ledger_account.manageChild3',['childs' => $financial_interest_group_savings])
				@elseif(count($childs) && $child->code == 5220)
					@include('admin.account.ledger_account.manageChild3',['childs' => $current_service_charge_ho])
				@elseif(count($childs) && $child->code == 5310)
					@include('admin.account.ledger_account.manageChild3',['childs' => $salary_and_allowance])
				@elseif(count($childs) && $child->code == 5450)
					@include('admin.account.ledger_account.manageChild3',['childs' => $operating_cost])
				@elseif(count($childs) && $child->code == 5500)
					@include('admin.account.ledger_account.manageChild3',['childs' => $bank_charge])
				@elseif(count($childs) && $child->code == 5650)
					@include('admin.account.ledger_account.manageChild3',['childs' => $non_operating_cost])
	        	@endif
	</tbody>
@endforeach