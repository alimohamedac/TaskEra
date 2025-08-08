@extends('adminlte::page')

@section('title', 'إدارة المستخدمين')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>إدارة المستخدمين</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> إضافة مستخدم
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
                        <th>الاسم</th>
                        <th>اسم المستخدم</th>
                        <th>البريد الإلكتروني</th>
                        <th>رقم الجوال</th>
                        <th>عدد المنشورات</th>
                        <th>تاريخ التسجيل</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->posts->count() }}</td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm mr-1">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
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
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection