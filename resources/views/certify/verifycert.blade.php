@extends('layouts.auth')
@section('content')
    <div class="col-sm-8 col-lg-4">
        <div class="text-center pb-4">
            <img src="{{ asset(Storage::url('logo/logo.png')) }}" class="w200">
        </div>
        <div class="card shadow zindex-100 mb-0">
            <div class="card-body px-md-5 py-5">
                <div class="mb-4">
                    <h6 class="h3">{{__('Verify Cert')}}</h6>
                    <p class="text-muted mb-0">{{__('Verify a certificate by entering the 6 digit Cert Code on the certificate. Or call ')}}
                        <strong class="text-primary">{{mobileNumberFormat(env('CERTIFICATE_TWILIO_NUMBER'))}}</strong></p>
                </div>
                <span class="clearfix"></span>
                <form method="POST" action="{{ route('verify.cert.post') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-control-label">{{__('Certificate Code')}}</label>
                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div>
                            <input id="email" type="number" class="form-control" name="cert_code" value="" required
                                   autofocus/>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-sm btn-primary btn-icon rounded-pill">
                            <span class="btn-inner--text">{{__('Verify Now')}}</span>
                            <span class="btn-inner--icon"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
