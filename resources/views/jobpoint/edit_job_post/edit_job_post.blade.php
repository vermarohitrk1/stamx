@php
    /**
     * @var \App\Job $job
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
                    <div class=" col-md-12 "></div>
                    <!-- Breadcrumb -->
                    <div class="breadcrumb-bar mt-3">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-12 col-12">
                                    <div class="float-left">
                                        <a href="javascript:void(0)" class="desktop-view">
                                            <i class="fas fa-desktop mr-2"></i>
                                            <span class="mr-2">{{__("Desktop")}}</span>
                                        </a>
                                        <a href="javascript:void(0)" class="mobile-view">
                                            <i class="fas fa-mobile-alt mr-2"></i>
                                            <span>{{__("Mobile")}}</span>
                                        </a>
                                    </div>
                                    <div class="float-right">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-maximize-2 size-20 mr-2 mr-md-0 pr-2">
                                                <polyline points="15 3 21 3 21 9"></polyline>
                                                <polyline points="9 21 3 21 3 15"></polyline>
                                                <line x1="21" y1="3" x2="14" y2="10"></line>
                                                <line x1="3" y1="21" x2="10" y2="14"></line>
                                            </svg>
                                        <a href="{{route('job.preview', [encrypted_key($job->id, "encrypt")])}}" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-eye size-20 mr-2 mr-md-0  pr-2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </a>
                                        <button type="button" class="btn btn-primary btn-sm save_job_content">{{__("Save Changes")}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8 mt-4 shadow bg-light">
                                    <div class="mode_view col-12 bg-white m-auto pt-3 pb-3">
                                        <div class="rounded-circle text-center job_logo">
                                            <img src="{{asset($job->getJobPostLogo())}}" alt="">
                                        </div>
                                        <div class="main_job_content">
                                            @if($jobPost = $job->getJobPost)
                                                {!! $jobPost->content !!}
                                            @else
                                                <div class="job_header">
                                                    <h1 class="text-center mt-3 title" id="title">
                                                        <div class="time-picker-input mb-4 html_input_field">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="Job Title" name="title">
                                                                <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                                                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                                                <polyline points="7 3 7 8 15 8"></polyline>
                                                            </svg>
                                                        </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="jobtitle html_content">Job Title</span>
                                                    </h1>
                                                    <h4 class="text-center text-secondary subtitle" >
                                                        <div class="time-picker-input mb-4 html_input_field">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="Job subtitle or short description" name="subtitle">
                                                                <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                                                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                                                <polyline points="7 3 7 8 15 8"></polyline>
                                                            </svg>
                                                        </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="jobSubtitle html_content">Job subtitle or short description</span>
                                                    </h4>
                                                    <h5 class="text-center text-primary location">
                                                        <div class="time-picker-input mb-4 html_input_field">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="Job type-Location" name="details">
                                                                <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                                                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                                                <polyline points="7 3 7 8 15 8"></polyline>
                                                            </svg>
                                                        </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="jobLocation html_content">Job type-Location</span>
                                                    </h5>
                                                </div>
                                                <div class="rightIconBar float-right mt-3">
                                                    <div class="icon">
                                                        <i class="fas fa-plus appendDescription"></i>
                                                        <i class="far fa-edit pl-2 pr-2 editButton"></i>
                                                        <i class="fas fa-check updateDescription"></i>
                                                    </div>
                                                </div>
                                                <div class="content mt-3 job_description job_content_body">
                                                    <div class="each_description">
                                                        <div class="each_description_input">
                                                            <div class="input-group">
                                                                <input type="text" value="About Job" class="form-control input_heading" name="descriptoin_header_1">
                                                                <div class="input-group-append bg-success pl-3 pr-3 p-2 ml-2 rounded">
                                                                    <i class="fas fa-trash-alt mt-2"></i>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea type="text" class="form-control rounded-0 textarea_content" name="descriptoin_content_1" rows="15" col="10">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="each_description_content">
                                                            <h2 class="description_heading">About Job</h2>
                                                            <p class="description_content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                                        </div>
                                                    </div>
                                                    <div class="each_description">
                                                        <div class="each_description_input">
                                                            <div class="input-group">
                                                                <input type="text" value="About Employee" class="form-control input_heading" name="descriptoin_header_2">
                                                                <div class="input-group-append bg-success pl-3 pr-3 p-2 ml-2 rounded">
                                                                    <i class="fas fa-trash-alt mt-2"></i>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea type="text" class="form-control rounded-0 textarea_content" name="descriptoin_content_2" rows="15" col="10">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="each_description_content">
                                                            <h2 class="description_heading">About Employee</h2>
                                                            <p class="description_content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                                        </div>
                                                    </div>
                                                    <div class="each_description">
                                                        <div class="each_description_input">
                                                            <div class="input-group">
                                                                <input type="text" value="About requirement" class="form-control input_heading" name="descriptoin_header_3">
                                                                <div class="input-group-append bg-success pl-3 pr-3 p-2 ml-2 rounded">
                                                                    <i class="fas fa-trash-alt mt-2"></i>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea type="text" class="form-control rounded-0 textarea_content" name="descriptoin_content_3" rows="15" col="10">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="each_description_content">
                                                            <h2 class="description_heading">About requirement</h2>
                                                            <p class="description_content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                                        </div>
                                                    </div>
                                                    <div class="each_description">
                                                        <div class="each_description_input">
                                                            <div class="input-group">
                                                                <input type="text" value="Extended Heading" class="form-control input_heading" name="descriptoin_header_4">
                                                                <div class="input-group-append bg-success pl-3 pr-3 p-2 ml-2 rounded remove_description">
                                                                    <i class="fas fa-trash-alt mt-2"></i>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea type="text" class="form-control rounded-0 textarea_content" name="descriptoin_content_4" rows="15" col="10">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="each_description_content">
                                                            <h2 class="description_heading">Extended Heading</h2>
                                                            <p class="description_content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="footer bg-light p-5 mb-5">
                                            <span style="font-size:25px">Apply for the post Job Title</span>
                                            <button class="btn btn-outline-primary btn-sm rounded-pill float-right">
                                                Apply Now
                                            </button>
                                        </div>
                                        <div class="rounded-circle text-center job_logo mb-4">
                                            <img src="{{asset($job->getJobPostLogo())}}" alt="">
                                        </div>
                                        <div class="text-center mb-5 job_post_footer">
                                            <span>Copyright @ 2021 by Jobpoint</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 offset-sm-1">
                                    <div class="shadow bg-white p-2">
                                        <h4>Page Styling</h4>
                                        @foreach($job->getPageStylingData() as $style)
                                            <div class="dropdown">
                                                <button class="btn btn-light labelButton" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{__($style["label"])}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <div class="row">
                                                        <div class="col-sm-6 float-left">
                                                            <label for="{{$style["font_size_class"]}}" class="pl-2">{{__("Font size")}}</label>
                                                        </div>
                                                        <div class="col-sm-6 float-right pr-4">
                                                            <input type="number" id="{{$style["font_size_class"]}}" class="form-control {{$style["font_size_class"]}}" value="{{$style["font_size_value"]}}"><br>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 float-left">
                                                            <label for="{{$style["font_weight_class"]}}" class="pl-2">{{__("Font weight")}}</label>
                                                        </div>
                                                        <div class="col-sm-6 float-right pr-4">
                                                            <input type="number" id="{{$style["font_weight_class"]}}" class="form-control {{$style["font_weight_class"]}}" value="{{$style["font_weight_value"]}}">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6 float-left">
                                                            <label for="{{$style["font_letter_spacing_class"]}}" class="pl-2">{{__("Letter spacing")}}</label>
                                                        </div>
                                                        <div class="col-sm-6 float-right pr-4">
                                                            <input type="number" id="{{$style["font_letter_spacing_class"]}}" class="form-control {{$style["font_letter_spacing_class"]}}" value="{{$style["font_letter_spacing_value"]}}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 float-left">
                                                            <label for="{{$style["font_color_class"]}}" class="pl-2">{{__("Color")}}</label>
                                                        </div>
                                                        <div class="col-sm-6 float-right pr-4">
                                                            <input type="color" id="{{$style["font_color_class"]}}" class="form-control {{$style["font_color_class"]}}" value="{{$style["font_color_value"]}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="pageBlocks">
                                            <h4 class='mt-2'>{{__("Page Blocks")}}</h4>
                                            <div class="row mt-2 bg-light p-2 ml-1 mr-1  border rounded">
                                                <div class="col-sm-5">
                                                    <div class="status-toggle">
                                                        <input type="checkbox" id="status_1" class="check hideheadr" checked="">
                                                        <label for="status_1" class="checktoggle">checkbox</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <span>{{__("Header")}}</span>
                                                </div>
                                            </div>
                                            <div class="row bg-light p-2 ml-1 mr-1  border rounded">
                                                <div class="col-sm-5">
                                                    <div class="status-toggle">
                                                        <input type="checkbox" id="status_2" class="check hideBody" checked>
                                                        <label for="status_2" class="checktoggle">checkbox</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <span>{{__("Body")}}</span>
                                                </div>
                                            </div>
                                            <div class="row bg-light p-2 ml-1 mr-1  border rounded">
                                                <div class="col-sm-5">
                                                    <div class="status-toggle">
                                                        <input type="checkbox" id="status_3" class="check hideFooter" checked="">
                                                        <label for="status_3" class="checktoggle">checkbox</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <span>{{__("Footer")}}</span>
                                                </div>
                                            </div>
                                            <div class="row bg-light p-2 ml-1 mr-1  border rounded">
                                                <div class="col-sm-5">
                                                    <div class="status-toggle">
                                                        <input type="checkbox" id="status_4" class="check hideLogo" checked="">
                                                        <label for="status_4" class="checktoggle">{{__("Checkbox")}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <span>{{__("Logo")}}</span>
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
    <div class="blank_html">
        <div class="each_description">
            <div class="each_description_input">
                <div class="input-group">
                    <input type="text" value="" class="form-control input_heading" name="descriptoin_header_4">
                    <div class="input-group-append bg-success pl-3 pr-3 p-2 ml-2 rounded remove_description">
                        <i class="fas fa-trash-alt mt-2"></i>
                    </div>
                </div>
                <div class="form-group">
                    <textarea type="text" class="form-control rounded-0 textarea_content" name="descriptoin_content_4" rows="15" col="10"></textarea>
                </div>
            </div>
            <div class="each_description_content">
                <h2 class="description_heading"></h2>
                <p class="description_content"></p>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".job_description, .rightIconBar").mouseover(function () {
                $(".rightIconBar .icon").show();
            });
            $(".job_description, .rightIconBar").mouseleave(function () {
                $(".rightIconBar .icon").hide();
            });
            $(document).on("click", '.html_content', function () {
                $(this).hide();
                $(this).prev().show();
            });
            $(document).on("click", '.html_input_field .input-group-append', function () {
                var htmlContent = $(this).closest(".html_input_field").find('input').val();
                $(this).closest(".html_input_field").find('input').attr("value", htmlContent);
                $(this).parent().parent().next(".html_content").html(htmlContent);
                $(this).parent().parent().hide();
                $(this).parent().parent().next(".html_content").show();
            });

            $(document).on("click", '.editButton', function () {
                $(".each_description_input").show();
                $(".each_description_content").hide();
            });

            $(document).on("click", ".updateDescription", function () {
                $(".each_description_input").each(function (index, element) {
                    var inputHeading = $(this).closest(".each_description").find('input.input_heading').val();
                    var textareaContent = $(this).closest(".each_description").find('textarea.textarea_content').val();
                    $(this).closest(".each_description").find('.each_description_content .description_heading').html(inputHeading);
                    $(this).closest(".each_description").find('.each_description_content .description_content').html(textareaContent);
                    $(this).hide();
                    $(this).next(".each_description_content").show();
                });
            });

            $(document).on("click", ".remove_description", function () {
                $(this).closest(".each_description").remove();
            });

            $(document).on("click", ".appendDescription", function () {
                var html = $(".blank_html").html();
                $(".job_description").append(html);
            });

            $(document).on("click", ".mobile-view", function () {
                $(".mode_view").removeClass("col-12");
                $(".mode_view").addClass("col-6");
            });

            $(document).on("click", ".desktop-view", function () {
                $(".mode_view").removeClass("col-6");
                $(".mode_view").addClass("col-12");
            });
            $(document).on("click", ".save_job_content", function () {
                var finalHtml = $(".main_job_content").html();
                $.ajax({
                    url: "{{ route('jobpost.save') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "job_id": '{{$job->id}}',
                        "content": finalHtml
                    },
                    showLoader: true,
                    success: function (response) {
                        if(response.success==true){
                            show_toastr("Success", response.message, "success");
                        }
                        else{
                            show_toastr("Error", response.message, "error");
                        }
                    }
                });
            });
            //title attribute
            $(".titleFontSize").change(function(){
                var fontSize = $(".titleFontSize").val();
                $(".jobtitle").css({"font-size":fontSize+"px"});
            });

            $('.titleFontWeight').change(function(){
                var fontWeight = $(".titleFontWeight").val();
                $(".jobtitle").css({"font-weight":fontWeight});
            });

            $('.titleFontLetterSpacing').change(function(){
                var letterSpacing = $(".titleFontLetterSpacing").val();
                $(".jobtitle").css({"letter-spacing":letterSpacing+"px"});
            });

            $('.titleFontColor').change(function(){
                var color = $(".titleFontColor").val();
                $(".jobtitle").css({"color":color});
            });

            //subtitle attribute
            $(".subtitleFontSize").change(function(){
                var fontSize = $(".subtitleFontSize").val();
                $(".jobSubtitle").css({"font-size":fontSize+"px"});
            });

            $('.subTitileFontWeight').change(function(){
                var fontWeight = $(".subTitileFontWeight").val();
                $(".jobSubtitle").css({"font-weight":fontWeight});
            });

            $('.subtitleFontLetterSpacing').change(function(){
                var letterSpacing = $(".subtitleFontLetterSpacing").val();
                $(".jobSubtitle").css({"letter-spacing":letterSpacing+"px"});
            });

            $('.subtitleFontColor').change(function(){
                var color = $(".subtitleFontColor").val();
                $(".jobSubtitle").css({"color":color});
            });

            //details attribute
            $(".detailsFontSize").change(function(){
                var fontSize = $(".detailsFontSize").val();
                $(".jobLocation").css({"font-size":fontSize+"px"});
            });

            $('.detailsFontWeight').change(function(){
                var fontWeight = $(".detailsFontWeight").val();
                $(".jobLocation").css({"font-weight":fontWeight});
            });

            $('.detailsFontLetterSpacing').change(function(){
                var letterSpacing = $(".detailsFontLetterSpacing").val();
                $(".jobLocation").css({"letter-spacing":letterSpacing+"px"});
            });

            $('.detailsFontColor').change(function(){
                var color = $(".detailsFontColor").val();
                $(".jobLocation").css({"color":color});
            });

            //heading attribute
            $(".headingFontSize").change(function(){
                var fontSize = $(".headingFontSize").val();
                $(".heading").css({"font-size":fontSize+"px"});
            });

            $('.headingFontWeight').change(function(){
                var fontWeight = $(".headingFontWeight").val();
                $(".heading").css({"font-weight":fontWeight});
            });

            $('.headingFontLetterSpacing').change(function(){
                var letterSpacing = $(".headingFontLetterSpacing").val();
                $(".heading").css({"letter-spacing":letterSpacing+"px"});
            });

            $('.headingFontColor').change(function(){
                var color = $(".headingFontColor").val();
                $(".heading").css({"color":color});
            });

            //description attribute
            $(".desFontSize").change(function(){
                var fontSize = $(".desFontSize").val();
                $(".description").css({"font-size":fontSize+"px"});
            });

            $('.desFontWeight').change(function(){
                var fontWeight = $(".desFontWeight").val();
                $(".description").css({"font-weight":fontWeight});
            });

            $('.desFontLetterSpacing').change(function(){
                var letterSpacing = $(".desFontLetterSpacing").val();
                $(".description").css({"letter-spacing":letterSpacing+"px"});
            });

            $('.desFontColor').change(function(){
                var color = $(".desFontColor").val();
                $(".description").css({"color":color});
            });

            //Show & Hide header
            $(".hideheadr").click(function() {
                if ($(this).is(":checked"))
                    $(".job_header").show();
                else
                    $(".job_header").hide();
            });

            //show & hide Body
            $(".hideBody").click(function() {
                if ($(this).is(":checked"))
                    $(".job_content_body").show();
                else
                    $(".job_content_body").hide();
            });

            //show & hhide footer
            $(".hideFooter").click(function() {
                if ($(this).is(":checked"))
                    $(".job_post_footer").show();
                else
                    $(".job_post_footer").hide();
            });

            //show & hhide logo
            $(".hideLogo").click(function() {
                if ($(this).is(":checked"))
                    $(".job_logo").show();
                else
                    $(".job_logo").hide();
            });
        });
    </script>
@endpush
