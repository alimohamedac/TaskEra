@extends('adminlte::page')

@section('title', 'تعديل مستخدم')

@section('content_header')
    <h1>تعديل مستخدم</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>الاسم</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label>اسم المستخدم</label>
                    <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                </div>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label>رقم الجوال</label>
                    <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}" required>
                </div>
                <div class="form-group">
                    <label>كلمة المرور الجديدة (اختياري)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">تحديث</button>
            </form>
        </div>
    </div>
@endsection