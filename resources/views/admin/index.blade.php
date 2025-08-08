@extends('adminlte::page')

@section('title', 'لوحة التحكم')

@section('content_header')
    <h1>لوحة التحكم</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('admin.users') }}" class="btn btn-primary btn-block mb-3">إدارة المستخدمين</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('admin.posts') }}" class="btn btn-success btn-block mb-3">إدارة المنشورات</a>
        </div>
    </div>
@endsection
