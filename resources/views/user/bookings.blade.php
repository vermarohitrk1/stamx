<?php $page = "book"; ?>
@extends('layout.dashboardlayout')
@section('content')		


<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                @include('layout.partials.userSideMenu')
            </div>
            <!-- /Sidebar -->

            <!-- Booking summary -->
            <div class="col-md-7 col-lg-8 col-xl-9">
                <!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Booking Summary</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Bookings</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->
                <!-- Mentee List Tab -->
                <div class="tab-pane show active" id="mentee-list">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>MENTEE LISTS</th>
                                            <th>SCHEDULED DATE</th>
                                            <th class="text-center">SCHEDULED TIMINGS</th>
                                            <th class="text-center">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user2.jpg" alt="User Image"></a>
                                                    <a href="profile">Tyrone Roberts<span>tyroneroberts@adobe.com</span></a>				
                                                </h2>
                                            </td>
                                            <td>08 April 2020</td>
                                            <td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
                                            <td class="text-center"><a href="profile" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user1.jpg" alt="User Image"></a>
                                                    <a href="profile">Julie Pennington <span>julie@adobe.com</span></a>				
                                                </h2>
                                            </td>
                                            <td>08 April 2020</td>
                                            <td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
                                            <td class="text-center"><a href="profile" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user3.jpg" alt="User Image"></a>
                                                    <a href="profile">Allen Davis <span>allendavis@adobe.com</span></a>				
                                                </h2>
                                            </td>
                                            <td>07 April 2020</td>
                                            <td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
                                            <td class="text-center"><a href="profile" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user4.jpg" alt="User Image"></a>
                                                    <a href="profile">Patricia Manzi <span>patriciamanzi@adobe.com</span></a>				
                                                </h2>
                                            </td>
                                            <td>07 April 2020</td>
                                            <td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
                                            <td class="text-center"><a href="profile" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user5.jpg" alt="User Image"></a>
                                                    <a href="profile">Olive Lawrence <span>olivelawrence@adobe.com</span></a>				
                                                </h2>
                                            </td>
                                            <td>06 April 2020</td>
                                            <td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
                                            <td class="text-center"><a href="profile" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user6.jpg" alt="User Image"></a>
                                                    <a href="profile">Frances Foster <span>frances@adobe.com</span></a>				
                                                </h2>
                                            </td>
                                            <td>06 April 2020</td>
                                            <td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
                                            <td class="text-center"><a href="profile" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user7.jpg" alt="User Image"></a>
                                                    <a href="profile">Deloris Briscoe <span>delorisbriscoe@adobe.com</span></a>				
                                                </h2>
                                            </td>
                                            <td>05 April 2020</td>
                                            <td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
                                            <td class="text-center"><a href="profile" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user2.jpg" alt="User Image"></a>
                                                    <a href="profile">Tyrone Roberts<span>tyroneroberts@adobe.com</span></a>				
                                                </h2>
                                            </td>
                                            <td>08 April 2020</td>
                                            <td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
                                            <td class="text-center"><a href="profile" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user1.jpg" alt="User Image"></a>
                                                    <a href="profile">Julie Pennington <span>julie@adobe.com</span></a>				
                                                </h2>
                                            </td>
                                            <td>08 April 2020</td>
                                            <td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
                                            <td class="text-center"><a href="profile" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
                                        </tr>
                                    </tbody>
                                </table>		
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Mentee List Tab -->
            </div>
            <!-- /Booking summary -->

        </div>

    </div>
</div>		
<!-- /Page Content -->
@endsection