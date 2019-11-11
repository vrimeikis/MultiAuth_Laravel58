@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Roles') }}</div>
                    <div class="card-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Full access</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <th>{{ $role->id }}</th>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->full_access }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>
                                        <a href="{{ route('admin.role.edit', ['role' => $role->id]) }}" class="btn btn-sm btn-outline-success">
                                            {{ __('Edit') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                            <tfoot>{{ $roles->links() }}</tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection