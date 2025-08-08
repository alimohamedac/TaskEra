@extends('adminlte::page')

@section('title', 'إدارة المنشورات')


@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>إدارة المنشورات</h1>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> إضافة منشور
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>الوصف</th>
                        <th>رقم التواصل</th>
                        <th>صاحب المنشور</th>
                        <th>تاريخ الإنشاء</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->short_description }}</td>
                            <td>{{ $post->contact_phone }}</td>
                            <td>{{ $post->user->name ?? '-' }}</td>
                            <td>{{ $post->created_at->format('Y-m-d') }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary btn-sm mr-1">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <form method="POST" action="{{ route('admin.posts.delete', $post->id) }}" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection