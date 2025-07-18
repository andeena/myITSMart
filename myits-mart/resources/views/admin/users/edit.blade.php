@extends('admin.layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <h1 class="h2">Edit Pengguna: {{ $user->name }}</h1>
    
    <div class="card mt-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="customer" @if(old('role', $user->role) == 'customer') selected @endif>Customer</option>
                        <option value="admin" @if(old('role', $user->role) == 'admin') selected @endif>Admin</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Pengguna</button>
                </div>
            </form>
        </div>
    </div>
@endsection