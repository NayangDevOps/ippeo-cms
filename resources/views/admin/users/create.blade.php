@extends('layouts.admin')

@section('title', isset($user) ? 'Edit User' : 'Add User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">{{ isset($user) ? 'Edit User' : 'Add New User' }}</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

<form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST">
    @csrf
    @if(isset($user)) @method('PUT') @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name', $user->name ?? '') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email', $user->email ?? '') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="2">{{ old('address', $user->address ?? '') }}</textarea>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                            <option value="user" {{ old('role', $user->role ?? 'user') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password {{ isset($user) ? '(Leave blank to keep current)' : '' }} @if(!isset($user))<span class="text-danger">*</span>@endif</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" {{ isset($user) ? '' : 'required' }}>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label">Active Account</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save me-2"></i>{{ isset($user) ? 'Update' : 'Create' }} User
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
