@extends('layouts-client.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh;">
    <div class="card shadow-sm" style="width: 400px;">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">Login</h4>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" required placeholder="Masukkan password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

           

                {{-- Tombol --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

               
            </form>
        </div>
    </div>
</div>
@endsection
