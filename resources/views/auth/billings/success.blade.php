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
                        <h2 class="mt-2 mb-2">Status!</h2>
                        @if ($message)
                            <p>{!! $message !!}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
