@extends('adminlte::page')

@section('title', 'إضافة منشور')

@section('content_header')
    <h1>إضافة منشور جديد</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.posts.store') }}">
                @csrf
                <div class="form-group">
                    <label>العنوان</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>الوصف</label>
                    <textarea name="description" class="form-control" maxlength="2048" required></textarea>
                </div>
                <div class="form-group">
                    <label>رقم التواصل</label>
                    <input type="text" name="contact_phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>صاحب المنشور</label>
                    <select name="user_id" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </form>
        </div>
    </div>
@endsection