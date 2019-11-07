@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Admins') }}</div>
                    <div class="card-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>E-mail</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <th>{{ $admin->id }}</th>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        <a href="{{ route('admin.administrator.edit', ['admin' => $admin->id]) }}" class="btn btn-sm btn-outline-success">
                                            {{ __('Edit') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                            <tfoot>{{ $admins->links() }}</tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection