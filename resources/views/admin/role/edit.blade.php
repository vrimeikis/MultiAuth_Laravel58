@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Role edit') }}</div>
                    <div class="card-body">
                        <form action="{{ route('admin.role.update', ['role' => $role->id]) }}" method="post">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input id="name" class="form-control" name="name" type="text"
                                       value="{{ old('name', $role->name) }}">
                            </div>

                            <div class="form-group">
                                <label for="full_access">{{ __('Full access') }}</label>
                                <input id="full_access" class="form-check" name="full_access" type="checkbox" value="1" @if (old('full_access', $role->full_access)) checked @endif>
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea id="description" name="description" class="form-control">{{ old('description', $role->description) }}</textarea>
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