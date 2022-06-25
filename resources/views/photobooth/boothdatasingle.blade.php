
<?php $page = "photobooth"; ?>
<?php $page = "partner"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<style>
img.uploadedoverlay {
    height: 100px;
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
               
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Photobooth Count</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Photobooth Count</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

<div class="row mt-3">
                    <div class="col-md-12 col-lg-3 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                <i class="fab fa-facebook"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{ \App\Photoboothsharecount::where('count',1)->count() }}</h3>
                                <h6>Facebook</h6>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12 col-lg-3 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                <i class="fab fa-twitter"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{ \App\Photoboothsharecount::where('count',2)->count() }}</h3>
                                <h6>Twitter</h6>
                            </div>
                        </div>
                    </div>
                  
                    
                </div>

<br>

<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-md-responsive">
              
                                @if(!$boothdashboard->isEmpty())
                                <table class=" table table-hover table-center mb-0" id="myTable">
                                <thead class="thead-light">
                                    <tr>
                                      
                                        <th>User</th>
                                        <th>Image</th>
                                        <th>Platform</th>
                                       
                                     </tr>
                                </thead>
                                <tbody>
                                @foreach($boothdashboard as $key => $imagedata)
                                    <tr>
                                        <td>
                                            @if($imagedata->name != null)
                                            {{ $imagedata->name }}
                                            @else
                                            not available
                                            @endif
                                        </td>
                                        <td><img class="uploadedoverlay" src="{{ $imagedata->url }}" width:100 height:100 /></td>
                                         <td>
                                             @if($imagedata->count == '1')
                                         Facebook
                                         @else
                                           Twitter
                                         @endif


                                         </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                            </table>
                                     
                                    @else
                                    nothing to show
                                    @endif
                               
                </div>
            </div>
        </div>
    </div>
</div>



</div>
</div>
</div>
</div>
@endsection

@push('script')



<script type="text/javascript">
    

  
 
</script>

@endpush

