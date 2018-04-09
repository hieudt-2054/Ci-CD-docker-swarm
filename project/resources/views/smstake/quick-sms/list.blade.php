@extends('smstake.layouts.main')

@section('pageTitle','Manage Scheduled Sms')

@section('breadcrumb')
    <div class="pageheader">
        <h2><i class="fa fa-send"></i> Quick SMS</h2>
        <div class="breadcrumb-wrapper">
            {!! $breadcrumbs !!}
        </div>
    </div>
@endsection

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('smstake/css/myCustom.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/bootstrap-datepicker.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/loader.css') }}"/>
    <style>
        .filter{
            background: #c0c0c0;
            list-style: none;
            padding: 16px 24px;
        }

        .filter-element{
            display: inline-block;
            width:200px;
            max-width: 200px;
        }

        .filter .filter-element:last-child>button{
            display: block;
            width: 50%;
            margin: 0 auto;
        }

        #start-date, #end-date{
            display: inline-block;
            width: 46%;
        }
    </style>
@endsection

@section('MainContent')

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">
                <a href="" class="minimize">&minus;</a>
            </div>
            <h3 class="panel-title">MANAGE SCHEDULED SMS</h3>
        </div>
        <div class="panel-body">
            <div class="col-sm-12 mt-30">
                    <ul class="filter">
                        <li class="filter-element">
                            {!! Form::select('search-status',
                                [
                                    '' => 'Select the sms status',
                                    'W' => 'Waiting',
                                    'P' => 'Processing',
                                    'S' => 'Stop',
                                    'C' => 'Complete'
                                ] , null ,
                                [
                                    'class' => 'form-control',
                                    'id' => 'search-status'
                                ])
                            !!}
                        </li>
                        <li class="filter-element">
                            {!! Form::select('search-option',
                                [
                                    ''  => 'Select your filter option',
                                    '1' => 'Scheduled date',
                                    '2' => 'Created date',
                                    '3' => 'Sender-id'
                                ]
                                , null ,
                                [
                                    'class' => 'form-control',
                                    'id' => 'search-option'
                                ])
                            !!}
                        </li>
                        <li class="filter-element">
                            <div class="date-filter" style="display: none;">
                                <input type="text" name="start-date" id="start-date" placeholder="Start date"/>
                                <input type="text" name="end-date" id="end-date" placeholder="End date"/>
                            </div>
                            <div class="text-filter" style="display: none;">
                                <input type="text" name="sender-id" id="sender-id" placeholder="Sender-id"/>
                            </div>
                        </li>
                        <li class="filter-element pull-right">
                            <button class="btn btn-sm btn-rounded btn-primary" id="reset">Reset</button>
                        </li>
                    </ul>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="manageScheduledTable">
                        <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>MESSAGE</th>
                            <th>SENDER-ID</th>
                            <th>CREDITS</th>
                            <th>SCHEDULED DATE</th>
                            <th>CREATED DATE</th>
                            <th>STATUS</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('additional-scripts')
    <script type="text/javascript" src="{{ asset('smstake/js/swal2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript">
        var dataTableURL = '{{ route('quickSms.getDataTable') }}';
    </script>
    <script type="text/javascript" src="{{ asset('js/quickSMS/list-custom.js') }}"></script>
@endsection