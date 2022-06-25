<?php $page = "book"; ?>
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
            <div class="col-md-12 col-lg-12 col-xl-12">
              <a href="{{ route('dashboard') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
                  <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
             </a>
          </div>
   
                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Lead List</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Lead</li>
                                        <li class="breadcrumb-item active" aria-current="page"></li>
                                    </ol>
                                </nav>
                            </div>              
                        </div>            
                    </div>
                </div>
                <!-- /Breadcrumb -->



            <div class="col-md-12 col-lg-12 col-xl-12 no_padding">
                     <div class="card">
                            <div class="card-body">
                                <div class="table-md-responsive">
                                <!-- data -->
                                <table  style="width:100%;" class="table table-hover table-center mb-0" id="example">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Type')}}</th>
                            <th class=" mb-0 h6 text-sm" title="New Leads This Month"> {{__('New')}}</th>
                            <th class="text-left name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                        </thead> 
                        <tbody>
                            
                            @if(!$college->isEmpty())
                            @php
                            
                              $tilldate = \Carbon\Carbon::now()->addMonth(-1)->toDateTimeString();
                            @endphp
                            @foreach($college as $colleges)
                            <tr>
                            <td>{{ $colleges->institution->institution }}</td>
                            <td>College</td>
                                @php $collId = $colleges->institution->id??0;   @endphp
                             @php
                            $typecount = \App\Pathway::where('catalog', $collId)->where('mentor_type','college')->where("created_at", ">=", $tilldate)->with('user')->count();
     
                            @endphp
                            <td>{{$typecount}}</td>
                            @php 	$collId = encrypted_key($collId, 'encrypt') ?? $collId; @endphp 
                            <td><a class="btn btn-sm bg-success-light" data-title="Show College list" href="@php echo url(''); @endphp/my-lead/college/@php echo $collId; @endphp/user">
                                      <span>Show List</span><i class="fas fa-eye"></i>
                                   </a></td>
                             </tr>
                            @endforeach
                            @endif
                            @if(!$school->isEmpty())
                            @foreach($school as $colleges)
                            <tr>
                            <td>{{ $colleges->institution->institution }}</td>
                            <td>School</td>
                             @php $collId = $colleges->institution->id??0;  @endphp
                             @php
                            $typecount = \App\Pathway::where('catalog', $collId)->where('mentor_type','school')->where("created_at", ">=", $tilldate)->with('user')->count();
     
                            @endphp
                            <td>{{$typecount}}</td>
                            @php   	$collId = encrypted_key($collId, 'encrypt') ?? $collId; @endphp 
                            <td><a class="btn btn-sm bg-success-light" data-title="Show College list" href="@php echo url(''); @endphp/my-lead/school/@php echo $collId; @endphp/user">
                                      <span>Show List</span><i class="fas fa-eye"></i>
                                   </a></td>
                             </tr>
                            @endforeach
                            @endif
                            @if(!$military->isEmpty())
                            @foreach($military as $militaries)
                            <tr>
                            <td> @if($militaries->corporate_id == 'spaceforce')
                                {{ 'Space Force' }}
                                @endif
                                @if($militaries->corporate_id == 'coastguard')
                                {{ 'Coast guard' }}
                                @endif
                                @if($militaries->corporate_id == 'marinecorps')
                                {{ 'Marine Corps' }}
                                @endif
                                @if($militaries->corporate_id == 'airforce')
                                {{ 'Airforce' }}
                                @endif
                                @if($militaries->corporate_id == 'army')
                                {{ 'Army' }}
                                @endif
                                @if($militaries->corporate_id == 'navy')
                                {{ 'Navy' }}
                                @endif
                            </td>
                            <td>Military</td>
                               @php $collId = $militaries->corporate_id??0; @endphp
                             @php
                            $typecount = \App\Pathway::where('catalog', $collId)->where('mentor_type','military')->where("created_at", ">=", $tilldate)->with('user')->count();
     
                            @endphp
                            <td>{{$typecount}}</td>
                            <td>
                         
                            <a class="btn btn-sm bg-success-light" data-title="Show College list" href="@php echo url(''); @endphp/my-lead/military/@php echo $collId; @endphp/user">
                                      <span>Show List</span><i class="fas fa-eye"></i>
                                   </a></td>
                             </tr>
                            @endforeach
                            @endif
                            @if(!$veteran->isEmpty())
                            @foreach($veteran as $veterans)
                            <tr>
                            <td>
                            @if($veterans->corporate_id == 'spaceforce')
                                {{ 'Space Force' }}
                                @endif
                                @if($veterans->corporate_id == 'coastguard')
                                {{ 'Coast guard' }}
                                @endif
                                @if($veterans->corporate_id == 'marinecorps')
                                {{ 'Marine Corps' }}
                                @endif
                                @if($veterans->corporate_id == 'airforce')
                                {{ 'Airforce' }}
                                @endif
                                @if($veterans->corporate_id == 'army')
                                {{ 'Army' }}
                                @endif
                                @if($veterans->corporate_id == 'navy')
                                {{ 'Navy' }}
                                @endif
                            </td>
                            <td>Veteran</td>
                            
                            @php $collId = $veterans->corporate_id??0; @endphp
                             @php
                            $typecount = \App\Pathway::where('catalog', $collId)->where('mentor_type','veteran')->where("created_at", ">=", $tilldate)->with('user')->count();
     
                            @endphp
                            <td>{{$typecount}}</td>
                            <td><a class="btn btn-sm bg-success-light" data-title="Show College list" href="@php echo url(''); @endphp/my-lead/veteran/@php echo $collId; @endphp/user">
                                      <span>Show List</span><i class="fas fa-eye"></i>
                                   </a></td>
                             </tr>
                            @endforeach
                            @endif
                            @if(!$course->isEmpty())
                            @foreach($course as $courses)
                            @if(isset($courses->course->name))
                            <tr>
                            <td>
                                @if(isset($courses->course->name))
                                {{ $courses->course->name }}
                                @else
                                not available
                               @endif


                            </td>
                            <td>Justice</td>
                            @php
                            $typeid=$courses->course->id??0;
                            $typecount = \App\Pathway::where('catalog', $typeid)->where('mentor_type','justice')->where("created_at", ">=", $tilldate)->with('user')->count();
     
                            @endphp
                            <td>{{$typecount}}</td>
                            <td>
                            @if(isset($courses->course->id))
                            @php

                                $collId = $courses->course->id; 
                               	$collId = encrypted_key($collId, 'encrypt') ?? $collId; @endphp 
                                  <a class="btn btn-sm bg-success-light" data-title="Show College list" href="@php echo url(''); @endphp/my-lead/justice/@php echo $collId; @endphp/user">
                                      <span>Show List</span><i class="fas fa-eye"></i>
                                   </a>
                                   @else
                                not available
                               @endif
                                </td>
                             </tr>
                             @endif
                            @endforeach
                            @endif
                            @if($course->isEmpty() && $veteran->isEmpty() &&  $military->isEmpty() && $school->isEmpty() && $college->isEmpty())
                            <tr><td valign="top" colspan="2" class="dataTableempty">No data available in table</td> </tr>
                            @endif
                        </tbody>
                        
                    </table>
                                <!-- data -->
                                </div>
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

@endpush