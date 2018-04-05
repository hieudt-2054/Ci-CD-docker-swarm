<div>
    @if($option === 'both' || $option === 'edit')
        <div class="actionBtn">
            <a href="#" class="btn btn-success btn-rounded btn-sm" id="{{ $updateFormId }}" data-identity="{{ $columnId }}" data-route="{{ $updateRoute }}">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                Edit
            </a>
        </div>
    @endif
    @if($option === 'both' || $option === 'delete')
        <div class="actionBtn">
            <a href="#" class="btn btn-danger btn-rounded btn-sm" id="{{ $deleteFormId }}" data-identity="{{ $columnId }}" data-route="{{ $deleteRoute }}">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
                Delete
            </a>
        </div>
    @endif
</div>
