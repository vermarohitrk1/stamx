<?php $page = "blog"; ?>
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
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Blog</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->
                <div class="row">

                    <div class="col-12">

                        <!-- Tab Menu -->
                        <nav class="user-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                                <li>
                                    <a class="nav-link active" href="#activeservice" data-toggle="tab">Active Blog</a>
                                </li>
                                <li>
                                    <a class="nav-link" href="#inactiveservice" data-toggle="tab">Inactive Blog</a>
                                </li>
                            </ul>
                        </nav>
                        <!-- /Tab Menu -->

                        <!-- Tab Content -->
                        <div class="tab-content">

                            <!-- Active Content -->
                            <div role="tabpanel" id="activeservice" class="tab-pane fade show active">

                                <div class="row">
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-01.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part I</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success"><i class="far fa-edit"></i> Edit</a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-danger">
                                                            <i class="far fa-trash-alt"></i> Inactive
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-02.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part II</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success"><i class="far fa-edit"></i> Edit</a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-danger">
                                                            <i class="far fa-trash-alt"></i> Inactive
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-03.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part III</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success"><i class="far fa-edit"></i> Edit</a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-danger">
                                                            <i class="far fa-trash-alt"></i> Inactive
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-04.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part I</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success"><i class="far fa-edit"></i> Edit</a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-danger">
                                                            <i class="far fa-trash-alt"></i> Inactive
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-05.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part II</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success"><i class="far fa-edit"></i> Edit</a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-danger">
                                                            <i class="far fa-trash-alt"></i> Inactive
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-06.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part III</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success"><i class="far fa-edit"></i> Edit</a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-danger">
                                                            <i class="far fa-trash-alt"></i> Inactive
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /Active Content -->

                            <!-- Inactive Content -->
                            <div role="tabpanel" id="inactiveservice" class="tab-pane fade">

                                <div class="row">
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-04.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part III</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success">
                                                            <i class="far fa-edit"></i> Edit
                                                        </a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-success">
                                                            <i class="fas fa-toggle-on"></i> Active
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-05.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part III</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success">
                                                            <i class="far fa-edit"></i> Edit
                                                        </a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-success">
                                                            <i class="fas fa-toggle-on"></i> Active
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-06.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part III</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success">
                                                            <i class="far fa-edit"></i> Edit
                                                        </a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-success">
                                                            <i class="fas fa-toggle-on"></i> Active
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-07.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part III</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success">
                                                            <i class="far fa-edit"></i> Edit
                                                        </a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-success">
                                                            <i class="fas fa-toggle-on"></i> Active
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-08.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part III</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success">
                                                            <i class="far fa-edit"></i> Edit
                                                        </a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-success">
                                                            <i class="fas fa-toggle-on"></i> Active
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="course-box blog grid-blog">
                                            <div class="blog-image mb-0">
                                                <a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-09.jpg" alt="Post Image"></a>
                                            </div>
                                            <div class="course-content">
                                                <span class="date">April 09 2020</span>
                                                <span class="course-title">Abacus Study for beginner - Part III</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="edit-blog" class="text-success">
                                                            <i class="far fa-edit"></i> Edit
                                                        </a>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="javascript:void(0);" class="text-success">
                                                            <i class="fas fa-toggle-on"></i> Active
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /Inactive Content -->

                        </div>
                        <!-- /Tab Content -->


                    </div>


                </div>

            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection