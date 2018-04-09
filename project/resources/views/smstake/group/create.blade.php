{!! Form::open(['route' => 'group.store', 'method' => 'post', 'id' => 'addGroup']) !!}
@include('smstake.group.partials.form', ['btnName' => 'ADD'])
{!! Form::close() !!}