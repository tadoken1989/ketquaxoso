@extends('back.notify.template')

@section('form-open')
    <form method="post" action="{{ route('notify.store') }}">
@endsection