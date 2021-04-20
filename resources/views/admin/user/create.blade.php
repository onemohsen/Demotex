@php
    $isEdit = $isEdit ?? false;
@endphp

@extends('layouts.app-admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{$isEdit ? 'ویرایش کاربر' : 'ایجاد کاربر'}}
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form
                            method="post"
                            @if($isEdit)
                            action="{{route('admin.users.update',$user->id)}}"
                            @else
                            action="{{route('admin.users.store')}}"
                            @endif
                        >
                            @csrf
                            @if($isEdit) @method('PATCH') @endif
                            <div class="form-group">
                                <label for="name">نام</label>
                                <input name="name" class="form-control" id="name" placeholder="نام"
                                       value="{{$user->name ?? ''}}"
                                       required
                                >
                            </div>

                            <div class="form-group">
                                <label for="email">ایمیل</label>
                                <input name="email" class="form-control" id="email" placeholder="test@test.com"
                                       value="{{$user->email ?? ''}}"
                                       required
                                >
                            </div>

                            @if(!$isEdit)
                                <div class="form-group">
                                    <label for="password">رمز عبور</label>
                                    <input name="password" class="form-control" id="password" type="password"
                                           value=""
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">رمز عبور</label>
                                    <input name="password_confirmation" class="form-control" id="password_confirmation"
                                           type="password"
                                           value=""
                                    >
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="role">نقش</label>
                                <select name="is_admin" id="role" class="form-control">
                                    <option value="0" @if($isEdit){{ !$user->is_admin ? 'selected' : '' }}@endif>
                                        کاربر
                                    </option>
                                    <option value="1" @if($isEdit){{ $user->is_admin ? 'selected' : '' }}@endif>
                                        مدیر
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">ثبت</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">بازگشت</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
