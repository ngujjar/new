@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100 form-wrapper">
    <div class="form-container">
        <h2 class="text-center mb-4">{{ isset($user) ? 'Edit' : 'Create' }} User</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($user)) @method('PUT') @endif

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile', $user->mobile ?? '') }}" required maxlength="10" minlength="10">
            </div>

            <div class="mb-3">
                <label for="profile_pic" class="form-label">Profile Picture</label>
                <input type="file" name="profile_pic" id="profile_pic" class="form-control" accept=".jpg, .jpeg, .png">
                @if(isset($user) && $user->profile_pic)
                    <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="Profile Picture" class="img-thumbnail mt-2" style="max-width: 100px;">
                @endif
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</div>

<style>
    body {
        background: linear-gradient(to right, #f7f8fa, #edf0f2);
        font-family: 'Helvetica Neue', sans-serif;
    }

    .form-wrapper {
        min-height: 100vh;
        padding: 20px;
        background: #f5f5f5;
    }

    .form-container {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 100%;
    }

    .form-label {
        font-weight: bold;
        font-size: 14px;
        color: #495057;
    }

    .form-control {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s ease-in-out;
    }

    .form-control:focus {
        border-color: #80bdff;
        outline: none;
        box-shadow: 0 0 5px rgba(128, 189, 255, 0.8);
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 12px;
        font-size: 16px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004b9b;
    }

    h2 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .img-thumbnail {
        max-width: 100px;
        height: auto;
        border-radius: 5px;
    }
</style>
@endsection
