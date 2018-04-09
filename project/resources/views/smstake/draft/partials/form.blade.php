<div class="form-group">
    {!! Form::label('language', 'Language:', ['class' => 'control-label']) !!}<span class="required">*</span>
</div>
<div class="form-group {{ $errors->has('group_name') ? ' has-error' : '' }}">
    {!! Form::select('draft_type', array_merge($languages, ['' => 'select']) , null , ['class' => 'form-control', 'id' => 'draft_type']) !!}
    <span class="help-block draftError required">
    </span>
</div>
<div class="form-group">
    {!! Form::label('draft_message', 'Message:', ['class' => 'control-label']) !!}<span class="required">*</span>
</div>
<div class="form-group {{ $errors->has('group_name') ? ' has-error' : '' }}">
    {!! Form::textarea('draft_message', null, ['class' => 'form-control draftInput', 'id' => 'draft_message', 'placeholder' => 'Draft message']) !!}
    <span class="help-block draftError required">
    </span>
</div>
<div class="modal-footer">
    <div class="pull-left">
        <button type="button" class="btn btn-danger btn-rounded" id="dismis" data-dismiss="modal">CANCEL</button    >
    </div>
    <input type="submit" class="btn-primary btn-rounded btn" value="{{ $btnName }}">
</div>

