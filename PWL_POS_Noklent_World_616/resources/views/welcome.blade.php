@extends('layouts.template')

@section('content')
    <div class="welcome-dashboard">
        <!-- Welcome Header -->
        <div class="card welcome-header">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h1>Welcome, {{ $userData['nama'] ?? 'User' }}!</h1>
                        <p class="text-muted1">{{ now()->format('l, d F Y') }} | {{ $userData['levelName'] ?? 'Guest' }}</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <img src="{{ asset('img/logo_clean.png') }}" alt="Logo" class="welcome-logo" width="120">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .welcome-header {

            border-left: 4px solid #6a11cb;
            margin-bottom: 1.5rem;
            background: linear-gradient(-45deg, #3498db, #9b59b6, #1abc9c, #2980b9);
            animation: gradient 15s ease infinite;
            background-size: 400% 400%;
        }


        .welcome-header h1 {
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.25rem;
        }

        .welcome-logo {
            transition: transform 0.3s ease;
        }

        .welcome-logo:hover {
            transform: scale(1.05);
        }

        p.text-muted1 {
            color: #ffffff;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
@endpush
