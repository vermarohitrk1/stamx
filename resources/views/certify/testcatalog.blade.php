@extends('layouts.admin')
@section('title')
    {{"Test Catalog"}}
@endsection
@push('css')
    
@endpush

@push('theme-script')
    <script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>
@endpush
@section('action-button')
    <a href="{{ route('certify.index') }}" class="btn btn-sm btn-white btn-icon-only rounded-circle ml-2" >
    <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
</a>
@endsection
@section('content')
    <div class="row">
        <div class=" col-md-8">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <form action="{{route('certify.testemailcatalog')}}" method="POST"
                                      id="uploadCertificatreText">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-control-label">Email</label>
					  
                                            <input type="email" name="email" class="form-control mt-1" placeholder="Enter Email"
                                                          required />
                                           
                                        </div>
                                        <div class="col-md-6 ">
                                        {{ Form::button(__('Send Test Email'), ['type' => 'submit','class' => 'mt-5 btn btn-sm btn-primary rounded-pill text_sev']) }}
                                    </div>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

