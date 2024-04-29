@extends('admin.apartments.my_apartments.layouts.create-or-edit')

@section('page-title', 'Edit apartment')


@section('form-action')
    {{ route('admin.my_apartments.update', $apartment) }}
@endsection

@section('form-method')
    @method('PUT')
@endsection