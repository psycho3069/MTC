
@foreach($childs as $child)
	<tbody>
		<tr>
				<td>
						@php
	                          echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
	                    @endphp
						<img src="{{asset('img')}}/child.png" alt="--->" height="20px" width="20px">
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
	  			{{-- @if(count($childs) && $child->code == 1750)
					@include('admin.account.ledger_account.manageChild4',['childs' => $cash_and_bank_cash_in_hand])
				@elseif(count($childs) && $child->code == 1800)
					@include('admin.account.ledger_account.manageChild4',['childs' => $cash_and_bank_cash_at_bank])
	        	@endif --}}
	</tbody>
@endforeach					