@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Admin edit') }}</div>
                    <div class="card-body">
                        <form action="{{ route('admin.administrator.update', ['admin' => $admin->id]) }}" method="post">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input id="name" class="form-control" name="name" type="text" value="{{ old('name', $admin->name) }}">
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-sm btn-outline-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection