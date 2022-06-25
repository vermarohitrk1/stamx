<?php $page = "Users"; ?>
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
                <div class="breadcrumb-bar mb-3">
                    
                    <div class="container-fluid">
                        
                        <div class="row align-items-center">
                            <div class="col-md-8 col-12">
                                <h2 class="breadcrumb-title">List of Followed / <a href="{{route('users.liked')}}" class="text-primary v-vistied" >Liked</a> Profiles </h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Followed Profiles</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-md-4 col-12">
                                <form class="search-form custom-search-form">
                                    <div class="input-group">
                                        <input id="s" type="text" placeholder="Search Favourites..." class="form-control">
                                        <div class="input-group-append">
                                            <button disabled="" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- /Breadcrumb -->

                <div id="data-holder">

                    
                </div>


            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection

@push('script')
<script>
    $(function () {
    var search = '';
    filter();
    });
    $("#s").keyup(function () {
    filter();
    });   
    
    
    //pagination
    $(document).on('click', '.pagination a', function (e) {
    var paginationUrl = 'page=' + $(this).attr('href').split('page=')[1];
    filter(paginationUrl);
    e.preventDefault();
    });
    

    function filter(page = '') {
    var search = $("#s").val();
    
            
    var data = {
    search: search,
            _token: "{{ csrf_token() }}",
    }
    $.post(
            "{{route('users.favourites')}}?" + page,
            data,
            function (data) {
            $("#data-holder").html(data.html);
            $(".pagify-pagination").remove();


            }
    );
    }
</script>
<script type="text/javascript">



    function ManageFavourite(id,type) {
        if (id != "") {
            var data = {
                id: id,
                type: type
            }
            $.ajax({
                url: '{{ route('users.change.favourite') }}',
                data: data,
                success: function (data) {
                filter();
                    show_toastr('Success!', "Favourite Removed!", 'success');
                }
            });
        }
    }

</script> 

@endpush


