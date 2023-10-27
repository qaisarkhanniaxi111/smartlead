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
                        <h2 class="mt-2 mb-2">Integrate Google Calendar</h2>
                    </div>

                    <!-- Button -->
                    <div class="d-flex justify-content-center pb-6 px-6"> <a href="{{ route('google.login') }}" class="btn btn-primary btn-pill">Google Calendar
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
