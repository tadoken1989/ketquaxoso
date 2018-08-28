@extends('back.advertises.template')

@section('form-open')
    <form method="post" action="{{ route('admin.advertises.store') }}">
@endsection