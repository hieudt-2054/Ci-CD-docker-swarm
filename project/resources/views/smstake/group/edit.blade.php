{!! Form::model($group, ['route' => ['group.update', $group->id], 'method' => 'PATCH', 'id' => 'updateGroup']) !!}
    @include('smstake.group.partials.form', ['btnName' => 'UPDATE'])
{!! Form::close() !!}