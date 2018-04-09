<div class="form-group">
    {!! Form::label('group_name', 'Group Name:', ['class' => 'control-label']) !!}<span class="required">*</span>
</div>
<div class="form-group {{ $errors->has('group_name') ? ' has-error' : '' }}">
    {!! Form::text('group_name', null, ['class' => 'form-control groupInput',  'placeholder' => 'Group Name']) !!}
    <span class="help-block groupError required">
    </span>
</div>
<div class="modal-footer">
    <div class="pull-left">
        <button type="button" class="btn btn-danger btn-rounded" id="dismis" data-dismiss="modal">CANCEL</button>
    </div>
    <input type="submit" class="btn-primary btn-rounded btn" value="{{ $btnName }}">
</div>
