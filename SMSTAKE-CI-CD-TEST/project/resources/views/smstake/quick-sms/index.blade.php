@extends('smstake.layouts.main')

@section('pageTitle','Quick Sms')

@section('breadcrumb')
    <div class="pageheader">
        <h2><i class="fa fa-send"></i> Quick SMS</h2>
        <div class="breadcrumb-wrapper">
            {!! $breadcrumbs !!}
        </div>
    </div>
@endsection

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('smstake/css/toastr.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/bootstrap.toggle.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/bootstrap-datetimepicker.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/myCustom.css') }}"/>
    <link rel="stylesheet" href="{{ asset('smstake/css/loader.css') }}"/>
@endsection

@section('MainContent')
    <div class="row" id="smsApp">
        {!! Form::open(['route' => 'quickSms.store', 'id' => 'submitSMS', 'method' => 'post']) !!}
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="" class="minimize">&minus;</a>
                    </div>
                    <h3 class="panel-title">@{{ title }}</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group{{ $errors->has('sender_id') ? ' has-error' : '' }}">
                        {!! Form::select('sender_id', $senderIds->prepend('Select the sender ID', '') , null , ['class' => 'form-control']) !!}
                        <span class="help-block smsError required">
                        </span>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#phone_number" data-toggle="tab"><strong>Numbers</strong></a></li>
                        <li><a href="#upload-file" data-toggle="tab"><strong>Upload File</strong></a></li>
                        <li><a href="#group_numbers" data-toggle="tab"><strong>Group</strong></a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }} tab-pane active" id="phone_number">
                            {!! Form::textarea('phone_number', null,
                                [
                                    'class' => 'form-control',
                                    'v-model' => 'message',
                                    'v-on:keydown' => 'isNumber',
                                    'id' => 'numbers',
                                    ':disabled' => '(selectedGroup >= 1) ? true : false',
                                    'placeholder' => 'The numbers must be comma separated'
                                ])
                            !!}
                            <p>
                                <strong>Total Phone numbers: @{{ phoneCount }}</strong>
                            </p>
                        </div>
                        <div class="tab-pane" id="upload-file">
                            <input type="file" name="csvFiles" style="display: none;" @change="onFileSelected" ref="fileInput">
                            <button @click.prevent="$refs.fileInput.click()">
                                <span>Select a File</span>
                                <span class="text-primary">Upload XLS/CSV files only</span>
                            </button>
                            <div v-text="selectedFileName"></div>
                        </div>
                        <div class="tab-pane" id="group_numbers">
                            <div class="form-group input-group">
                                {!! Form::select('group', $groups->prepend('Select the group', '') , null ,
                                    [
                                        'class' => 'form-control',
                                        'v-model' => 'selectedGroup',
                                        '@change.prevent'=> 'show_contacts(selectedGroup)'
                                    ])
                                !!}
                                <span class="input-group-addon">
                                    <span class="btn btn-alert btn-xs" v-if="(selectedGroup >= 1) ? true : false" @click.prevent="customSelect">Edit</span>
                                </span>
                            </div>
                            <div class="form-group">
                                {!! Form::textarea('group_numbers', null, ['class' => 'form-control',
                                    'v-model' => 'selected',
                                    'v-on:keydown' => 'isNumberGroup',
                                    ':disabled' => '(selectedGroup >= 1) ? false : true',
                                    'placeholder' => 'The numbers must be comma separated'])
                                !!}
                                <strong>Total Group Phone numbers: @{{ groupPhoneCount }}</strong>
                            </div>
                        </div>
                        <span class="help-block smsError required"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="" class="minimize">&minus;</a>
                    </div><!-- panel-btns -->
                    <h3 class="panel-title"><i class="fa fa-envelope"></i> Your Message</h3>
                </div>
                <div class="panel-body">
                    <form action="" class="form-horizontal">
                        <div class="col-lg-12">
                            <div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
                                <div class="input-group" id="language">
                                    <select name="language" v-model="selectedLang" class="form-control">
                                        <option v-for="lang in language" :value="lang.id">
                                            @{{ lang.name }}
                                        </option>
                                    </select>
                                    <div class="input-group-addon">
                                        <span class="btn btn-alert btn-xs" v-if="(selectedLang >= 1) ? true : false" @click="show_draft_messages">List Draft</span>
                                    </div>
                                </div>
                                <span class="help-block smsError required"></span>
                            </div>
                            <div class="form-group{{ $errors->has('text_message') ? ' has-error' : '' }} tab-pane active" id="text_message">
                                {!! Form::textarea('text_message', null,
                                    [
                                        'class' => 'form-control',
                                        ':disabled' => '(selectedLang >= 1) ? false : true',
                                        'v-model' => 'textMessage',
                                        'id' => 'text_message',
                                        'ref' => 'msg',
                                        'placeholder' => 'Enter your message'
                                    ])
                                !!}
                                <p style="margin-bottom: 0;" class="text-primary">
                                    <strong>@{{ textMessageCounter.characterCount }} @{{ textMessageCounter.characterNoun }}
                                        used, @{{ textMessageCounter.creditCount }} @{{ textMessageCounter.creditNoun }} used</strong>
                                    <input type="hidden" name="credit" :value="textMessageCounter.creditCount "/>
                                </p>
                            </div>
                            <span class="help-block smsError required"></span>
                            <div style="margin-top: 10px;" class="form-group">
                                {!! Form::label('scheduled required', 'Schedule Required:', ['class' => 'control-label']) !!}
                                <div>
                                    <label class="btn btn-default-alt btn-sm btn-rounded active">
                                        <input type="radio" name="is_schedule" v-model="schedule" value="1"> Required
                                    </label>
                                    <label class="btn btn-default-alt btn-sm btn-rounded">
                                        <input type="radio" name="is_schedule" v-model="schedule" value="0" checked=""> Not Required
                                    </label>
                                </div>
                                <div class="datetimepicker form-group{{ $errors->has('date_scheduled') ? ' has-error' : '' }}" v-show="schedule == 1 ? true : false">
                                    <div class="col-sm-6">
                                        <div class='input-group date date_scheduled' id='scheduleDateTimePicker'>
                                            {{--<input type='text' name="date_scheduled" class="form-control"/>--}}
                                            {!! Form::text('date_scheduled', null,
                                                [
                                                    'class' => 'form-control',
                                                    'v-model' => 'date_scheduled'
                                                ])
                                            !!}
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar open-datetimepicker"></span>
                                            </span>
                                        </div>
                                        <span class="help-block smsError required"></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success-alt btn-sm btn-rounded sendSMS" @click="isNumberValid"><i class="fa fa-send"></i>SEND</button>
                        </div>
                    </form>

                </div><!-- panel-body -->
            </div><!-- panel -->
        </div>
        {!! Form::close() !!}

        {{--modal popup for draft messages--}}
        <div id="draftList" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">List of messages in the system:</h4>
                    </div>
                    <div class="modal-body">
                        <div class="loader centerMargin" v-if="loading"></div>
                        <ul class="list-group">
                            <li class="list-group-item" v-for="draft in draftMessages">
                                <input type="radio" name="inProjectDraft" v-model="selectDraft" @change="setTheDraftMessage" :value="draft.draft_message"/> @{{ draft.draft_message }}
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <div class="pull-left">
                            <button type="button" class="btn btn-danger btn-rounded" id="dismis" data-dismiss="modal">CLOSE</button>
                        </div>
                        <input class="btn-primary btn-rounded btn" value="OK" type="submit" @click.prevent="setFocus">
                    </div>
                </div>
            </div>
        </div>

        {{--modal popup for custom group contacts--}}
        <div id="groupContacts" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Contacts in the group:</h4>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <input type="checkbox" v-model="selectAll"/> SELECT ALL
                            </li>
                            <li class="list-group-item" v-for="contact in groupContacts">
                                <input type="checkbox" name="groupContacts[]" v-model="selected" :value="contact.mobile_number"/> @{{ contact.mobile_number }}
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <div class="pull-left">
                            <button type="button" class="btn btn-danger btn-rounded" id="dismis" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('additional-scripts')
    <script type="text/javascript" src="{{ asset('smstake/js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/bootstrap.toggle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/bootstrap.datetimepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/select22.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('smstake/js/swal2.js') }}"></script>
    <script type="text/javascript">
        var addquickSMSURL = '{{ route('quickSms.store') }}';
    </script>
    <script type="text/javascript" src="{{ asset('js/quickSms.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/quickSMS/custom.js') }}"></script>
@endsection