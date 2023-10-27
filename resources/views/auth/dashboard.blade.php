@extends('layouts.auth')

@section('title', 'Auth Dashboard')

@section('css')

@endsection

@section('content')
<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default text-dark">

                    <div class="card-body pt-4">
                        <h2 class="mt-2 mb-2">Getting Started</h2>
                        <p> <strong> Dashboard</strong> is structured and guide you in performing common functions.</p>
                    </div>

                    <!-- Button -->
                    <div class="d-flex justify-content-end pb-6 px-6"> <a href="{{ route('auth.trainings.edit') }}" class="btn btn-primary btn-pill">Train prompt
              <i class="mdi mdi-arrow-right"></i>
            </a> </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
