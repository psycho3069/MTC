				
				@foreach($childs as $child)
						<tr>
								<td>
									{{ $child->id }}
								</td>
								<td>
										@php
					                          echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
					                    @endphp
										<img src="{{asset('img')}}/right-arrow.png" alt="--->" height="20px" width="20px">
					        {{ $child->name }}
					        
					    		</td>
					  	</tr>
					  			@if(count($child->childs))
					            	@include('admin.admin.role_wise_permission.manageChild2',['childs' => $child->childs])
					        	@endif
				@endforeach
				
									