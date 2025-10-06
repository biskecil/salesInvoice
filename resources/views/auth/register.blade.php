@extends('layouts-client.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 60vh;">
        <div class="card shadow-sm" style="width: 400px;">
            <div class="card-body">
                

                <div class="text-center">
                    <img src="{!! asset('assets/images/favicon.png') !!}" class="w-px-40 h-auto rounded-circle me-2"
                        style="opacity:.9; width:100px; height:100px; object-fit:cover;">
                  
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

        
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                            name="username" value="{{ old('username') }}" required autofocus
                            placeholder="Masukkan username">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

      

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required placeholder="Masukkan password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                        <input id="password-confirm" type="password" class="form-control @error('password-confirm') is-invalid @enderror"
                            name="password_confirmation" " required placeholder="Masukkan password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    {{-- Tombol --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection
