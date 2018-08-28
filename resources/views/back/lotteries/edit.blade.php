@extends('back.lotteries.template')

@section('form-open')
    <form method="post" action="{{ route('admin.result_lotteries.update', ['id'=>$resultLottery->id]) }}">
        {{ method_field('PUT') }}
@endsection
