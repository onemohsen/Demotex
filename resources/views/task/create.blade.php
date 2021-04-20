@php
    $isEdit = $isEdit ?? false;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{$isEdit ? 'ویرایش وظیفه' : 'ایجاد وظیفه'}}
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
                                action="{{route('tasks.update',$task->id)}}"
                            @else
                                action="{{route('tasks.store')}}"
                            @endif
                        >
                            @csrf
                            @if($isEdit) @method('PATCH') @endif
                            <div class="form-group">
                                <label for="name">نام</label>
                                <input name="name" class="form-control" id="name" placeholder="نام وظیفه"
                                       value="{{$task->name ?? ''}}">
                            </div>
                            <div class="form-group">
                                <label for="note">یادداشت</label>
                                <textarea
                                    name="note"
                                    class="form-control"
                                    id="note"
                                    placeholder="یادداشت"
                                >{{$task->note ?? ''}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">ثبت</button>
                            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">بازگشت</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
