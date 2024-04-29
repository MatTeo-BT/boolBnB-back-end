@extends('admin.apartments.my_apartments.layouts.create-or-edit')
@section('page-title', 'Create apartment')
@section('form-action')
    {{ route('admin.my_apartments.store', $apartment) }}
@endsection

@section('form-method')
    @method('POST')
@endsection