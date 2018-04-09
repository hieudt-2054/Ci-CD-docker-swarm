@extends('smstake.layouts.main')

@section('pageTitle','Manage Contacts')

@section('breadcrumb')
    <div class="pageheader">
        <h2><i class="fa fa-user-o"></i>Contact</h2>
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
            </div><!-- panel-btns -->
            <h3 class="panel-title">Contact Details</h3>
        </div>
        <div class="panel-body">
            <div class="loader" style="display: none;"></div>
            {!! Form::open(['route' => 'contact.multiDelete', 'method' => 'post', 'id' => 'deleteSelected']) !!}
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group mt-30">
                            <a href="#" id="addContactForm" class="button btn-primary btn btn-sm btn-rounded"><i class="fa fa-plus"></i> ADD</a>
                        </div>
                    </div>
                    <div class="col-sm-10 text-right">

                        <div class="form-group mt-30">
                            <span id="deleteBtn" style="display: none;">
                                <span id="displayMultipleDeleteButton"></span>
                            </span>
                            <span class="selectToDelete" style="display: none;">
                                {!! Form::select('groupToDelete', $groups , null , ['class' => 'form-control', 'multiple' => 'multiple']) !!}
                                <span class="backToOption">Back</span>
                            </span>
                            <button class="button btn-warning btn btn-sm btn-rounded" id="groupDeleteOption">
                                <i class="fa fa-cog"></i>
                                OPTION
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-30">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="contact_table">
                        <thead>
                        <tr>
                            <th>
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" name="selectAll" id="selectAll"/>
                                    <span></span>
                                </label>
                            </th>
                            <th class="col-sm-1">S.N</th>
                            <th class="col-sm-3">GROUP NAME</th>
                            <th class="col-sm-3">CONTACT NAME</th>
                            <th class="col-sm-2">MOBILE NUMBER</th>
                            <th class="col-sm-2">CREATED DATE</th>
                            <th class="col-sm-1">ACTION</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            {!! Form::close() !!}
        </div><!-- panel-body -->
    </div><!-- panel -->

    <!-- ADD Modal -->
    <div id="add-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <!-- EDIT Modal -->
    {{--@include('smstake.contact.partials.edit')--}}

@endsection

@section('additional-scripts')
    <script type="text/javascript" src="{{ asset('smstake/js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/select22.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/swal2.js') }}"></script>
    <script type="text/javascript">
        var addContactURL = '{{ route('contact.store') }}';
        var dataTableURL = '{{ route('contact.forDataTable') }}';
        var addFormCommon = '{{ route('contact.getAddForm') }}';
        var multiDeleteURL = '{{ route('contact.multiDelete') }}';
    </script>
    <script type="text/javascript" src="{{ asset('js/contact/custom.js') }}"></script>
@endsection
