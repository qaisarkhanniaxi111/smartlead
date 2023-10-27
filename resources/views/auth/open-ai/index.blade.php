@extends('layouts.auth')

@section('title', 'Auth Dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/auth/css/common.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <!-- <div class="content"> -->
    <div class="container " >
      <div class="row">
        <div class="col-lg-12">
          <div class="chat-area my-3">
            <div class="chat-messages">


            </div>
            <div class="chat-text">
              <input type="text" name="user-message" id="user-message" placeholder="Type here...">
              <button id="sendBtn" class="send-btn">
                Send
                <svg class="ml-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-send-fill" viewBox="0 0 16 16">
                  <path
                    d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- </div> -->
    </div>
  </div>
@endsection

@section('scripts')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    $(document).ready(function() {


      $('#sendBtn').click(function(event) {
        event.preventDefault();

        let user_message = $('#user-message').val();

        if (user_message) {
            sendMessage();
        }

      });


    $("#user-message").on( "keydown", function() {

        let user_message = $('#user-message').val();

        if (event.key === 'Enter') {

            if (user_message) {
                sendMessage();
            }

        }

    });

    });


    function sendMessage() {

        let user_message = $('#user-message').val();

        // $('#user-messages').append('<p>' + user_message + '</p>');

        $('.chat-messages').append(`
            <div class="send-message mb-3">
                <div class="send-message-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-globe" viewBox="0 0 16 16">
                    <path
                      d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z" />
                  </svg>
                </div>
                <div class="send-message-text">
                    ${user_message}
                </div>
              </div>
        `);

        $.ajax({
          type: 'POST',
          url: "{{ route('auth.open-ai.fetch') }}",
          data: { user_message },

          success: function(response) {

            $('.chat-messages').append(`
            <div class="recieved-message mb-3">
                <div class="recieved-message-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-person" viewBox="0 0 16 16">
                    <path
                      d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                  </svg>
                </div>
                <div class="recieved-message-text">
                  ${response.content}
                </div>
              </div>
            `);


            $('#user-message').val('');
          },
          error: function(xhr, textStatus, errorThrown) {
            console.log('Error:', errorThrown);
          }

        });

    }
</script>
@endsection
