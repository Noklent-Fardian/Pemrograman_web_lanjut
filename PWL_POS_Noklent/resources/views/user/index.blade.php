@extends('layouts.app')

@section('subtitle', 'User')
@section('content_header_title', 'Data User')
@section('content_header_subtitle', 'Management Data User')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data User</h3>
            <div class="card-tools">
                <a href="{{ url('/user/tambah') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i> Tambah User
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('status'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                    {{ session('status') }}
                </div>
            @endif
            {{ $dataTable->table() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush