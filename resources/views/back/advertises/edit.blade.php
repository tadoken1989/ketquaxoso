@extends('back.advertises.template')

@section('form-open')
    <form method="post" action="{{ route('admin.advertises.update', [$adv->id]) }}">
        {{ method_field('PUT') }}
@endsection
