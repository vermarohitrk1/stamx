<style>.nav-tabs > li > a {margin-right: 2px;line-height: 1.42857143;border: 1px solid transparent;border-radius: 4px 4px 0 0;}.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {color: #555;cursor: default;background-color: #fff;border: 1px solid #ddd;border-bottom-color: rgb(221, 221, 221);border-bottom-color: transparent;}.nav > li > a {position: relative;display: block;padding: 10px 15px; color: #595959;text-decoration: none;}</style>
    
<style>
    .card-body.affiliate-card {
    text-align: -webkit-center;
}
</style>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <ul class="nav nav-tabs">
                    @if($typeview=="active")                    
                        <li class="active" ><a href="{{ route('assessment.dashboard') }}">Active</a></li>
                        <li  ><a href="{{ route('assessment.dashboard','views=sent') }}">{{__('Sent')}}</a></li>
                    @else                    
                        <li  ><a href="{{ route('assessment.dashboard','views=active') }}">{{__('Active')}}</a></li>
                        <li class="active" ><a href="{{ route('assessment.dashboard') }}">Sent</a></li>
                    @endif
                </ul>                 
                
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('Sender')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Form')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Questions')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Responses')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Points')}}</th>
                            <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th> 
                        </tr>
                        </thead>
                        <tbody class="list">
                        @if(count($data) > 0)
                        @foreach($data as $index => $row)
                        <tr>
                             <td class="name mb-0 h6 text-sm"><strong>{{date('M d, Y', strtotime($row->created_at))}}</strong><br><span>{{ $row->form_user_details }} </span></td>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <a class="name mb-0 text-sm text-dark">{{ $row->form_category_name }} </a>     <small class=" ml-3 badge badge-pill badge-sm badge-{{ !empty($row->form_details->type) && $row->form_details->type=="Free" ? 'success' :'primary' }}">{{ $row->form_details->type }} {{ !empty($row->form_details->type) && $row->form_details->type=="Free" ? '' :'$'.$row->form_details->amount }}</small>
                                    
                                        <br>
                                        <small class="mt-5">{{ ucfirst(substr($row->form_details->title ,0,35)) }}...</small>
                                        <br>
                                   </div>
                                </div>
                            </th>
                            <td>
                                <label class="badge  mb-0 h6 text-sm">{{ $row->form_questions }}</label>
                            </td>
                            <td>
                                <label class="badge  mb-0 h6 text-sm"> 
                                    @if(!empty($row->form_responses))
                                    <a href="{{route('assessmentForm.response',['id' => encrypted_key($row->form_details->id,'encrypt'), 'user_id' => encrypted_key(Auth::user()->id,'encrypt')])}}" data-toggle="tooltip" data-original-title="{{__('View My Response')}}">
                                        {{ $row->form_responses }}
                                    </a>
                                    @else
                                    {{ $row->form_responses }}
                                    @endif
                                </label>
                            </td>
                            <td><label class="badge  mb-0 h6 text-sm">{{ $row->form_points }}</label></td>
                            <td class="text-right w-15">
                                <div class="actions"> 
                                    @if((!empty($row->form_details->type) && $row->form_details->type=="Free") || $typeview!="active")
                                    <a href="{{route('assessmentForm',encrypted_key($row->form_details->id,'encrypt'))}}" class="btn btn-sm btn-success btn-icon rounded-pill mr-1 ml-1" data-toggle="tooltip" data-original-title="{{__('View Assessment')}}">
                                        <small class="btn-inner--text ">{{__('View Assessment')}}</small>
                                    </a>
                                    @else
                                     <a href="{{route('assessmentForm',encrypted_key($row->form_details->id,'encrypt'))}}" class="btn btn-sm btn-success btn-icon rounded-pill mr-1 ml-1" data-toggle="tooltip" data-original-title="{{__('View Assessment And Make Payment')}}">
                                        <small class="btn-inner--text ">{{__('View Assessment')}}</small>
                                    </a>
                                    @endif
                                </div>
                            </td>
                            
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <th scope="col" colspan="7"><h6 class="text-center">{{__('No data found')}}</h6></th>
                    </tr>
                    @endif
                        </tbody>
                    </table>
                </div>
                
            
            
            
                
        </div>
    </div>
        <div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}
    
    </div>

