<?php $page = "book"; ?>
@extends('layout.dashboardlayout')
@section('content')	

<style>
.hide{
        display:none;
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
                   <a href="{{ route('pathway.get') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Pathway Edit</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pathway.get') }}">Pathway</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pathway Edit</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->





<div class="row mt-3" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['url' =>'pathway/update','id' => 'Pathway_update','enctype' => 'multipart/form-data']) }}
             
               <input type="hidden" name="id" value={{ $pathway->id }} />

<div class="form-group">
    <div class="row">
   
     <!-- mentor type -->
     <div class="col-md-8 show">
               <div class="form-group">
                  <label class="form-control-label">I am a</label>
                   <select class="form-control mentortype" name="mentor_type" id="mentor_type" >
                  
                        <option value="student"  @if($pathway->mentor_type == 'student') selected @endif>Student</option>
                        <option value="employee"  @if($pathway->mentor_type == 'employee') selected @endif>Employee</option>
                        <option value="volunteer"  @if($pathway->mentor_type == 'volunteer') selected @endif>Volunteer</option>
                        <option value="veteran"  @if($pathway->mentor_type == 'veteran') selected @endif>Veteran</option>
                        <option value="justice"  @if($pathway->mentor_type == 'justice') selected @endif>Justice involved</option>
                          <option value="non_profit_org" @if($pathway->mentor_type == 'non_profit_org') selected @endif>Non Profit Organization</option>
                        <option value="small_business" @if($pathway->mentor_type == 'small_business') selected @endif>Small Business</option>
                    </select>
                </div>
            </div>
 <!-- mentor type -->
 

 <!-- level -->
            <div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Level</label>
                   <select class="form-control level" name="level" id="mentor_type" >
                        <option value="">Select </option>
                        <option value="K-12"  @if($pathway->level == 'K-12') selected @endif>Grade Level K-12</option>
                        <option value="military"  @if($pathway->level == 'military') selected @endif>Military</option>
                        <option value="vocational"  @if($pathway->level == 'vocational') selected @endif>Vocational</option>
                        <option value="college"  @if($pathway->level == 'college') selected @endif>College</option>
             
                    </select>
                </div>
            </div>
 <!-- level -->
 
 
 <!-- honorably  -->
                        <div class="col-md-8 hide">
                        <div class="form-group">
                        <label class="display-block w-100">Were you honorably discharged?</label>
                        <div class="discharged">
                        <div class="custom-control custom-radio custom-control-inline">
                        <input @if($pathway->discharged == 'yes') checked @endif class="custom-control-input" id="yes" name="discharged" value="yes" type="radio" checked="">
                        <label class="custom-control-label" for="yes">Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                        <input  @if($pathway->discharged == 'no') checked @endif class="custom-control-input" id="no" name="discharged" value="no" type="radio">
                        <label class="custom-control-label" for="no">No</label>
                        </div>
                        </div>
                        </div>
                        </div>
<!-- honorably  -->


<!-- veteranlist -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Branch</label>
                   <select multiple class="form-control veteranlist" name="branch" id="branch2" >
                   <option value="">Select </option>
                
                        <option value="army" @if($pathway->branch == 'army') selected @endif>Army</option>
                        <option value="navy" @if($pathway->branch == 'navy') selected @endif>Navy</option>
                        <option value="airforce" @if($pathway->branch == 'airforce') selected @endif>Air Force</option>
                        <option value="coastguard" @if($pathway->branch == 'coastguard') selected @endif>Coast Guard</option>
                        <option value="marinecorps" @if($pathway->branch == 'marinecorps') selected @endif> Marine Corps</option>
                        <option value="spaceforce" @if($pathway->branch == 'spaceforce') selected @endif>Space Force</option>
              
                    </select>
                </div>
            </div>
<!-- veteranlist -->


