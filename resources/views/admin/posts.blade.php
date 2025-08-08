@extends('adminlte::page')

@section('title', 'إدارة المنشورات')

@section('content_header')
    <h1>إدارة المنشورات</h1>
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
                            <td>
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