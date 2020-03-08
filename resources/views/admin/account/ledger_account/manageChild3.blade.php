
@foreach($childs as $child)
	<tbody>
		<tr>
				<td>
						@php
	                          echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";

	                    switch ($child->code) {
	                    	case '1750':
	                    	case '1800':
	                    	case '3120.1':
	                    	case '3120.2':
	                    	case '3120.3':
	                    	case '3120.4':
	                    	case '3120.5':
	                    	case '3120.6':
	                    	case '3120.7':
	                    	case '3120.8':
	                    	case '3120.9':
	                    	case '3120.10':
	                    	case '3120.11':
	                    		@endphp
	                    		<img src="{{asset('img')}}/right-arrow.png" alt="--->" height="20px" width="20px">
	                    		@php
	                    		break;
	                    	default:
	                    		@endphp
	                    		<img src="{{asset('img')}}/child.png" alt="--->" height="20px" width="20px">
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
	  			@if(count($childs) && $child->code == 1750)
					@include('admin.account.ledger_account.manageChild4',['childs' => $cash_and_bank_cash_in_hand])
				@elseif(count($childs) && $child->code == 1800)
					@include('admin.account.ledger_account.manageChild4',['childs' => $cash_and_bank_cash_at_bank])
				@elseif(count($childs) && $child->code == 3120.1)
					@include('admin.account.ledger_account.manageChild4',['childs' => $jagaron])
				@elseif(count($childs) && $child->code == 3120.2)
					@include('admin.account.ledger_account.manageChild4',['childs' => $agrashor])
				@elseif(count($childs) && $child->code == 3120.3)
					@include('admin.account.ledger_account.manageChild4',['childs' => $buniad])
				@elseif(count($childs) && $child->code == 3120.4)
					@include('admin.account.ledger_account.manageChild4',['childs' => $mfmsf])
				@elseif(count($childs) && $child->code == 3120.5)
					@include('admin.account.ledger_account.manageChild4',['childs' => $sufalon])
				@elseif(count($childs) && $child->code == 3120.6)
					@include('admin.account.ledger_account.manageChild4',['childs' => $efrrap])
				@elseif(count($childs) && $child->code == 3120.7)
					@include('admin.account.ledger_account.manageChild4',['childs' => $fsp])
				@elseif(count($childs) && $child->code == 3120.8)
					@include('admin.account.ledger_account.manageChild4',['childs' => $enrich_iga])
				@elseif(count($childs) && $child->code == 3120.9)
					@include('admin.account.ledger_account.manageChild4',['childs' => $enrich_lil])
				@elseif(count($childs) && $child->code == 3120.10)
					@include('admin.account.ledger_account.manageChild4',['childs' => $enrich_acl])
				@elseif(count($childs) && $child->code == 3120.11)
					@include('admin.account.ledger_account.manageChild4',['childs' => $education])
	        	@endif
	</tbody>
@endforeach					