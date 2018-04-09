@extends('smstake.layouts.main')

@section('pageTitle','Manage Draft')

@section('breadcrumb')
    <div class="pageheader">
        <h2><i class="fa fa-users"></i> Draft</h2>
        <div class="breadcrumb-wrapper">
            {!! $breadcrumbs !!}
        </div>
    </div>
@endsection

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('smstake/css/toastr.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/myCustom.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/loader.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/datatable/custom.css') }}"/>
@endsection

@section('MainContent')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">
                <a href="" class="minimize">&minus;</a>
            </div>
            <h3 class="panel-title">Draft Details</h3>
        </div>
        <div class="panel-body">
            <div class="col-sm-12">
                <a href="#" id="addDraftForm" class=" btn-primary btn btn-sm btn-rounded"><i class="fa fa-plus"></i> ADD</a>
            </div>

            <div class="col-sm-12 mt-30">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="draft_table">
                        <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>MESSAGE</th>
                            <th>CREATED DATE</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="common-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <textarea name="draft_message" id="draft_message" cols="30" rows="10"></textarea>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('additional-scripts')
    <script type="text/javascript" src="{{ asset('smstake/js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/select22.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/swal2.js') }}"></script>
    <script src="{{ asset('/src/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
        var addDraftURL = '{{ route('draft.store') }}';
        var dataTableURL = '{{ route('draft.forDataTable') }}';
        var addFormCommon = '{{ route('draft.getAddForm') }}';
        var translateURL = '{{ route('google.translate') }}';
        var toggleURL = '{{ route('google.translate.toggle') }}';
    </script>
    <script type="text/javascript" src="{{ asset('js/draft/custom.js') }}"></script>
@endsection