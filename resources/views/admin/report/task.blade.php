@extends('layouts.app-admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{route('admin.reports.task.filterDate')}}" class="form-inline">
                    @csrf
                    <div class="form-group m-3">
                        <label for="startDate" class="mr-2">تاریخ شروع</label>
                        <input type="date" name="startDate" id="startDate" class="form-control">
                    </div>
                    <div class="form-group mr-3">
                        <label for="endDate" class="mr-2">تاریخ پایان</label>
                        <input type="date" name="endDate" id="endDate" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">جستجو</button>
                </form>
                <div class="card">
                    <div class="card-header">گزارش کار کاربران</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">نام وظیفه</th>
                                <th scope="col">یادداشت</th>
                                <th scope="col">کاربر</th>
                                <th scope="col">تاریخ</th>
                                <th scope="col">زمان ایجاد</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($tasks as $task)
                                <tr>
                                    <td>{{$task->name}}</td>
                                    <td>{{$task->note}}</td>
                                    <td>{{$task->user->name}}</td>
                                    <td>{{$task->date}}</td>
                                    <td>{{$task->created_at}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">کاری یافت نشد</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $tasks->links() ?? '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
