<?php $page = "Chapters"; ?>
@extends('layout.dashboardlayout')
@section('content')	
@php
$permissions=permissions();
@endphp
<link rel="stylesheet" href="{{ asset('css/switchery/switchery.min.css') }}">
<style>
    .panel.panel-default.chapter {
        border: 1px solid #ddd;
        padding-top: 8px;
        padding-left: 11px;
        margin: 4px;
        background-color: whitesmoke;
        border-radius: 4px;
    }

    .panel.panel-default.lecture {
        border: 1px solid #ddd;
        padding-top: 8px;
        padding-left: 11px;
        margin: 4px;
        background-color: whitesmoke;
        border-radius: 4px;
    }
    .collS{   width: 100%;
              display: inline-block;
              height: 100%;
              margin-top: 5px;
    }
    .collS1{   width: 100%;
              display: inline-block;
              height: 100%;
              margin-top: 5px;
    }
    span.panel-label {
    font-weight: lighter;
    color: #777;
    font-size: 18px;
    }
    .fas.fa-arrows-alt
    {
        cursor: all-scroll;
    }
	
	
	.course-provider-logo img {
    width: 100%;
    max-width: 134px;
}

.course-provider-logo.cursor-pointer.course-provider-logo-checked {
    border: 1px solid rgb(0, 208, 79);
    box-shadow: 0px 10px 10px -8px #bcbcbc;
    padding: 5px;
}

div#lectureForm label {
    padding-left: 15px;
	padding-top:10px;
}

