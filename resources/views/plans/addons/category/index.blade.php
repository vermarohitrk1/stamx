<?php $page = "Add-on"; ?>
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
               
       
        <a href="{{ route('plans.addons.category.create') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text "><i class="fa fa-plus" ></i> {{__('Add-On Category')}}</span>
    </a>
           
        <a href="{{ route('plans.addons') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text "><i class="fa fa-reply" ></i> </span>
    </a>
     
                   
                     </div>
                
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Add-Ons Categoty</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('book.get') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add-Ons Categoty</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

<div class="row mt-3" id="blog_category_view">
  
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body p-0">
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example">
                     <thead class="thead-light">
                      <tr> 
                               <th class="name mb-0 h6 text-sm"> {{__('Name')}}</th>
                                <th class="name mb-0 h6 text-sm text-left"> {{__('Action')}}</th>
                      </tr>
                      </thead>
                     
                  </table>
              </div>
          </div> 	
      </div>
  </div> 
    <!-- list view -->
</div>
    

            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection

@push('script')

   <script type="text/javascript">  



  $(function () {
            var table = $('#example').DataTable({
               responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('plans.addons.category') }}",
                columns: [
                    {data: 'name', name: 'name'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });  
</script>  



@endpush
