@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">User List</h2>
    <div class="mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
        <a href="{{ route('users.export.csv') }}" class="btn btn-success">Export CSV</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Profile Pic</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>
                        @if($user->profile_pic)
                            <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="Profile Picture" class="img-thumbnail">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tbody tr:hover {
        background-color: #e9ecef;
    }

    .btn {
        margin-right: 5px;
    }

    .img-thumbnail {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .text-muted {
        color: #6c757d;
    }
</style>
@endsection
