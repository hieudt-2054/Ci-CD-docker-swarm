{!! Form::model($contact, ['route' => ['contact.update', $contact->id], 'method' => 'PATCH', 'id' => 'updateContact']) !!}
    @include('smstake.contact.partials._common', ['btnName' => 'UPDATE'])
{!! Form::close() !!}