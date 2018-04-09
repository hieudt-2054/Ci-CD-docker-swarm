{!! Form::open(['route' => 'contact.store', 'method' => 'post', 'id' => 'addContact']) !!}
@include('smstake.contact.partials._common', ['btnName' => 'ADD'])
{!! Form::close() !!}