
@extends('layout.mainlayout_admin')
@section('content')		
<!-- Page Wrapper --> 
<style>
    .certifydiv {
    width: 150px;
}
.col-4.invoicedata {
    padding-left: 0px!important;
}
</style>
<div class="page-wrapper">
    <div class="content container-fluid"> 
        <div class="row">
            <div class="col-lg-5 col-sm-12">
                <div class="card">
                    <div class="bg-soft-primary">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="mb-3">Mentoring Panel</p>
                                </div>
                            </div>
                            <div class="align-self-end col-5"><img src="../assets_admin/img/profile-img.png" alt="" class="img-fluid"></div>
                        </div>
                    </div>
                    <div class="pt-0 card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user mb-4"><img src="../assets_admin/img/profiles/avatar-05.jpg" alt="" class="img-thumbnail rounded-circle img-fluid"></div>
                                <div class="d-block">
                                @php
                                $school = \App\Institution::where('type','school')->count();
                                @endphp
                                    <h5 class="text-truncate">{{ $school }}</h5>
                                    <p class="text-muted mb-0  text-truncate">School</p>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="pt-4">
                                    <div class="row">
                                        <div class="col-6">
                                        @php
                                $college = \App\Institution::where('type','college')->count();
                                @endphp
                                            <h5 class="font-size-15">{{ $college }}</h5>
                                            <p class="text-muted mb-0">College</p>
                                        </div>
                                        <div class="col-6">
                                        @php
                                $company = \App\Employer::count();
                                @endphp
                                            <h5 class="font-size-15">{{ $company }} </h5>
                                            <p class="text-muted mb-0">Company</p>
                                        </div>
                                    </div>
                                    <div class="mt-4"><a class="btn btn-primary waves-effect waves-light btn-sm" href="admin/profile">View Profile <i class="mdi mdi-arrow-right ml-1"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Invoice Analytics</h5>
                            <div class="dropdown d-none" data-toggle="dropdown">
                                <a href="javascript:void(0);" class="btn btn-white btn-sm dropdown-toggle" role="button" data-toggle="dropdown">
                                    Monthly
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0);" class="dropdown-item">Weekly</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Monthly</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Yearly</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="invoice_chart"></div>
                        <div class="text-center text-muted">
                            <div class="row">
                            @php
                             $user=Auth::user();
                            @endphp
                
                                <div class="col-4 invoicedata">
                                    <div class="mt-4">
                                        <p class="mb-2 text-truncate"><i class="fas fa-circle text-primary mr-1"></i>Total Invoices</p>
                                        @php
                                $invoices = \App\UserPayment::where('paid_to_user_id',$user->id)->orwhere('user_id',$user->id)->count();
                                @endphp
                                        <h5>$ {{!empty($invoices)?$invoices:0}}</h5>
                                    </div>
                                </div>
                                <div class="col-4 invoicedata">
                                    <div class="mt-4">
                                        <p class="mb-2 text-truncate"><i class="fas fa-circle text-success mr-1"></i>Total Paid</p>
                                        @php
                                $totalpaid = \App\UserPayment::where('user_id',$user->id)->sum('amount');
                                @endphp
                                        <h5>{{format_price(!empty($totalpaid)?$totalpaid:0)}}</h5>
                                    </div>
                                </div>
                                <div class="col-4 invoicedata">
                                    <div class="mt-4">
                                        <p class="mb-2 text-truncate"><i class="fas fa-circle text-danger mr-1"></i>Total Earned</p>
                                        @php
                                $earned = \App\UserPayment::where('paid_to_user_id',$user->id)->sum('amount');
                                @endphp
                                        <h5>{{format_price(!empty($earned)?$earned:0)}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-sm-12">
                <div class="row">
                    <div class="col-xl-4 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-primary bg-primary-light">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{$members}}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Members</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary w-50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-success bg-success-light">
                                        <i class="fas fa-credit-card"></i>
                                    </span>
                                    <div class="dash-count">
                                        <h3>{{$bookings}}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Appointments</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success w-50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-warning bg-warning-light">
                                        <i class="fas fa-star"></i>
                                    </span>
                                    <div class="dash-count">
                                    @php
                                $photobooth = \App\Photobooth::where('status','Active')->count();
                                @endphp
                                        <h3>{{ $photobooth }}</h3>
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Photobooth</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning w-50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Photobooth shares</h5>
                          
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap">
                            <div class="w-md-100 d-flex align-items-center mb-3 chart-content">
                              
                                <div  class="certifydiv">
                                    <span>Facebook</span>
                                    <p class="h3 text-success mr-5">  @php
                                echo $photobooth = \App\Photoboothsharecount::count();
                                @endphp</p>
                                </div>
                                <div  class="certifydiv">
                                    <span>Twitter</span>
                                    <p class="h3 text-danger mr-5">0</p>
                                </div>
                              
                            </div>
                        </div>
                        <div id="sales_chart"></div>
                    </div>
                </div>
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Certify</h5>
                            <div class="dropdown d-none" data-toggle="dropdown">
                                <a href="javascript:void(0);" class="btn btn-white btn-sm dropdown-toggle" role="button" data-toggle="dropdown">
                                    Monthly
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0);" class="dropdown-item">Weekly</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Monthly</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Yearly</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap">
                            <div class="w-md-100 d-flex align-items-center mb-3 chart-content">
                                <div class="certifydiv">
                                    <span>Certify</span>
                                    <p class="h3 text-primary mr-5">{{ $CertifiesCount }}</p>
                                </div>
                                <div  class="certifydiv">
                                    <span>Students</span>
                                    <p class="h3 text-success mr-5">{{ $student }}</p>
                                </div>
                                <div  class="certifydiv">
                                    <span>Income</span>
                                    <p class="h3 text-danger mr-5">${{ $income }}</p>
                                </div>
                                <div  class="certifydiv">
                                    <span>Incomplete</span>
                                    <p class="h3 text-dark mr-5">{{ $incomplete }}</p>
                                </div>
                            </div>
                        </div>
                        <div id="sales_chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 d-flex">

                <!-- Recent Orders -->
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h4 class="card-title">Latest Mentor List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Mentor Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>State</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($mentors->isEmpty())
                                    <tr>
                                        <td>  Nothing to show </td></tr>
                                    @endif
                                    @foreach($mentors as $mentor)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <!-- <a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/profiles/avatar-08.jpg" alt="User Image"></a> -->
                                                <a href="profile">{{ucfirst($mentor->name)}}</a>
                                            </h2>
                                        </td>
                                        <td>{{ $mentor->email }}</td>
                                        <td>{{ $mentor->mobile }}</td>
                                        <td>
                                        {{ $mentor->state }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->

            </div>
            <div class="col-md-6 d-flex">

                <!-- Feed Activity -->
                <div class="card  card-table flex-fill">
                    <div class="card-header">
                        <h4 class="card-title">Latest Mentee List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                    <th>Mentor Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>State</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($mentees->isEmpty())
                                    <tr>
                                        <td>  Nothing to show </td></tr>
                                    @endif
                                @foreach($mentees as $mentor)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <!-- <a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/profiles/avatar-08.jpg" alt="User Image"></a> -->
                                                <a href="profile">{{ucfirst($mentor->name)}}</a>
                                            </h2>
                                        </td>
                                        <td>{{ $mentor->email }}</td>
                                        <td>{{ $mentor->mobile }}</td>
                                        <td>
                                        {{ $mentor->state }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Feed Activity -->

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <!-- Recent Orders -->
                <div class="card card-table">
                    <div class="card-header">
                        <h4 class="card-title">Booking List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Service Type</th>
                                        <th>Status </th>
                                        <th>Price</th>
                                        <th>Time slots</th>
                                     
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($meeting_schedules as $meeting_schedule)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile">{{ $meeting_schedule->title }}</a>
                                            </h2>
                                        </td>
                                        <td>
                                           <?php
                                               if($meeting_schedule->service_type_id==2){
                                                $course= \App\Certify::find($meeting_schedule->service_id);
                                                $course_name=$course->name??'Unknown';
                                                $res= '<div class="actions ">
                                                                       <a class="btn btn-sm bg-warning-light" data-title="General Consultancy " href="'.route("course.details",encrypted_key($meeting_schedule->service_id,'encrypt')).'">
                                                                           Course Consultancy - '.substr($course_name,0,10).'..
                                                                       </a>
                                                                   </div>';
                                            }else{
                                               $res= \App\MeetingSchedule::getServiceType($meeting_schedule->service_type_id);
                                            }
                                         echo $res; ?>
                                        </td>
                                        <td>
                                        {{ $meeting_schedule->status }}
                                        </td>
                                        <td class="text-right">
                                        {{ format_price($meeting_schedule->price) }}
                                        </td>
                                        <td>


                                        <?php
                                        $date=date('Y-m-d');
                                        $endtime=date('H:i:s');
                                    $authuser = Auth::user();
                                    
                                     $booked= \App\MeetingScheduleSlot::where('meeting_schedule_id', $meeting_schedule->id)->where('user_id','!=', null)->count();
                                    
                 $available= \App\MeetingScheduleSlot::where('meeting_schedule_id', $meeting_schedule->id)->where('user_id', null)->where('date','>=', $date)->count();
                
                                     $skipped= \App\MeetingScheduleSlot::where('meeting_schedule_id', $meeting_schedule->id)->where('user_id', null)->where('date','<', $date)->count();
                                     
                
                                 $slots= '<span class="badge  badge-xs bg-success-light">Available: '.$available.'</span>';
                                 $slots .= '<br><span class="badge  badge-xs bg-primary-light">Bookings: '.$booked.'</span>';
                                 $slots .= '<br><span class="badge badge-xs bg-danger-light">Skipped: '.$skipped.'</span>';
                                 echo $slots; ?>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->

            </div>
        </div>
    </div>
</div>
<!-- /Page Wrapper -->

</div>
<!-- /Main Wrapper -->
@endsection