.custom-file {
    padding: 0 15px;
}
</style>
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
                     <a href="{{ url('certify/show/'.encrypted_key($Certify->id,'encrypt')) }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     <a href="{{ url('certify/learnview/'.encrypted_key($Certify->id,'encrypt')) }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
        <span class="btn-inner--icon"><i class="fa fa-airplay"></i> {{__(' Preview Course ')}}</span>
    </a>
 
       
     
       
    
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title"> Chapters</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('certify.index')}}">Courses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chapters</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

<p style="color:white;">A chapter can contain multiple lectures, a lecture could be video, downloads, link, pdfs or text.</p>
<div class="row">
    {{--Right Side Menu--}}
    {{--Main Part--}}
    <div class="col-lg-12 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                <div class="card-header">
                    <center><span style="color: red;display: none;" id="requiredError">!All Fields are Required Check Fields Some Fields are Empty</span></center>
                </div>
                <div class="card-body">
                    {{ Form::open(['url' => 'certify/curriculumStore','id' => 'create_certifyCurriculum','enctype' => 'multipart/form-data']) }}
                    <!--<form class="landa-content-form" action="route('certify/curriculumStore')" data-parsley-validate="" method="POST" loader="true" enctype="multipart/form-data">-->
                    <input type="hidden" name="certify" value="{{ $Certify->id }}">
                    <div class="online-classes-list">
                        <div class="panel-group chapter-holder" id="accordion">
                            @if (count($chapters))
                            @foreach ($chapters as $index => $chapter)
                            <!-- single chapter -->
                            <div class="panel panel-default chapter" >
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <div class="row">
                                            <div class="col-11">
                                                <a class="text-dark collS collapsed" data-toggle="collapse" data-parent="#accordion" href="#chapter{{ $chapter->id }}">
                                                    <div class="chapter-drag"></div>
                                                    <i class="fas fa-arrows-alt"></i>&nbsp;
                                                    <span class="indexing">{{ $index + 1 }}.)</span>  <span class=" text-dark panel-label">{{ $chapter->title }}</span>
                                                </a>
                                            </div>
                                            <div class="col-1">
                                                <a href="javascript:void(0)" style="float:right;outline: auto;margin-right: 6px;" class="text-danger btn btn-default btn-sm pull-right manage-class delete-item" data-id="{{ $chapter->id }}" data-type="chapter" title="Delete chapter"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </div>
                                    </h4>

                                </div>
                                <div id="chapter{{ $chapter->id }}" class="panel-collapse chapter-body collapse">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="text-dark">Chapter Title</label>
                                                    <input type="text" class="form-control chapter-title" name="chaptertitle[]" value="{{ $chapter->title }}" placeholder="Chapter Title" required>
                                                    <input type="hidden" name="chapterid[]" value="{{ $chapter->id }}">
                                                    <input type="hidden" class="chapter-indexing" name="indexing[]" value="{{ $chapter->indexing }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="text-dark">Chapter Description</label>
                                                    <textarea class="form-control" id="summary-ckeditor"  name="chapterdescription[]" placeholder="Chapter Description" rows="3" required>{{ $chapter->description }}</textarea>
													
													
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-control-label">Type</label>
                                                    <select class="form-control chapter_type" name="chapter_type" id="chapter_type">
                                                        @foreach($certifyChapter->getChapterType() as $key => $type)
                                                            <option value="{{$key}}" @if($chapter->type==$key) selected @endif >{{$type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <p class="text-dark">Below are lectures of this chapter</p>
                                        <div class="panel-group chapter-lecture-holder" id="lecture-accordion">
                                            @if (count($chapter->lectures))
                                            @foreach ($chapter->lectures as $key => $lecture)
                                            <!-- single link lecture -->
                                            <div class="panel panel-default lecture">
                                                <div class="panel-heading">

                                                    <h4 class="panel-title">

                                                        <div class="row">
                                                            <div class="col-11">
                                                                <a data-toggle="collapse" class="collS1 text-dark" data-parent="#lecture-accordion" href="#lecture{{ $lecture->id }}">
                                                                    <i class="fas fa-arrows-alt"></i>&nbsp;&nbsp;
                                                                    @if ( $lecture->type == "link" )
                                                                        <i class="fas fa-link"></i>
                                                                    @elseif ( $lecture->type == "text" )
                                                                        <i class="far fa-file-alt"></i>
                                                                    @elseif ( $lecture->type == "downloads" )
                                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                                    @elseif ( $lecture->type == "pdf" )
                                                                        <i class="fas fa-file-pdf"></i>
                                                                    @elseif ( $lecture->type == "video" )
                                                                        <i class=" fa fa-play-circle"></i>
                                                                    @elseif ( $lecture->type == "scorm" )
                                                                        <i class="fa fa-file"></i>
                                                                    @endif
                                                                    <span class="indexing">{{ $key + 1 }}.)</span>
                                                                    <span class=" text-dark panel-label">{{ $lecture->title }}</span>
                                                                </a>
                                                            </div>
                                                            <div class="col-1">
                                                                <a href="" style="float:right;outline: auto; margin-right: 6px;" class=" text-danger btn btn-default btn-sm pull-right manage-class delete-item" data-type="lecture" data-id="{{ $lecture->id }}" title="Delete Lecture">
                                                                <i class="fas fa-trash-alt"></i></a>
                                                            </div>
                                                        </div>

                                                    </h4>
                                                </div>
                                                <div id="lecture{{ $lecture->id }}" class="panel-collapse collapse lecture-body">
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-12"> <label class="text-dark">Lecture Title</label>
                                                                    <input type="text" class="form-control chapter-title" name="lecturetitle[]" original-name="lecturetitle" value="{{ $lecture->title }}" required><input type="hidden" class="lecture-indexing" name="lectureindexing[]" original-name="lectureindexing" value="{{ $lecture->indexing }}"> <input type="hidden" name="lectureid[]" original-name="lectureid"  value="{{ $lecture->id }}"> <input type="hidden" name="type[]" original-name="type" value="{{ $lecture->type }}">
                                                                    <!--<input type="file" class="hidden" name="content[]" original-name="content">-->
                                                                    @if ( $lecture->type == "downloads" || $lecture->type == "video"  || $lecture->type == "pdf" || $lecture->type == 'scorm' )
                                                                    <input type="hidden" name="content[]" original-name="content" value="{{$lecture->content}}">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-12"> <label class="text-dark">Lecture Description</label>


																<textarea id="" class="form-control" name="lecturedescription[]" original-name="lecturedescription" placeholder="Lecture Description" rows="3" required>{{ strip_tags($lecture->description) }}</textarea> </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row text-dark">
                                                                @if ( $lecture->type == "link" )
                                                                <div class="col-md-12"> <label>Enter link/URL</label> <input type="url" class="form-control" name="content[]" original-name="content" placeholder="Enter link/URL" value="{{ $lecture->content }}" required> </div>
                                                                @elseif ( $lecture->type == "text" )
                                                                <div class="col-md-12"> <label>Lecture Text body</label> <textarea id="summary-ckeditor" class="form-control" name="content[]" original-name="content" placeholder="Lecture Description" rows="6" required>{{ $lecture->content }}</textarea> </div>
                                                                @elseif ( $lecture->type == "downloads" )
                                                                <div class="col-md-12">
                                                                    <a  href="javascript:void(0)" class="btn btn-primary btn-icon rounded-pill mr-2 m-0 uploadNewFile" lectureId="{{$lecture->id}}">
                                                                        <span class="btn-inner--text text-white"><i class="fas fa-cloud-upload-alt"></i> {{__(' Resource to download ')}}</span>
                                                                    </a>
                                                                    <br>
                                                                    <br>
                                                                     <a download href="{{asset('storage')}}/app/{{ $lecture->content }}"  style="outline:auto;"  class="btn btn-default btn-block"><i class="fas fa-cloud-upload-alt"></i> Download Resource</a></div>
                                                                @elseif ( $lecture->type == "pdf" )
                                                                <div class="col-md-12">
                                                                    <a  href="javascript:void(0)" class="btn btn-primary btn-icon rounded-pill mr-2 m-0 uploadNewFile" lectureId="{{$lecture->id}}">
                                                                        <span class="btn-inner--text text-white"><i class="fas fa-file-pdf"></i> {{__(' Uploaded PDF ')}}</span>
                                                                    </a>
                                                                    <br>
                                                                    <br>
                                                                   <a  download href="{{asset('storage')}}/app/{{ $lecture->content }}" style="outline:auto;" class="btn btn-default btn-block"><i class=" fas fa-file-pdf"></i> Download PDF</a></div>
                                                                @elseif ( $lecture->type == "video" )
                                                                <div class="col-md-12">
                                                                    <a  href="javascript:void(0)" class="btn btn-primary btn-icon rounded-pill mr-2 m-0 uploadNewFile"  lectureId="{{$lecture->id}}">
                                                                        <span class="btn-inner--text text-white"><i class="fa fa-play-circle"></i> {{__(' Uploaded Video ')}}</span>
                                                                    </a>
                                                                    <br>
                                                                    <br>
                                                                    <a download href="{{asset('storage')}}/app/{{ $lecture->content }}" style="outline:auto;" class="btn btn-default btn-block"><i class=" fa fa-play-circle"></i> Download Video</a> </div>
                                                                @elseif ( $lecture->type == "scorm")
                                                                    <a href="javascript:void(0)" class="btn btn-primary btn-icon rounded-pill mr-2 m-0 uploadNewFile"  lectureId="{{$lecture->id}}" data-lacture-type="{{$lecture->type}}">
                                                                        <span class="btn-inner--text text-white"><i class="fa fa-file"></i> {{__(' Uploaded Scorm File ')}}</span>
                                                                    </a>
                                                                    <br>
                                                                    <br>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end lecture -->
                                            @endforeach
                                            @else
                                            <div class="empty-section text-dark">
                                                <i class="fa fa-clipboard-text"></i>
                                                <h5 class="text-dark">No lectures here, add a new one below!</h5>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="lecture-buttons-holder">
                                            <p class="text-thin text-dark text-muted mb-5" style="color:151515;">Add another lecture</p>
                                            <div class="btn-group btn-group-justified custom_type" style="display: @if($chapter->type=='custom') block @else none @endif">
                                                <a href="javascript:void(0)" class="btn btn-default  add-lecture" data-type="video" data-certify="{{$Certify->id}}" data-chapter="{{$chapter->id}}"><i class="fa fa-play-circle"></i> Video</a>
                                                <a href="javascript:void(0)" class="btn btn-default add-lecture" data-type="downloads" data-certify="{{$Certify->id}}" data-chapter="{{$chapter->id}}"><i class="fas fa-cloud-upload-alt"></i> Downloads</a>
                                                <a href="javascript:void(0)" class="btn btn-default add-lecture" data-type="link" data-certify="{{$Certify->id}}" data-chapter="{{$chapter->id}}"><i class="fas fa-link"></i> Link</a>
                                                <a href="javascript:void(0)" class="btn btn-default add-lecture" data-type="pdf" data-certify="{{$Certify->id}}" data-chapter="{{$chapter->id}}"><i class="fas fa-file-pdf"></i> PDF</a>
                                                <a href="javascript:void(0)" class="btn btn-default add-lecture" data-type="text" data-certify="{{$Certify->id}}" data-chapter="{{$chapter->id}}"><i class=" far fa-file-alt"></i> Text</a>
                                            </div>
                                            <div class="btn-group btn-group-justified scorm_type" style="display: @if($chapter->type=='scorm') block @else none @endif">
                                                <a href="javascript:void(0)" class="btn btn-default add-lecture" data-type="scorm" data-certify="{{$Certify->id}}" data-chapter="{{$chapter->id}}"><i class="fa fa-file"></i> Scorm</a>
                                            </div>
                                            <!--<p class="text-thin text-muted mb-5">Add from scorm</p>-->
                                            <!--<div class="row text-center">-->
                                            <!--    <div class="col mt-2">-->
                                            <!--        <select class="custom-select custom-select-lg add-lecture-select" data-type="scorm">-->
                                            <!--            <option selected disabled>SCORM Course</option>-->

                                            <!--        </select>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="empty-section empty-chapter"><i class="fa fa-clipboard-text"></i><h5>No chapters here, add a new one!</h5></div>
                            @endif
                        </div>
                        <br>
                        <!-- here -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 mt-15">
                                    <!--<input type="submit" name="save" value="Save" >-->
                                    <!--<a  href="javascript::void(0);" class="btn btn-primary btn-icon rounded-pill mr-2 m-0">-->
                                    <!--    <span class="btn-inner--text text-white"><i class="fa fa-airplay"></i> {{__(' Save Changes ')}}</span>-->
                                    <!--</a>-->
                                    @if (count($chapters))
                                    <button type="submit" class="btn btn-primary rounded-pill" id="SaveCurriculum">Save Changes</button>
                                    @endif
                                    
                                    <a href="#" data-url="{{ url('certify/curriculumCreate/'.$Certify->id) }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Create Courses Curriculum')}}" class="btn btn-sm btn-primary float-right ml-2  add-chapter">
                                        <span class="btn-inner--text "><i class="fa fa-airplay"></i> {{__(' Add Chapter ')}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--</form>-->
                    {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
</div>
    

            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->


<!-- Modal -->

@endsection

@push('script')

<div id="fileUploadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content"  style="width: 750px;margin-left: -20%;">
            <div class="modal-header">
                <h5 class="modal-title">Upload Lecture File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::open(['url' => 'certify/lectureFileSave','id' => 'create_lectureFileSave','enctype' => 'multipart/form-data']) }}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Choose File</label>
                            <input type="file" class="form-control" name="file" accept="video/mp4" placeholder="Lecture File" required>
                            <input type="hidden" name="lectureId" id="lectureId"  value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="submit" class="btn btn-sm btn-primary rounded-pill" id="">Save</button>
                {{ Form::close() }}
                <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- lecture file upload Modal -->
<div id="scormFileUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content"  style="width: 750px;margin-left: -20%;">
            <div class="modal-header">
                <h5 class="modal-title">Upload Scorm File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::open(['url' => 'certify/lectureFileSave','id' => 'create_lectureFileSave','enctype' => 'multipart/form-data']) }}
                <input type="hidden" value="" id="scorm_lecture_id" name="lectureId">
                <div class="form-group" id="scorm_wraper">
                </div>
            </div>
            <div class="modal-footer">

                <button type="submit" class="btn btn-sm btn-primary rounded-pill" id="">Save</button>
                {{ Form::close() }}
                <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="destroy" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-content p-2 text-center">
                    <h4 class="modal-title">Delete</h4>
                    <p class="mb-4">Are you sure want to delete?</p>
                  {{ Form::open(['url' => 'certify/curriculum/distroy','id' => 'destroy_certifyCurriculum','enctype' => 'multipart/form-data']) }}
				   <input type="hidden" name="destroytype" id="destroytype"  value="">
                <input type="hidden" name="curriculumId" id="curriculumId"  value="">
                        <div class="form-group btn-group text-center">
                        <button type="submit" class="btn btn-danger  form-control">Delete </button>
                    <button type="button" class="btn btn-primary form-control" data-dismiss="modal">Close</button>
                        </div>
                   {{ Form::close() }}
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- lecture Modal -->



 <div class="modal fade" aria-hidden="true" role="dialog" id="lectureModal" style="padding-right: 0px !important; ">
       <div class="modal-dialog modal-dialog-centered" role="document">
        <!-- Modal content-->
        <div class="modal-content"  style="width: 750px;margin-left: -20%;">
            <div class="modal-header">
                <h5 class="modal-title">Create Lecture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::open(['url' => 'certify/lectureSave','id' => 'create_lectureSave','enctype' => 'multipart/form-data']) }}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Lecture Name</label>
                            <input type="text" class="form-control" name="title" placeholder="Lecture Name" required>
                            <input type="hidden" name="certify_id" id="certify_id"  value="">
                            <input type="hidden" name="chapter_id" id="chapter_id"  value="">
                            <input type="hidden" name="type" id="contentType"  value="">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Lecture Description</label>
                            <textarea class="form-control" id="summary-ckeditor" name="description" placeholder="Lecture Description" rows="5"
                                      required></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12" id="lectureForm">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary rounded-pill" id="">Save</button>
                {{ Form::close() }}
                <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- lecture file upload Modal -->
<script src="{{ asset('js/builder.js') }}"></script>
<script src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script>
var path ="{{ route('scorm.file.data') }}";
    $( "#SaveCurriculum" ).click(function() {
          setTimeout(function(){
                $("#requiredError").show();
                  $('html, body').animate({
                    scrollTop: $("#back").offset().top

                    }, 700);
            },2000);
    });
    $('.chapter_type').change(function () {
        var chapterType = $(this).val();
        if(chapterType=='custom'){
            $(this).closest('div.chapter-body').find('.custom_type').show();
            $(this).closest('div.chapter-body').find('.scorm_type').hide();
        }
        if(chapterType=='scorm'){
            $(this).closest('div.chapter-body').find('.custom_type').hide();
            $(this).closest('div.chapter-body').find('.scorm_type').show();
        }
    });

CKEDITOR.replace('summary-ckeditor');
</script>
@endpush
