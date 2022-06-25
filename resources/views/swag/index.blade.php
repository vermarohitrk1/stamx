<?php $page = "swag"; ?>
@extends('layout.dashboardlayout')
@push('css')
<style>

</style>
@endpush
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
                    <a href="{{ route('swag.create') }}" class="btn btn-sm btn btn-primary float-right m-0">
                        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                    </a>
                    <a href="{{ route('swagOption.index')}}" class="btn btn-sm btn btn-primary float-right  mr-2"
                        data-title="{{__('Swag Options')}}">

                        <span class="btn-inner--text ">{{__('Swag Options')}}</span>
                    </a>
                </div>

                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Swag</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Swag</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->

                <!-- Page card -->
                <div class="row mt-3" id="blog_category_view">
                    <br>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table mb-0" id="example">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class=" mb-0 h6 text-sm"> {{__('Details')}}</th>
                                                    <th class=" mb-0 h6 text-sm"> {{__('Status')}}</th>
                                                    <th class="text-right class=" name mb-0 h6 text-sm"">
                                                        {{__('Action')}}</th>

                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-md-12 d-flex justify-content-center paginationCss">
                            </div>
                        </div>

                    </div>
                    <!-- Page card end -->
                </div>
            </div>
        </div>
    </div>

    @endsection

    @push('script')
    <script type="text/javascript">
   
    //     var sort = 'all';
    //     var status = '';
    //     var keyword = '';
    //     ajaxFilterProjectView('all');




    //     // when change status
    //     $(".support-filter-actions").on('click', '.filter-action', function(e) {
    //         if ($(this).hasClass('filter-show-all')) {
    //             $('.filter-action').removeClass('active');
    //             $(this).addClass('active');
    //         } else {
    //             $('.filter-show-all').removeClass('active');
    //             if ($(this).hasClass('active')) {
    //                 $(this).removeClass('active');
    //                 $(this).blur();
    //             } else {
    //                 $(this).addClass('active');
    //             }
    //         }

    //         var filterArray = [];
    //         var url = $(this).parents('.support-filter-actions').attr('data-url');
    //         $('div.support-filter-actions').find('.active').each(function() {
    //             filterArray.push($(this).attr('data-val'));
    //         });

    //         status = filterArray;
    //         keyword = $('#support_keyword').val();

    //         ajaxFilterProjectView(sort, keyword, status);
    //     });

    //     // when change sorting order
    //     $('#support_sort').on('click', 'a', function() {
    //         sort = $(this).attr('data-val');
    //         keyword = $('#support_keyword').val();
    //         ajaxFilterProjectView(sort, keyword, status);
    //         $('#support_sort a').removeClass('active');
    //         $(this).addClass('active');
    //     });

    //     // when searching by support name
    //     $(document).on('keyup', '#support_keyword', function() {
    //         keyword = $(this).val();
    //         ajaxFilterProjectView(sort, keyword, status);
    //     });

    //     //pagination
    //     $(document).on('click', '.pagination a', function(e) {
    //         var paginationUrl = 'page=' + $(this).attr('href').split('page=')[1];
    //         ajaxFilterProjectView(sort, keyword, status, paginationUrl);
    //         e.preventDefault();
    //     });

    // });

    // // For Filter
    // var currentRequest = null;

    // function ajaxFilterProjectView(support_sort, keyword = '', status = '', page = '') {
    //     var mainEle = $('#ajax_response_view');
    //     @if($view == 'grid')
    //     var view = "grid";
    //     @else
    //     var view = "list";
    //     @endif
    //     var data = {
    //         view: view,
    //         sort: support_sort,
    //         keyword: keyword,
    //         status: status,
    //     }

    //     currentRequest = $.ajax({
    //         url: '{{ route('swag.view') }}?' + page,
    //         data: data,
    //         beforeSend: function() {
    //             if (currentRequest != null) {
    //                 currentRequest.abort();
    //             }
    //         },
    //         success: function(data) {
    //             mainEle.html(data.html);
    //             $('[id^=fire-modal]').remove();
    //             //loadConfirm();
    //         }
    //     });
    // }


    $(function() {
        var table = $('#example').DataTable({
             responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('swag.view') }}",
            columns: [
                //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
                // {data: 'image', name: 'image',orderable: false,searchable: false},
                {
                    data: 'image',
                    name: 'image'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });

    });
    </script>
    @endpush