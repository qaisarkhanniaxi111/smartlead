@extends('layouts.auth')

@section('title', 'Account')

@section('content')
<div class="content-wrapper">
    <div class="content"><!-- Card Profile -->
      <div class="row">
        <div class="col-xl-12">
          <!-- Account Settings -->

          <div class="card card-default">
            <div class="card-header">
              <h2 class="mb-5">Account Setting</h2>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

              <form method="post" action="#">
                @csrf
                <div class="row mb-2">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="firstName">API key</label>
                      <input type="text" name="api_key" value="{{ old('api_key', $user ? $user->api_key: '') }}" class="form-control" placeholder="1R0UCYTYin8Ab1K5VfAZjZu">
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                        <label for="newPassword">Webhook Url</label>
                        <input type="text" name="webhook_url" class="form-control" placeholder="https:/smartlead.com?user=32dekk5" autocomplete="off">
                    </div>
                  </div>

                </div>


                <div class="d-flex justify-content-end mt-6">
                  @if (! $user->google_refresh_token)
                    <a href="{{ route('google.login') }}" class="btn btn-info mr-1 btn-pill">Connect Google Calendar <i class="fas fa-calendar-alt"></i></a>
                  @else
                    <button type="submit" class="btn btn-success mr-1 btn-pill" disabled style="pointer-events: none">Google Calendar Connected <i class="fas fa-calendar-alt"></i></button>
                  @endif
                  <button type="submit" class="btn btn-primary btn-pill">Update Account</button>
                </div>

              </form>
            </div>
          </div>



        </div>
      </div>
    </div>
  </div>
@endsection
