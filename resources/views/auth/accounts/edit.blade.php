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

              <form method="post" action="{{ route('auth.accounts.update', $user ? $user->id: null) }}">
                @csrf
                <div class="row mb-2">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="firstName">SmartLead key</label>
                      <input type="text" name="smartlead_key" value="{{ old('smartlead_key', $user ? $user->smartlead_key: '') }}" id="input-class" class="form-control" placeholder="1R0UCYTYin8Ab1K5VfAZjZu">
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                        <label for="newPassword">Webhook Url</label>
                        <div id="webhook_parent_div">
                            <input type="text" name="webhook_url" value="{{ old('webhook_url', $user ? $user->webhook_url: '') }}" id="input-class" class="form-control mr-1 webhook-uri-input" placeholder="Click button to generate url" autocomplete="off" readonly>
                            <button id="webhook-uri-button" class="btn btn-primary">Create URL</button>
                        </div>
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

@section('scripts')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#webhook-uri-button').click(function(e) {

            e.preventDefault();

            $.ajax({
                url: "{{ route('webhook.generate.link') }}",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    console.log(response)
                    if (response.webhook_link) {
                        $('.webhook-uri-input').val(response.webhook_link);
                    }

                },
                error: function (data) {
                    if(data.responseJSON.error){
                        toastr["error"](data.responseJSON.error);
                    }
                    else {
                        toastr["error"]("Something went wrong, please refresh the webpage and try again. If still problem persists contact with administrator");
                    }
                }
            });

        });

    });
</script>
@endsection