<!-- college -->
 <div class="col-md-8 @if(empty(json_decode($pathway->college, true))) hide @endif">
               <div class="form-group">
                  <label class="form-control-label">College</label>
                   <select class="form-control college" name="college[]" id="college" multiple>
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'college' || $value->type == 'College')
                        <option value="{{ $value->id }}" @if(!empty(json_decode($pathway->college, true))) @foreach(json_decode($pathway->college, true) as $key => $values)@if($values == $value->id) {{ 'selected '}} @endif @endforeach     @endif>{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" href="#" data-ajax-popup="true" data-url="{{route('college.create')}}" data-size="md" data-title="Add College">
            <span class="btn-inner--icon">Recommend College</span>
              </a></span>
            </div>
            </div>
           
<!-- college -->
<!-- grade level -->
<div class="col-md-8  @if($pathway->gradelevel == null) hide @endif">
               <div class="form-group">
                  <label class="form-control-label">Grade Level</label>
                   <select class="form-control gradelevel" name="gradeLevel" id="gradeLevel" multiple>
                   <option value="">Select </option>
                   @for($i=1; $i < 13; $i++)
                   <option value="{{ $i }}" @if($pathway->gradelevel == $i) selected @endif>Grade {{ $i }} </option>
                   @endfor
                    </select>
                </div>
              
            </div>
<!-- grade level -->

<!-- school -->
<div class="col-md-8 @if(empty(json_decode($pathway->school, true))) hide @endif">
               <div class="form-group">
                  <label class="form-control-label">School</label>
                   <select class="form-control school" name="school[]" id="school" multiple>
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'school' || $value->type == 'School')
                     <option value="{{ $value->id }}" @if(!empty(json_decode($pathway->school, true))) @foreach(json_decode($pathway->school, true) as $key => $values)@if($values == $value->id) {{ 'selected '}} @endif @endforeach     @endif>{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" target="_blank" href="{{route('pathway.entity.create',['type'=>'School'])}}" title="Add School">
            <span class="btn-inner--icon">Recommend School</span>
              </a></span>
            </div>
            </div>
<!-- school -->
<!-- school -->
<div class="col-md-8 @if(empty(json_decode($pathway->school, true))) hide @endif">
               <div class="form-group">
                  <label class="form-control-label">What is the name of your Trade or Vocational School? </label>
                   <select class="form-control " name="school[]" id="s_school" >
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'school' || $value->type == 'School')
                     <option value="{{ $value->id }}" @if(!empty(json_decode($pathway->school, true))) @foreach(json_decode($pathway->school, true) as $key => $values)@if($values == $value->id) {{ 'selected '}} @endif @endforeach     @endif>{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" target="_blank" href="{{route('pathway.entity.create',['type'=>'School'])}}" title="Add School">
            <span class="btn-inner--icon">Recommend School</span>
              </a></span>
            </div>
            </div>
<!-- school -->


<!-- trade category -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Trade Category</label>
                   <select multiple class="form-control tradecategory" name="trade_category" id="trade_category" >
                      <option value="">Select </option>
                      @foreach($data as $key => $val)
                     <option value="{{ $val->id }}" @if($pathway->trade_category == $val->id) selected @endif>{{ $val->name }}</option>
                   @endforeach
                    </select>
                </div>
            </div>
<!-- trade category -->


<!-- branch -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Branch</label>
                   <select multiple  class="form-control branch" name="branch" id="branch" >
                        <option value="">Select </option>
                        <option value="army" @if($pathway->branch == 'army') selected @endif>Army</option>
                        <option value="navy" @if($pathway->branch == 'navy') selected @endif>Navy</option>
                        <option value="airforce" @if($pathway->branch == 'airforce') selected @endif>Air Force</option>
                        <option value="coastguard" @if($pathway->branch == 'coastguard') selected @endif>Coast Guard</option>
                        <option value="marinecorps" @if($pathway->branch == 'marinecorps') selected @endif> Marine Corps</option>
                        <option value="spaceforce" @if($pathway->branch == 'spaceforce') selected @endif>Space Force</option>
              
                    </select>
                </div>
            </div>
<!-- branch -->


<!-- employee -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Employer</label>
                   <select multiple class="form-control employeelist" name="employee" id="employee" >
                   <option value="">Select </option>
                   @foreach($employer as $key => $val)
                     <option value="{{ $val->id }}" @if($pathway->employee != null) selected @endif>{{ $val->company }}</option>
                   @endforeach
                    </select>
                </div>
                <div class="form-group">
                <span><a class="btn btn-sm btn-primary .btn-rounded float-left" href="#" data-ajax-popup="true" data-url="{{route('employer.create')}}" data-size="md" data-title="Recommend Employer">
            <span class="btn-inner--icon">Recommend Employer</span>
              </a></span>
            </div>
            </div>
<!-- employee -->
<!-- Apprenticeship  -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Certification</label>
                   <select multiple class="form-control apprenticeship catlogcertifications" name="catalog" id="apprenticeship" >
                   <option value="">Select </option>
                   @foreach($apprenticeship  as $key => $val)
                     <option value="{{ $val->id }}"  @if($pathway->catalog == $val->id) selected @endif>{{ $val->name }}</option>
                   @endforeach
                    </select>
                </div>
            </div>
<!-- Apprenticeship  -->

<!-- cataloglist -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Certification</label>
                   <select multiple class="form-control cataloglist catlogcertifications" name="catalog" id="catalog" >
                   <option value="">Select </option>
                   @foreach($certify as $key => $val)
                     <option value="{{ $val->id }}" @if($pathway->catalog == $val->id) selected @endif>{{ $val->name }}</option>
                   @endforeach
                    </select>
                </div>
            </div>
<!-- cataloglist -->
<div class="col-md-8 hide">
            <div class="form-group">
                <label class="form-control-label">Do you have home wifi?</label>
                <select class="form-control homewifi" name="wifi" >
                     <option value="">Select Option</option>
                     <option @if($pathway->wifi == 'yes') selected @endif value="yes">Yes</option>
                     <option @if($pathway->wifi == 'no') selected @endif value="no">No</option>
                </select>
            </div>
       </div>
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Where is your closest library?</label>
                  <select class="form-control select2" name="library" id="s_q_library" >
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'library' ||  $value->type == 'Library' )
                        <option @if($pathway->library == $value->id) selected @endif value="{{ $value->id }}">{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" target="_blank" href="{{route('pathway.entity.create',['type'=>'Library'])}}" title="Add Library">
            <span class="btn-inner--icon">Recommend Library</span>
              </a></span>
            </div>
            </div>
      <div class="col-md-8 hide">
            <div class="form-group">
                <label class="form-control-label">Do you have a tablet or home PC?</label>
                <select class="form-control  student_q_home_pc" name="home_pc" >
                     <option value="">Select </option>
                     <option @if($pathway->home_pc == 'yes') selected @endif value="yes">Yes</option>
                     <option @if($pathway->home_pc == 'no') selected @endif value="no">No</option>
                </select>
            </div>
       </div>

      <div class="col-md-8 hide">
            <div class="form-group">
                <label class="form-control-label">Which STEM Industry would you like to work in?</label>
                <select class="form-control  student_q_stem_ind" name="stem_industry" >
                     <option value="">Select</option>
                     @if(!empty($stem_industry))
                     @foreach($stem_industry as $row)
                     <option @if($pathway->stem_industry == $row->periodName.', '.$row->year.' ('.$row->period.')') selected @endif value="{{$row->periodName.', '.$row->year.' ('.$row->period.')'}}">{{$row->periodName.', '.$row->year.' ('.$row->period.')'}}</option>
                     @endforeach
                     @endif
                </select>
            </div>
       </div>
<div class="col-md-8 hide">
            <div class="form-group">
                <label class="form-control-label">Would you like to join one of the following science, arts, or reading clubs?</label>
                <select class="form-control select2 student_q_reading_club" name="reading_club" >
                     <option value="">Select </option>
                     <option @if($pathway->reading_club == 'STEM') selected @endif value="STEM">STEM</option>
                     <option @if($pathway->reading_club == 'STEAM') selected @endif value="STEAM">STEAM</option>
                     <option @if($pathway->reading_club == 'STREAM') selected @endif value="STREAM">STREAM</option>
                     <option @if($pathway->reading_club == 'No') selected @endif value="No">No</option>
                </select>
            </div>
       </div>
<div class="col-md-8 hide">
            <div class="form-group">
                <label class="form-control-label">Do you live in a PHA Community? </label>
                <select class="form-control student_pha_c" name="pha_community" >
                     <option value="">Select Option</option>
                     <option @if($pathway->pha_community == 'yes') selected @endif value="yes">Yes</option>
                     <option @if($pathway->pha_community == 'no') selected @endif value="no">No</option>
                </select>
            </div>
       </div>
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Please select PHA Community </label>
                  <select class="form-control select2" name="pha_community_id" id="s_q_community" >
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'PHA Community' )
                        <option @if($pathway->pha_community_id == $value->id ) selected @endif  value="{{ $value->id }}">{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" target="_blank" href="{{route('pathway.entity.create',['type'=>'PHA Community'])}}" title="Add PHA Community">
            <span class="btn-inner--icon">Recommend PHP Community</span>
              </a></span>
            </div>
            </div>
<div class="col-md-8 hide">
            <div class="form-group">
                <label class="form-control-label">What Year will you Graduate High School?</label>
                <input type="text" name="graduation_year" id="year_graduate" value="{{$pathway->graduation_year}}" placeholder="year" class="form-control year_graduate"  />
            </div>
       </div>
                
                
                <div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Please select company </label>
                  <select class="form-control select2 non_company" name="company" id="non_company" >
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'Company' )
                        <option @if($pathway->company == $value->id ) selected @endif value="{{ $value->id }}">{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" target="_blank" href="{{route('pathway.entity.create',['type'=>'Company'])}}" title="Add Company">
            <span class="btn-inner--icon">Recommend Company</span>
              </a></span>
            </div>
            </div>
                <div class="col-md-8 hide">
            <div class="form-group">
                <label class="form-control-label">Are you Tax Exempt? </label>
                <select class="form-control tax_exempted" name="tax_exempted" >
                     <option value="">Select</option>
                     <option @if($pathway->tax_exempted == "yes" ) selected @endif value="yes">Yes</option>
                     <option @if($pathway->tax_exempted == "no" ) selected @endif value="no">No</option>
                </select>
            </div>
       </div>
<div class="col-md-8 hide">
            <div class="form-group">
                <label class="form-control-label">Upload tax certificate</label>
                <input type="file" data-default-file="{{asset(Storage::url('pathways'))}}/{{$pathway->tax_certificate}}"  name="tax_certificate" id="tax_certificate"  class="form-control  tax_certificate" placeholder="Upload  File" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*" >
            </div>
       </div>
                <div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Please select company </label>
                  <select class="form-control select2 small_company" name="company" id="small_company" >
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'Company' )
                        <option @if($pathway->company == $value->id ) selected @endif value="{{ $value->id }}">{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" target="_blank" href="{{route('pathway.entity.create',['type'=>'Company'])}}" title="Add Company">
            <span class="btn-inner--icon">Recommend Company</span>
              </a></span>
            </div>
            </div>
                <div class="col-md-8">
               <div class="form-group">
                  <label class="form-control-label">Have you been in business, 2 years or more?</label>
                   <select class="form-control business_year" name="business_year" id="business_year">
                     <option value="">Select</option>
                     <option @if($pathway->business_year == "Yes" ) selected @endif value="Yes">Yes</option>
                     <option @if($pathway->business_year == "No" ) selected @endif value="No">No</option>
                    </select>
                </div>
            </div>
                <div class="col-md-8">
               <div class="form-group">
                  <label class="form-control-label">I am interested in  RFI, RFP,  Grant opportunities</label>
                   <select class="form-control grant_opportunity" name="grant_opportunity" id="grant_opportunity">
                     <option @if($pathway->grant_opportunity == "Yes" ) selected @endif value="Yes">Yes</option>
                     <option @if($pathway->grant_opportunity == "No" ) selected @endif  value="No">No</option>
                    </select>
                </div>
            </div>
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Who is the Mayor in your city or town? </label>
                  <select class="form-control select2 mayor" name="mayor" id="mayor" >
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'Mayor' )
                        <option  @if($pathway->mayor == $value->id ) selected @endif  value="{{ $value->id }}">{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" target="_blank" href="{{route('pathway.entity.create',['type'=>'Mayor'])}}" title="Add Mayor">
            <span class="btn-inner--icon">Recommend Mayor</span>
              </a></span>
            </div>
            </div>

<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Military Base were you assigned to? </label>
                  <select class="form-control select2 military_base" name="military_base" id="military_base"  >
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'Military Base' )
                        <option @if($pathway->military_base == $value->id ) selected @endif value="{{ $value->id }}">{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" target="_blank" href="{{route('pathway.entity.create',['type'=>'Company'])}}" title="Add Military Base">
            <span class="btn-inner--icon">Recommend Military Base</span>
              </a></span>
            </div>
            </div>

<div class="col-md-8">
               <div class="form-group">
                  <label class="form-control-label">Are you on Probation, Parole?</label>
                   <select class="form-control probation_parole" name="probation_parole" id="probation_parole">
                     <option value="">Select</option>
                     <option @if($pathway->probation_parole == "yes" ) selected @endif value="yes">Yes</option>
                     <option @if($pathway->probation_parole == "no" ) selected @endif value="no">No</option>
                    </select>
                </div>
            </div>
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Choose Officer </label>
                  <select class="form-control select2 justice_officer" name="justice_officer" id="justice_officer" >
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'Justice Involved Officer' )
                        <option @if($pathway->justice_officer == $value->id ) selected @endif value="{{ $value->id }}">{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" target="_blank" href="{{route('pathway.entity.create',['type'=>'Justice Involved Officer'])}}" title="Add Justice Involved Officer">
            <span class="btn-inner--icon">Recommend Justice Involved Officer</span>
              </a></span>
            </div>
            </div>
<div class="col-md-8">
               <div class="form-group">
                  <label class="form-control-label">Are your a registered sex offender?</label>
                   <select class="form-control sex_offender" name="sex_offender" id="sex_offender">
                     <option value="">Select</option>
                     <option @if($pathway->sex_offender == "yes" ) selected @endif value="yes">Yes</option>
                     <option @if($pathway->sex_offender == "no" ) selected @endif value="no">No</option>
                    </select>
                </div>
            </div>
<div class="col-md-8">
               <div class="form-group">
                  <label class="form-control-label">Is the crime you were convicted of eligible for expungement?</label>
                   <select class="form-control expungement" name="expungement" id="expungement">
                     <option value="">Select</option>
                     <option @if($pathway->expungement == "yes" ) selected @endif value="yes">Yes</option>
                     <option @if($pathway->expungement == "no" ) selected @endif value="no">No</option>
                     <option @if($pathway->expungement == "unsure" ) selected @endif value="unsure">Unsure</option>
                    </select>
                </div>
            </div>
        <div class="col-md-8">
        <div class="form-group">
            <label class="form-control-label">Type</label>
            <select class="form-control" name="type">

                 <option value="">Select Type</option>
                 <option value="career" @if($pathway->type=='career') {{ 'selected'}} @else @endif >Career</option>
                <option value="business" @if($pathway->type=='business') {{ 'selected' }}  @else @endif >Business</option>
                <option value="life" @if($pathway->type=='life') {{ 'selected'}}  @else @endif >Life</option>
                <option value="family" @if($pathway->type=='family') {{ 'selected'}}  @else @endif >Family</option>
                <option value="health" @if($pathway->type=='health') {{ 'selected' }}  @else @endif >Health</option>
                <option value="relationship" @if($pathway->type=='relationship') {{ 'selected' }}  @else @endif >Relationship</option>
                <option value="community" @if($pathway->type=='community') {{ 'selected' }}  @else @endif >Community</option>
                <option value="finance" @if($pathway->type=='finance') {{ 'selected' }}  @else @endif >Finance</option>
            </select>
        </div>
   </div>
   @if(!empty(json_decode($pathway->certify, true)))
        <div class="col-md-8">
        <div class="form-group">
    
  
            <label class="form-control-label">Certify</label>
            <select class="form-control certify" name="certify[]" multiple>
                <?php print_r($certify); ?>
            @if($certify->isEmpty())
            @else
            @foreach($certify as $key => $val)
            <option value="{{ $val->id }}" @if(!empty(json_decode($pathway->certify, true))) @foreach(json_decode($pathway->certify, true) as $key => $value)@if($value == $val->id) {{ 'selected '}} @endif @endforeach @endif>{{ $val->name }}</option>
           @endforeach
           @endif
            </select>
        </div>
</div>
@endif
        <div class="col-md-8">
        <div class="form-group">
            <label class="form-control-label">Timeline</label>
            <div class="form-group">
        <div class='input-group date' id='datetimepicker1'>
           <input type='date' class="form-control" min="{{ date('Y-m-d') }}" name="timeline" value="{{ $pathway->timeline }}"/>
           <span class="input-group-addon">
           <span class="glyphicon glyphicon-calendar"></span>
           </span>
        </div>
     </div>
</div>
        </div>
        <div class="col-md-8">
        <div class="form-group">
            <label class="form-control-label">Would you like to schedule a series of reminders to keep you on track</label>
            <select class="form-control" name="send_reminder" id="send_reminder">
               <option value="Yes" @if($pathway->send_reminder=='Yes') {{ 'selected'}} @else @endif>Yes</option>
               <option value="No" @if($pathway->send_reminder=='No') {{ 'selected'}} @else @endif>No</option>
            </select>
        </div>
</div>
        <div class="col-md-8" id="remindertype"  @if($pathway->send_reminder=='No') {{ 'style=display:none;'}} @else @endif>
        <div class="form-group">
            <label class="form-control-label">Reminder Type</label>
            <select class="form-control" name="reminder_type">
              <option value="Daily" @if($pathway->reminder_type=='Daily') {{ 'selected'}} @else @endif>Daily</option>
              <option value="Weekly" @if($pathway->reminder_type=='Weekly') {{ 'selected'}} @else @endif>Weekly</option>
              <option value="Monthly" @if($pathway->reminder_type=='Monthly') {{ 'selected'}} @else @endif>Monthly</option>
            </select>
</div>
        </div>
        
    </div>
</div>


</div>
<div class="col-md-8">
  <div class="text-right">
{{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
<!-- <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button> -->
</div>
</div>
{{ Form::close() }}
            </div>
        </div>
    </div>





            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection
@push('script')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>
<script>
$( document ).ready(function() {
    
    $('#send_reminder').on('change', function() {
    //$('input[name=send_reminder]').change(function(){

        var selected =$(this).val();
       if(selected == 'No'){
           $('#remindertype').hide();
       }
       else{
        $('#remindertype').show();
       }
    })
});
$(document).ready(function() {
    $('.certify').select2();
});
</script>
<script type="text/javascript">

         $(function () {
           
            var valueSelected = $('.show').find('.mentortype').children("option:selected").val();
             // alert(valueSelected);
                changetype(valueSelected)
            
            $('.mentortype').on('change', function (e) {
                $('.school').parent().parent().addClass('hide');
                $('.school').parent().parent().removeClass('show');
                $('.branch').parent().parent().addClass('hide');
                $('.branch').parent().parent().removeClass('show');
                $('.tradecategory').parent().parent().addClass('hide');
                $('.tradecategory').parent().parent().removeClass('show');
                $('.college').parent().parent().addClass('hide');
                $('.college').parent().parent().removeClass('show');
               
                var valueSelected = this.value;
                //alert(valueSelected);
                changetype(valueSelected)
              
              
                
              });
              $('.level').on('change', function (e) {
                var valueSelected = this.value;
                changestatus(valueSelected)
               
              });
            $('.homewifi').on('change', function (e) {
                var valueSelected = this.value;
               if(valueSelected==='no'){                   
                   $('#s_q_library').parent().parent().removeClass('hide');
                    $('#s_q_library').parent().parent().addClass('show');
               }else{
                    $('#s_q_library').parent().parent().removeClass('show');
                    $('#s_q_library').parent().parent().addClass('hide');
               }
               
              });
              $('.student_pha_c').on('change', function (e) {
                var valueSelected = this.value;
               if(valueSelected==='yes'){                   
                   $('#s_q_community').parent().parent().removeClass('hide');
                    $('#s_q_community').parent().parent().addClass('show');
               }else{
                    $('#s_q_community').parent().parent().removeClass('show');
                    $('#s_q_community').parent().parent().addClass('hide');
               }
               
              });
              $('.tax_exempted').on('change', function (e) {
                var valueSelected = this.value;
               if(valueSelected==='yes'){           
            
                   $('#tax_certificate').parent().parent().removeClass('hide');
                    $('#tax_certificate').parent().parent().addClass('show');
               }else{
                    $('#tax_certificate').parent().parent().removeClass('show');
                    $('#tax_certificate').parent().parent().addClass('hide');
               }
               
              });
              $('.probation_parole').on('change', function (e) {
                var valueSelected = this.value;
               if(valueSelected==='yes'){           
            
                   $('#justice_officer').parent().parent().removeClass('hide');
                    $('#justice_officer').parent().parent().addClass('show');
               }else{
                    $('#justice_officer').parent().parent().removeClass('show');
                    $('#justice_officer').parent().parent().addClass('hide');
               }
               
              });
              
              function changetype(valueSelected){
                     $('.level').parent().parent().addClass('hide');
                    $('.level').parent().parent().removeClass('show');
                    $('.employeelist').parent().parent().addClass('hide');
                    $('.employeelist').parent().parent().removeClass('show');
                    $('.cataloglist').parent().parent().addClass('hide');
                    $('.cataloglist').parent().parent().removeClass('show');
                    $('.veteranlist').parent().parent().addClass('hide');
                    $('.veteranlist').parent().parent().removeClass('show');
                    $('.discharged').parent().parent().addClass('hide');
                    $('.discharged').parent().parent().removeClass('show');
                    $('.apprenticeship').parent().parent().addClass('hide');
                    $('.apprenticeship').parent().parent().removeClass('show');
                if(valueSelected == 'student'){
                    $('.level').parent().parent().removeClass('hide');
                    $('.level').parent().parent().addClass('show');
                     $('.homewifi').parent().parent().removeClass('hide');
                    $('.homewifi').parent().parent().addClass('show');
                     $('.student_q_home_pc').parent().parent().removeClass('hide');
                    $('.student_q_home_pc').parent().parent().addClass('show');
                     $('.student_q_stem_ind').parent().parent().removeClass('hide');
                    $('.student_q_stem_ind').parent().parent().addClass('show');
                     $('.student_q_reading_club').parent().parent().removeClass('hide');
                    $('.student_q_reading_club').parent().parent().addClass('show');
                     $('.student_pha_c').parent().parent().removeClass('hide');
                    $('.student_pha_c').parent().parent().addClass('show');
                     $('.year_graduate').parent().parent().removeClass('hide');
                    $('.year_graduate').parent().parent().addClass('show');
                    
                           
           $("#year_graduate").datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years",
    autoclose:true //to close picker once year is selected
});
                  }else{
                    $('.student_q_stem_ind').parent().parent().removeClass('show');
                    $('.student_q_stem_ind').parent().parent().addClass('hide');
                    $('.student_q_home_pc').parent().parent().removeClass('show');
                    $('.student_q_home_pc').parent().parent().addClass('hide');
                    $('.student_q_reading_club').parent().parent().removeClass('show');
                    $('.student_q_reading_club').parent().parent().addClass('hide');
                    $('.year_graduate').parent().parent().removeClass('show');
                    $('.year_graduate').parent().parent().addClass('hide');
                    $('.homewifi').parent().parent().removeClass('show');
                    $('.homewifi').parent().parent().addClass('hide');
                     $('#s_q_library').parent().parent().removeClass('show');
                    $('#s_q_library').parent().parent().addClass('hide');
                    $('.student_pha_c').parent().parent().removeClass('show');
                    $('.student_pha_c').parent().parent().addClass('hide');
                     $('#s_q_community').parent().parent().removeClass('show');
                    $('#s_q_community').parent().parent().addClass('hide');
                  }
                
                if(valueSelected == 'employee'){
                    $('.employeelist').parent().parent().removeClass('hide');
                    $('.employeelist').parent().parent().addClass('show');
                    $('.cataloglist').parent().parent().removeClass('hide');
                    $('.cataloglist').parent().parent().addClass('show');
                  }
                
                if(valueSelected == 'volunteer'){
                    $('.cataloglist').parent().parent().removeClass('hide');
                    $('.cataloglist').parent().parent().addClass('show');
                  }
                  if(valueSelected == 'justice'){
                    $('.apprenticeship').parent().parent().removeClass('hide');
                    $('.apprenticeship').parent().parent().addClass('show');
                    $('.probation_parole').parent().parent().removeClass('hide');
                    $('.probation_parole').parent().parent().addClass('show');
                    $('.sex_offender').parent().parent().removeClass('hide');
                    $('.sex_offender').parent().parent().addClass('show');
                    $('.expungement').parent().parent().removeClass('hide');
                    $('.expungement').parent().parent().addClass('show');
                  }else{
                            $('.apprenticeship').parent().parent().removeClass('show');
                    $('.apprenticeship').parent().parent().addClass('hide');
                    $('.probation_parole').parent().parent().removeClass('show');
                    $('.probation_parole').parent().parent().addClass('hide');
                    $('.justice_officer').parent().parent().removeClass('show');
                    $('.justice_officer').parent().parent().addClass('hide');
                    $('.sex_offender').parent().parent().removeClass('show');
                    $('.sex_offender').parent().parent().addClass('hide');
                    $('.expungement').parent().parent().removeClass('show');
                    $('.expungement').parent().parent().addClass('hide');
                  }
                 if(valueSelected == 'veteran'){
                    $('.discharged').parent().parent().removeClass('hide');
                    $('.discharged').parent().parent().addClass('show');
                    $('.veteranlist').parent().parent().removeClass('hide');
                    $('.veteranlist').parent().parent().addClass('show');
                    $('.tradecategory').parent().parent().removeClass('hide');
                    $('.tradecategory').parent().parent().addClass('show');
                    $('.military_base').parent().parent().removeClass('hide');
                    $('.military_base').parent().parent().addClass('show');

                    
                  }else{
                       $('.discharged').parent().parent().removeClass('show');
                    $('.discharged').parent().parent().addClass('hide');
                    $('.veteranlist').parent().parent().removeClass('show');
                    $('.veteranlist').parent().parent().addClass('hide');
                    $('.tradecategory').parent().parent().removeClass('show');
                    $('.tradecategory').parent().parent().addClass('hide');
                    $('.military_base').parent().parent().removeClass('show');
                    $('.military_base').parent().parent().addClass('hide');
                  }
                  
                  if(valueSelected == 'non_profit_org'){
                    $('.non_company').parent().parent().removeClass('hide');
                    $('.non_company').parent().parent().addClass('show');
                    $('.tax_exempted').parent().parent().removeClass('hide');
                    $('.tax_exempted').parent().parent().addClass('show');

                    
                  }else{
                       $('.non_company').parent().parent().removeClass('show');
                    $('.non_company').parent().parent().addClass('hide');
                       $('.tax_exempted').parent().parent().removeClass('show');
                    $('.tax_exempted').parent().parent().addClass('hide');
                       $('.tax_certificate').parent().parent().removeClass('show');
                    $('.tax_certificate').parent().parent().addClass('hide');
                  }
                if(valueSelected == 'small_business'){
                    $('.small_company').parent().parent().removeClass('hide');
                    $('.small_company').parent().parent().addClass('show');
                    $('.business_year').parent().parent().removeClass('hide');
                    $('.business_year').parent().parent().addClass('show');
                    $('.grant_opportunity').parent().parent().removeClass('hide');
                    $('.grant_opportunity').parent().parent().addClass('show');
                    $('.mayor').parent().parent().removeClass('hide');
                    $('.mayor').parent().parent().addClass('show');

                    
                  }else{
                       $('.small_company').parent().parent().removeClass('show');
                    $('.small_company').parent().parent().addClass('hide');
                       $('.business_year').parent().parent().removeClass('show');
                    $('.business_year').parent().parent().addClass('hide');
                       $('.grant_opportunity').parent().parent().removeClass('show');
                    $('.grant_opportunity').parent().parent().addClass('hide');
                       $('.mayor').parent().parent().removeClass('show');
                    $('.mayor').parent().parent().addClass('hide');
                  }
                
              }
              function changestatus(valueSelected){
                    $('.gradelevel').parent().parent().addClass('hide');
                    $('.gradelevel').parent().parent().removeClass('show');
                    $('.school').parent().parent().addClass('hide');
                    $('.school').parent().parent().removeClass('show');
                    $('.branch').parent().parent().addClass('hide');
                    $('.branch').parent().parent().removeClass('show');
                    $('.tradecategory').parent().parent().addClass('hide');
                    $('.tradecategory').parent().parent().removeClass('show');
                    $('.college').parent().parent().addClass('hide');
                    $('.college').parent().parent().removeClass('show');
                if(valueSelected == 'K-12'){
                    $('.gradelevel').parent().parent().removeClass('hide');
                    $('.gradelevel').parent().parent().addClass('show');
                    $('.school').parent().parent().removeClass('hide');
                    $('.school').parent().parent().addClass('show');

                   }else{
                            $('.gradelevel').parent().parent().removeClass('show');
                    $('.gradelevel').parent().parent().addClass('hide');
                  }
              
                if(valueSelected == 'military'){
                    $('.branch').parent().parent().removeClass('hide');
                    $('.branch').parent().parent().addClass('show');

                  }
               
                 if(valueSelected == 'vocational'){
                    $('.tradecategory').parent().parent().removeClass('hide');
                    $('.tradecategory').parent().parent().addClass('show');
                    $('.s_school').parent().parent().removeClass('hide');
                    $('.s_school').parent().parent().addClass('show');

                  }else{
                             $('.tradecategory').parent().parent().removeClass('show');
                    $('.tradecategory').parent().parent().addClass('hide');
                    $('.s_school').parent().parent().removeClass('show');
                    $('.s_school').parent().parent().addClass('hide');
                  }
                
                if(valueSelected == 'college'){
                    $('.college').parent().parent().removeClass('hide');
                    $('.college').parent().parent().addClass('show');

                  }
                
              }
         });
         $(document).ready(function() {
            $('.certify').select2({
        placeholder: 'Select',
        maximumSelectionLength: 1
        });
            $('.college').select2({
        placeholder: 'Select',
        maximumSelectionLength: 3 
        });
//        $('.school').select2({
//        placeholder: 'Select',
//        maximumSelectionLength: 3 
//        });
//        $('.gradelevel').select2({
//        placeholder: 'Select',
//        maximumSelectionLength: 1 
//        });
        $('.tradecategory').select2({
        placeholder: 'Select',
        maximumSelectionLength: 1 
        });
        $('.branch').select2({
        placeholder: 'Select',
        maximumSelectionLength: 1 
        });
        $('.employeelist').select2({
        placeholder: 'Select',
        maximumSelectionLength: 1 
        });
      
        $('.veteranlist').select2({
        placeholder: 'Select ',
        maximumSelectionLength: 1 
        });
        $('.apprenticeship').select2({
        placeholder: 'Select ',
        maximumSelectionLength: 1 
        });
        $('.select2').select2({
        placeholder: 'Select '
        });
        $('#school').select2({
        placeholder: 'Select ',
             maximumSelectionLength: 3 
        });
         $('.catlogcertifications').select2({
        placeholder: 'Select ',
        maximumSelectionLength: 1 
        });
        
});


</script>

@endpush