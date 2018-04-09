{!! Form::open(['route' => 'draft.store', 'method' => 'post', 'id' => 'addDraft']) !!}
@include('smstake.draft.partials.form', ['btnName' => 'ADD'])
{!! Form::close() !!}
