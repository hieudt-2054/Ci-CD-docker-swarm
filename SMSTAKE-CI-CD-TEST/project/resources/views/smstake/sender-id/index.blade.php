@extends('smstake.layouts.main')

@section('pageTitle','Manage Sender ID')

@section('breadcrumb')
    <div class="pageheader">
        <h2><i class="fa fa-user-o"></i> Sender ID</h2>
        <div class="breadcrumb-wrapper">
            {!! $breadcrumbs !!}
        </div>
    </div>
@stop

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('smstake/css/toastr.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/jqueryui.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/jdaterangepicker.css') }}"/>
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
            <h3 class="panel-title">Sender ID Details</h3>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <a href="#" id="addSenderForm" class=" btn-primary btn btn-sm btn-rounded"><i class="fa fa-plus"></i> ADD</a>
            </div>
            <div class="col-sm-6 text-right">
                <a href="#" id="filterSender" class=" btn-warning btn btn-sm btn-rounded"><i class="fa fa-filter"></i> Filter</a>
            </div>

            <div class="col-sm-12 mt-30">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="senderID_table">
                        <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>SENDER ID</th>
                            <th>CREATED DATE</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div id="add-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Add New Sender </h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['route' => 'senderID.store', 'method' => 'post', 'id' => 'addSenderID']) !!}
                        <div class="form-group">
                            {!! Form::label('senderID', 'SENDER ID', ['class' => 'control-label']) !!}
                            <span class="required">*</span>
                        </div>
                        <div class="form-group {{ $errors->has('sender_name') ? ' has-error' : '' }}">
                            {!! Form::text('sender_name', null, ['class' => 'form-control senderIDInput', "placeholder" => "Sender ID", "maxlength" => "6"]) !!}
                            <span class="help-block senderIDError required">
                        <small class="text-danger">{{ $errors->first('sender_name') }}</small>
                   </span>
                        </div>
                        <div class="modal-footer">
                            <div class="pull-left">
                                <button type="button" class="btn btn-danger btn-rounded" id="dismis" data-dismiss="modal">CANCEL</button>
                            </div>

                            <input class="btn-primary btn-rounded btn" value="ADD" type="submit">
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div id="filter-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Filter options</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['method' => 'post', 'id' => 'search-sender-id', 'class' => "form-inline", "role" => "form"]) !!}
                        <div>
                            <div class="form-group">
                                <div class="form-label">
                                {!! Form::label('Status', 'Status:', ['class' => '']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-element">
                                    {!! Form::select('searchStatus', $statuses , null , ["class" => "form-control form-element-content", "id" => "searchStatus"]) !!}
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <div class="form-label">
                                {!! Form::label('Filter By', 'Filter By:', ['class' => '']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-element">
                                {!! Form::select('filterBy', $filterArray , null , ['class' => 'form-control form-element-content', "id" => "filterBy"]) !!}
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                            <div class="form-label"></div>
                            </div>
                            <div class="form-group">
                            <div class="form-element">
                                <div id="filterValue">
                                    {!! Form::text('filterValue', null, ['class' => 'form-control form-element-content', 'id' => 'filterData', 'style' => 'display: none;']) !!}
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="pull-left">
                                <button type="button" class="btn btn-danger btn-rounded" id="dismis" data-dismiss="modal">CANCEL</button>
                            </div>

                            <button type="submit" class="btn btn-primary btn-rounded btn-sm">
                                <i class="fa fa-search"></i>
                                SEARCH
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('additional-scripts')
    <script type="text/javascript" src="{{ asset('smstake/js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/select22.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/swal2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/jqueryui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/jdaterangepicker.js') }}"></script>
    <script type="text/javascript">
        var addSenderIDURL = '{{ route('senderID.store') }}';
        var dataTableURL = '{{ route('senderID.forDataTable') }}';
    </script>
    <script type="text/javascript" src="{{ asset('js/senderID/custom.js') }}"></script>
@endsection