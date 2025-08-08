@extends('adminlte::page')

@section('title', 'تعديل منشور')

@section('content_header')
    <h1>تعديل منشور</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.posts.update', $post->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>العنوان</label>
                    <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
                </div>
                <div class="form-group">
                    <label>الوصف</label>
                    <textarea name="description" class="form-control" maxlength="2048" required>{{ $post->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>رقم التواصل</label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ $post->contact_phone }}" required>
                </div>
                <div class="form-group">
                    <label>صاحب المنشور</label>
                    <select name="user_id" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($post->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">تحديث</button>
            </form>
        </div>
    </div>
@endsection