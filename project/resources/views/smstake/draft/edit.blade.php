{!! Form::model($draft, ['route' => ['draft.update', $draft->id], 'method' => 'PATCH', 'id' => 'updateDraft']) !!}
@include('smstake.draft.partials.form', ['btnName' => 'UPDATE'])
{!! Form::close() !!}