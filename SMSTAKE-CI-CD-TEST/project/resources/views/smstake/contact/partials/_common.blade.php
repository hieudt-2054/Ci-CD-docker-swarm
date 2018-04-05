    <div class="form-group group_id">
        {!! Form::label('group', 'Group:', ['class' => 'control-label']) !!}<span class="required">*</span>
        <div class="form-group {{ $errors->has('group_id') ? ' has-error' : '' }}">
            {!! Form::select('group_id', $groups->prepend('Select the appropriate  group', '') , null , ['class' => 'form-control', 'id' => 'group']) !!}
            <span class="help-block contactError required">
            </span>
        </div>
    </div>
    <div class="form-group contact_name">
        {!! Form::label('contactName', 'Contact Name:', ['class' => 'control-label']) !!}<span class="required">*</span>
        <div class="form-group {{ $errors->has('contact_name') ? ' has-error' : '' }}">
            {!! Form::text('contact_name', null, ['class' => 'form-control contactInput', 'placeholder' => 'Contact name']) !!}
            <span class="help-block contactError required">
            </span>
        </div>
    </div>
    <div class="form-group mobile_number">
        {!! Form::label('mobileNumber', 'Mobile Number:', ['class' => 'control-label']) !!}<span class="required">*</span>
        <div class="form-group {{ $errors->has('mobile_number') ? ' has-error' : '' }}">
            {!! Form::tel('mobile_number', null, ['class' => 'form-control contactInput', 'placeholder' => 'Mobile number']) !!}
            <span class="help-block contactError required">
            </span>
        </div>
    </div>
    <div class="form-group email">
        {!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}<span class="required">*</span>
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::email('email', null, ['class' => 'form-control contactInput', 'placeholder' => 'Enter your email' ]) !!}
            <span class="help-block contactError required">
            </span>
        </div>
    </div>
<div class="modal-footer">
    <div class="pull-left">
        <button type="button" class="btn btn-danger btn-rounded" id="dismis" data-dismiss="modal">CANCEL</button>
    </div>
    <input type="submit" class="btn-primary btn-rounded btn" value="{{ $btnName }}">
</div>