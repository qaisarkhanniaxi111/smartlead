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

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h2 class="mt-2 mb-2">Webhook</h2>
                        <p> <strong>Lead Reply:</strong> {{ $userReply ? $userReply: '' }} </p>

                        <p> <strong>App Reply:</strong> {!! $result ? $result: '' !!} </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
