@extends('back.notify.template')

@section('form-open')
    <form method="post" action="{{ route('notify.update', [$notify->id]) }}">
        {{ method_field('PUT') }}
@endsection
