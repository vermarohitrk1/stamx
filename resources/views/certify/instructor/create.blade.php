<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
{{ Form::open(['route' => ['instructor.store'],'id' => 'create_instructor','enctype' => 'multipart/form-data']) }}

    <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
    
    
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Please select an user for instructor</label>
                <select name="instructor" class="form-control" required>
				  @php
                    $domain_user=get_domain_user();
                    $users=\App\User::where('id',$domain_user->id)->Orwhere('id',Auth::user()->id)->get();
                    @endphp
                    
                    @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name." (".$user->type.")"}}</option>
                    @endforeach
				
                </select>
            </div>
            
        </div>
    </div>

    

    

</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}

<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
