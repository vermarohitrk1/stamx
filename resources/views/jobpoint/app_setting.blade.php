@php
/**
 * @var App\Timezone $timezones
 * @var App\JobSetting $jobSettings
*/
@endphp
<?php $page = 'partner'; ?>
@extends('layout.dashboardlayout')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    <!-- Sidebar -->
                    @include('layout.partials.userSideMenu')
                    <!-- /Sidebar -->
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class=" col-md-12 ">
                    </div>
                    <!-- Breadcrumb -->
                    <div class="breadcrumb-bar mt-3">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-12 col-12">
                                    <h2 class="breadcrumb-title">Job Point</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Breadcrumb -->
                    <br>
                    <div class="row" id="blog_view">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content profile-tab-cont">
                                        <div class="card-header">
                                            <div class="jobpoint-menu">
                                                <ul class="nav nav-tabs nav-tabs-solid">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab" href="#general">General</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#email_setup">Email
                                                            Setup</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#notification">Notification</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <br><br>
                                    <div class="tab-pane fade show active" id="general">
                                        <div class="table-responsive-md">
                                            {{ Form::open(array('route' => 'app.setting.save', 'enctype' => 'multipart/form-data')) }}
                                            <h3>General</h3>
                                            <hr width="100%">
                                            <p class="text-primary">Company Info</p><br>
                                            <div class="row">
                                                <div class="col-4">Company Name</div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control" id="company_name" placeholder="company name" name="company_name" value="{{$jobSettings->loadByKey('company_name')}}">
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>Company logo</span><br>
                                                    <small class="text-muted font-italic">(Recommended size: 210 x 50 px)</small>
                                                </div>
                                                <div class="col-8">
                                                    <div class="form-group">
                                                        @php $fileName = $jobSettings->loadByKey("company_logo") @endphp
                                                        @if($fileName!="")
                                                            <img src="{{asset($jobSettings->getJobImage($fileName))}}" alt="">
                                                            <br><br>
                                                        @endif
                                                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="company_logo">
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>Company Icon</span><br>
                                                    <small class="text-muted font-italic">(Recommended size: 50 x 50 px)</small>
                                                </div>
                                                <div class="col-8">
                                                    <div class="form-group">
                                                        @php $fileName = $jobSettings->loadByKey("company_icon") @endphp
                                                        @if($fileName!="")
                                                            <img src="{{asset($jobSettings->getJobImage($fileName))}}" alt="">
                                                            <br><br>
                                                        @endif
                                                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="company_icon">
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <span>Company banner</span><br>
                                                    <small class="text-muted font-italic">(Recommended size: 1920 x 1080 px)</small>
                                                </div>
                                                <div class="col-8">
                                                    <div class="form-group">
                                                        @php $fileName = $jobSettings->loadByKey("company_banner") @endphp
                                                        @if($fileName!="")
                                                            <img src="{{asset($jobSettings->getJobImage($fileName))}}" alt="" style="max-width: 600px">
                                                            <br><br>
                                                        @endif
                                                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="company_banner">
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">Language</div>
                                                <div class="col-8">
                                                    <div class="form-group">
                                                        @php $language = $jobSettings->getSelectOptions("language"); @endphp
                                                        {{Form::select('language', $language["all_option"], $language["value"], ["class" => 'form-control'])}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">Layout</div>
                                                <div class="col-8">
                                                    @php $layout = $jobSettings->loadByKey('layout') @endphp
                                                    <div class="radio-button-group">
                                                        <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                                            <label class="btn border {{($layout=='ltr') ? 'focus active' : ''}}">
                                                                <input type="radio" name="layout" id="layout-0" value="ltr" {{($layout=='ltr') ? 'checked' : ''}}>
                                                                <span>LTR</span>
                                                            </label>
                                                            <label class="btn border {{($layout=='rtl') ? 'focus active' : ''}}">
                                                                <input type="radio" name="layout" id="layout-1" value="rtl" {{($layout=='rtl') ? 'checked' : ''}}>
                                                                <span>RTL</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><br><br>
                                            <p class="text-primary">Date and time setting</p><br>
                                            <div class="row">
                                                <div class="col-4">Date Format</div>
                                                <div class="col-8">
                                                    @php $dateFormat = $jobSettings->getSelectOptions("date_format"); @endphp
                                                    {{Form::select('date_format', $dateFormat["all_option"], $dateFormat["value"], ["class" => 'form-control'])}}
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">Time Format</div>
                                                <div class="col-8">
                                                    @php $datetimeFormat = $jobSettings->loadByKey('time_format') @endphp
                                                    <div class="radio-button-group" role="group">
                                                        <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                                            <label class="btn border {{($datetimeFormat==='h') ? 'focus active' : ''}}">
                                                                <input type="radio" name="time_format" id="time_format-0" value="h" {{($datetimeFormat==='h') ? 'checked' : ''}}>
                                                                <span>12 HOURS</span>
                                                            </label>
                                                            <label class="btn border {{($datetimeFormat==='H') ? 'focus active' : ''}}">
                                                                <input type="radio" name="time_format" id="time_format-1" value="H" {{($datetimeFormat==='H') ? 'checked' : ''}}>
                                                                <span>24 HOURS</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">Time Zone</div>
                                                <div class="col-8">
                                                    <div class="form-group">
                                                        @php $timezone = $jobSettings->getSelectOptions("timezone"); @endphp
                                                        {{Form::select('timezone', $timezone["all_option"], $timezone["value"], ["class" => 'form-control'])}}
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-primary">Currency Setting</p><br>
                                            <div class="row">
                                                <div class="col-4">Currency Symbol</div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control" placeholder="$" name="currency_symbol" value="{{$jobSettings->loadByKey("currency_symbol")}}"><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">Decimal Separator</div>
                                                <div class="col-8">
                                                    @php $decimalSeparator = $jobSettings->loadByKey('decimal_separator') @endphp
                                                    <div class="radio-button-group">
                                                        <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                                            <label class="btn border {{($decimalSeparator==='.') ? 'focus active' : ''}}">
                                                                <input type="radio" name="decimal_separator" id="decimal_separator-0" required="required" value="." {{($decimalSeparator==='.') ? 'checked' : ''}}>
                                                                <span>DOT(.)</span>
                                                            </label>
                                                            <label class="btn border {{($decimalSeparator===',') ? 'focus active' : ''}}">
                                                                <input type="radio" name="decimal_separator" id="decimal_separator-1" required="required" value="," {{($decimalSeparator===',') ? 'checked' : ''}}>
                                                                <span>COMMA(,)</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br><br>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">Thousand separator</div>
                                                <div class="col-8">
                                                    @php $thousandSeparator = $jobSettings->loadByKey('thousand_separator') @endphp
                                                    <div class="radio-button-group">
                                                        <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                                            <label class="btn border {{($thousandSeparator==='.') ? 'focus active' : ''}}">
                                                                <input type="radio" name="thousand_separator" id="thousand_separator-0" required="required" value="." {{($thousandSeparator==='.') ? 'checked' : ''}}>
                                                                <span>DOT(.)</span>
                                                            </label>
                                                            <label class="btn border {{($thousandSeparator===',') ? 'focus active' : ''}}">
                                                                <input type="radio" name="thousand_separator" id="thousand_separator-1" required="required" value="," {{($thousandSeparator===',') ? 'checked' : ''}}>
                                                                <span>COMMA(,)</span>
                                                            </label>
                                                            <label class="btn border  {{($thousandSeparator===' ') ? 'focus active' : 'space'}}">
                                                                <input type="radio" name="thousand_separator" id="thousand_separator-2" required="required" value="space" {{($thousandSeparator==='space') ? 'checked' : ''}}>
                                                                <span>Space</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br><br>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">Number of decimal</div>
                                                <div class="col-8">
                                                    @php $numberOfDecimal = $jobSettings->loadByKey('number_of_decimal') @endphp
                                                    <div class="radio-button-group">
                                                        <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                                            <label class="btn border {{($numberOfDecimal==='0') ? 'focus active' : ''}}">
                                                                <input type="radio" name="number_of_decimal" id="number_of_decimal-0" required="required" value="0" {{($numberOfDecimal==='0') ? 'checked' : ''}}>
                                                                <span>ZERO (0)</span>
                                                            </label>
                                                            <label class="btn border {{($numberOfDecimal==='2') ? 'focus active' : ''}}">
                                                                <input type="radio" name="number_of_decimal" id="number_of_decimal-1" required="required" value="2" {{($numberOfDecimal==='2') ? 'checked' : ''}}>
                                                                <span>TWO (2)</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">Currency position</div>
                                                <div class="col-8">
                                                    @php $currencyPosition = $jobSettings->loadByKey('currency_position') @endphp
                                                    <div class="radio-button-group">
                                                        <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                                            <label class="btn border {{($currencyPosition==='prefix_only') ? 'focus active' : ''}}">
                                                                <input type="radio" name="currency_position" id="currency_position-0" required="required" value="prefix_only" {{($currencyPosition==='prefix_only') ? 'checked' : ''}}>
                                                                <span>$1,100.00</span>
                                                            </label>
                                                            <label class="btn border {{($currencyPosition==='prefix_with_space') ? 'focus active' : ''}}">
                                                                <input type="radio" name="currency_position" id="currency_position-1" required="required" value="prefix_with_space" {{($currencyPosition==='prefix_with_space') ? 'checked' : ''}}>
                                                                <span>$ 1,100.00</span>
                                                            </label>
                                                            <label class="btn border {{($currencyPosition==='suffix_only') ? 'focus active' : ''}}">
                                                                <input type="radio" name="currency_position" id="currency_position-2" required="required" value="suffix_only" {{($currencyPosition==='suffix_only') ? 'checked' : ''}}>
                                                                <span>1,100.00$</span>
                                                            </label>
                                                            <label class="btn border {{($currencyPosition==='suffix_with_space') ? 'focus active' : ''}}">
                                                                <input type="radio" name="currency_position" id="currency_position-2" required="required" value="suffix_with_space" {{($currencyPosition==='suffix_with_space') ? 'checked' : ''}}>
                                                                <span>1,100.00 $</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                </div>
                                            </div>
                                            {{Form::submit('Save', ["class" => "btn btn-primary"])}}
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                    <!-- Change email_setup Tab -->
                                    <div id="email_setup" class="tab-pane fade">
                                        <div class="card">
                                            <div class="card-body">
                                                {{ Form::open(array('route' => 'app.setting.save')) }}
                                                <h3>Email Setup</h3>
                                                <hr width="100%">
                                                <div class="row">
                                                    <div class="col-4">Supported mail services</div>
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            @php $emailService = $jobSettings->getSelectOptions("email_service"); @endphp
                                                            {{Form::select('email_service', $emailService["all_option"], $emailService["value"], ["class" => 'form-control'])}}
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">Email sent from name</div>
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="email_name" name="email_name" placeholder="Enter email sent from name" value="{{$jobSettings->loadByKey("email_name")}}">
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">Email sent from email</div>
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="email_from" name="email_from" placeholder="Enter Email sent from email" value="{{$jobSettings->loadByKey("email_name")}}">
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{Form::submit('Save', ["class" => "btn btn-primary"])}}
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                    {{-- change notification Tab --}}
                                    <div id="notification" class="tab-pane fade">
                                        <div class="card">
                                            <div class="card-body">
                                                <h3>Notification</h3>
                                                <hr width="100%">
                                            </div>
                                            <div class="col-12">
                                                <table class="table table-hover table-center mb-0 table-100" id="yajra-datatable">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Event Name</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($jobNotification as $_jobNotification)
                                                            <tr>
                                                                <td>{{ $_jobNotification->event_name }}</td>
                                                                <td>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" class="custom-control-input" id="switch_{{$_jobNotification->id}}" data-id="{{$_jobNotification->id}}" {{ $_jobNotification->status ? 'checked' : '' }}>
                                                                        <label class="custom-control-label" for="switch_{{$_jobNotification->id}}">Enable</label>

                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/simcify.min.js') }}"></script>

    <script>
        $(function() {
            $('.custom-control-input').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var job_notification_id = $(this).data('id');
                console.log(status);
                console.log(job_notification_id);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('change.jobnotification.status') }}',
                    data: {'status': status, 'id': job_notification_id},
                    success: function(response){
                        if(response.success == true){
                            show_toastr('Success :', response.message, 'success')
                        }else{
                            show_toastr('Error : ', response.message, 'error');
                        }
                    },
                    error: function (error) {
                        show_toastr('Error: ', response.message, 'error');
                    }
                });
            })
        })
    </script>

@endpush
