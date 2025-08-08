@extends('adminlte::page')

@section('title', 'إضافة مستخدم')

@section('content_header')
    <h1>إضافة مستخدم جديد</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="form-group">
                    <label>الاسم</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>اسم المستخدم</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>رقم الجوال</label>
                    <input type="text" name="mobile" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </form>
        </div>
    </div>
@endsection