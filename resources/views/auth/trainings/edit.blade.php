@extends('layouts.auth')

@section('title', 'Training')

@section('css')
    <style>
        .hr-vertical {
            border-left: 0.5px solid gray;
            height: 200px;
            position: absolute;
            left: 50%;
        }
        .form-control {
            border-style: solid;
            border-color: black;
        }

        input[type=text]:focus {
            border: 1px solid black;
        }

        input[type=number]:focus {
            border: 1px solid black;
        }

        #textarea:focus {
            border: 1px solid black;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content">

            <div class="col-xl-12">

                <div class="card card-default">



                    <form method="post" action="{{ route('auth.trainings.update') }}">
                    @csrf
                    @method('PATCH')
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

                            <h4 class="mb-2">Company</h4>

                            <div class="row">

                                <div class="col-xl-12">
                                    <div class="form-group mb-3">
                                        <label>Name</label>
                                        <input type="text" name="company_name" value="{{ old('company_name', $userDetail ? $userDetail->company_name: '') }}" class="form-control" placeholder="Name">
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="company_description" class="form-control" id="textarea" style="resize: none" cols="10" rows="3" placeholder="Write description here">{{ old('company_description', $userDetail ? $userDetail->company_description: '') }}</textarea>
                                    </div>
                                </div>

                            </div>

                            <h4 class="mb-2 mt-2">Event Details</h4>

                            <div class="row">

                                <div class="col-xl-12">
                                    <div class="form-group mb-3">
                                        <label>Name</label>
                                        <input type="text" name="event_name" value="{{ old('event_name', $userDetail ? $userDetail->event_name: '') }}" class="form-control" placeholder="Name">
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Duration</label>
                                        <input type="number" name="event_duration" value="{{ old('event_duration', $userDetail ? $userDetail->event_duration_in_minutes: '') }}" class="form-control" placeholder="Duration in minutes">
                                    </div>
                                </div>

                            </div>

                            <!-- Response Training -->
                            <div class="mt-3" id="answer_div">


                                <h4 class="mb-2">Response Training</h4>

                                <div class="row">

                                    @if (count($responseTrainings) > 0)
                                        @foreach ($responseTrainings as $index => $training)

                                            <input type="hidden" name="responseTrainingIds[]" value="{{ $training->id }}">

                                            <div class="col-xl-6" style="padding-right: 30px">
                                                <div class="form-group">
                                                    <label>Reply from lead</label>
                                                    <input type="text" name="reply_from_lead[]"  value="{{ old('reply_from_lead.'.$index, isset($responseTrainings[$index]) ? $responseTrainings[$index]->reply_from_lead: '') }}" class="form-control" placeholder="Enter the reply from lead">
                                                </div>
                                            </div>

                                            <div class="col-xl-6" style="padding-right: 30px">
                                                <div class="form-group">
                                                    <label for="firstName">Ideal SDR response</label>
                                                    <textarea name="ideal_sdr_response[]" class="form-control" id="textarea" placeholder="What would be the ideal SDR response" cols="10" rows="5" style="resize: none">{{ old('ideal_sdr_response.'.$index, isset($responseTrainings[$index]) ? $responseTrainings[$index]->ideal_sdr_response: '') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <button class="responseDeleteBtn" data-id="{{ $training->id }}" style="float: right; margin-right:12px !important"><i class="fas fa-trash text-danger"></i></button>
                                            </div>
                                        @endforeach
                                    @else

                                        {{-- first row of tab 1  --}}
                                        <div class="col-xl-6" style="padding-right: 30px">
                                            <div class="form-group">
                                                <label>Reply from lead</label>
                                                <input type="text" name="reply_from_lead[]"  value="{{ old('reply_from_lead.0', isset($responseTrainings[0]) ? $responseTrainings[0]->reply_from_lead: '') }}" class="form-control" placeholder="Enter the reply from lead">
                                            </div>
                                        </div>

                                        <div class="col-xl-6" style="padding-right: 30px">
                                            <div class="form-group">
                                                <label for="firstName">Ideal SDR response</label>
                                                <textarea name="ideal_sdr_response[]" class="form-control" id="textarea" placeholder="What would be the ideal SDR response" cols="10" rows="5" style="resize: none">{{ old('ideal_sdr_response.0', isset($responseTrainings[0]) ? $responseTrainings[0]->ideal_sdr_response: '') }}</textarea>
                                            </div>
                                        </div>

                                        {{-- ==== second row of tab 1 === --}}
                                        <div class="col-xl-6" style="padding-right: 30px">
                                            <div class="form-group">
                                                <label>Reply from lead</label>
                                                <input type="text" name="reply_from_lead[]" value="{{ old('reply_from_lead.1', isset($responseTrainings[1]) ? $responseTrainings[1]->reply_from_lead: '') }}" class="form-control" value="Send some more info" placeholder="Enter the reply from lead">
                                            </div>
                                        </div>

                                        <div class="col-xl-6" style="padding-right: 30px">
                                            <div class="form-group">
                                                <label for="firstName">Ideal SDR response</label>
                                                <textarea name="ideal_sdr_response[]" class="form-control" id="textarea" placeholder="What would be the ideal SDR response" cols="10" rows="5" style="resize: none">{{ old('ideal_sdr_response.1', isset($responseTrainings[1]) ? $responseTrainings[1]->ideal_sdr_response: '') }}</textarea>
                                            </div>
                                        </div>

                                        {{-- third row of tab 1  --}}
                                        <div class="col-xl-6" style="padding-right: 30px">
                                            <div class="form-group">
                                                <label>Reply from lead</label>
                                                <input type="text" name="reply_from_lead[]" value="{{ old('reply_from_lead.2', isset($responseTrainings[2]) ? $responseTrainings[2]->reply_from_lead: '') }}" class="form-control" value="What's pricing?" placeholder="Enter the reply from lead">
                                            </div>
                                        </div>

                                        <div class="col-xl-6" style="padding-right: 30px">
                                            <div class="form-group">
                                                <label for="firstName">Ideal SDR response</label>
                                                <textarea name="ideal_sdr_response[]" class="form-control" id="textarea" placeholder="What would be the ideal SDR response" cols="10" rows="5" style="resize: none">{{ old('ideal_sdr_response.2', isset($responseTrainings[2]) ? $responseTrainings[2]->ideal_sdr_response: '') }}</textarea>
                                            </div>
                                        </div>

                                        {{-- fourth row of tab 1  --}}
                                        <div class="col-xl-6" style="padding-right: 30px">
                                            <div class="form-group">
                                                <label>Reply from lead</label>
                                                <input type="text" name="reply_from_lead[]" value="{{ old('reply_from_lead.3', isset($responseTrainings[3]) ? $responseTrainings[3]->reply_from_lead: '') }}" class="form-control" value="Do you have any case studies?" placeholder="Enter the reply from lead">
                                            </div>
                                        </div>

                                        <div class="col-xl-6" style="padding-right: 30px">
                                            <div class="form-group">
                                                <label for="firstName">Ideal SDR response</label>
                                                <textarea name="ideal_sdr_response[]" class="form-control" id="textarea" placeholder="What would be the ideal SDR response" cols="10" rows="5" style="resize: none">{{ old('ideal_sdr_response.3', isset($responseTrainings[3]) ? $responseTrainings[3]->ideal_sdr_response: '') }}</textarea>
                                            </div>
                                        </div>

                                    @endif
                                </div>

                            </div>

                            <!-- Add more fields -->
                            <div class="col-xl-12 mt-3">
                                <div class="form-group" style="float: right">
                                    <a id="answer_add_more_btn" title="press button to add more fields" class="btn btn-info">+</a>
                                </div>
                            </div>

                            <div class="col-12 text-center mt-1 mb-2">
                                <span id="max_attempt_error" style="font-size: 18px" class="error_msgs text-danger text-bold"></span>
                            </div><br>

                            <!-- Links Section -->
                            <div id="link_section_div">

                                <h4 class="mb-2">Links</h4>

                                <div class="row">

                                    {{-- first row of tab 1  --}}

                                    @if (count($links) > 0)

                                    @foreach ($links as $index => $link)

                                        <input type="hidden" name="link_ids[]" value="{{ $link->id }}">

                                        <div class="col-xl-6" style="padding-right: 30px">
                                            <div class="form-group">
                                                <input type="text" name="links_key[]" value="{{ old('links_key.'.$index, isset($links[$index]) ? $links[$index]->key: 'calendar') }}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-xl-6" style="padding-right: 30px">
                                            <div class="form-group">
                                                <input type="text" name="links_value[]" value="{{ old('links_value.0', isset($links[$index]) ? $links[$index]->value: '') }}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-xl-12 mb-2">
                                            <button class="linkDeleteBtn" data-id="{{ $link->id }}" style="float: right; margin-right:12px !important"><i class="fas fa-trash text-danger"></i></button>
                                        </div>
                                    @endforeach

                                    @else
                                    <div class="col-xl-6" style="padding-right: 30px">
                                        <div class="form-group">
                                            <input type="text" name="links_key[]" value="{{ old('links_key.0', isset($links[0]) ? $links[0]->key: 'calendar') }}" class="form-control">
                                        </div>

                                        <div class="form-group">
                                          <input type="text" name="links_key[]" value="{{ old('links_key.1', isset($links[1]) ? $links[1]->key: 'case study') }}" class="form-control">
                                        </div>

                                        <div class="form-group">
                                          <input type="text" name="links_key[]" value="{{ old('links_key.2', isset($links[2]) ? $links[2]->key: 'deck') }}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-xl-6" style="padding-right: 30px">
                                      <div class="form-group">
                                          <input type="text" name="links_value[]" value="{{ old('links_value.0', isset($links[0]) ? $links[0]->value: '') }}" class="form-control">
                                      </div>

                                      <div class="form-group">
                                        <input type="text" name="links_value[]" value="{{ old('links_value.1', isset($links[1]) ? $links[1]->value: '') }}" class="form-control">
                                      </div>

                                      <div class="form-group">
                                          <input type="text" name="links_value[]" value="{{ old('links_value.2', isset($links[2]) ? $links[2]->value: '') }}" class="form-control">
                                      </div>
                                    </div>
                                    @endif



                                </div>

                            </div>

                            <!-- Links Add more fields -->
                            <div class="col-xl-12 mt-3">
                                <div class="form-group mb-3" style="float: right">
                                    <a id="link_section_add_more_btn" title="press button to add more fields" class="btn btn-info">+</a>
                                </div>
                            </div>

                            <div class="col-12 text-center mt-1 mb-5">
                                <span id="link_section_max_attempt_error" style="font-size: 18px" class="error_msgs text-danger text-bold"></span>
                            </div>
                            <!-- End Links Add more fields -->

                            <!-- Tone Section-->
                            <h4 class="mb-2">Tone</h4>
                            <div class="card-body" id="tone_fields_div">

                                <h6>Comming soon</h6>

                            </div>
                            <!-- End Tone Section -->

                            <div>
                                <button class="btn btn-info btn-sm">Submit</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
@endsection

@section('scripts')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
        var max = 5;
        // var add = ;
        var answer_container = $("#answer_div");

        var x = 1; //input field count intially
        $("#answer_add_more_btn").click(function(e){

            $('.error_msgs').html('');

            e.preventDefault();

            if(x < max){
                x++;
                $(answer_container).append(`<div class="row">
                        <div class="col-xl-6" style="padding-right: 30px">
                            <div class="form-group">
                                <label>Reply from lead</label>
                                <input type="text" name="reply_from_lead[]" class="form-control" placeholder="Enter the reply from lead">
                            </div>
                        </div>

                        <div class="col-xl-6" style="padding-right: 30px">
                            <div class="form-group">
                                <label for="firstName">Ideal SDR response</label>
                                <textarea name="ideal_sdr_response[]" class="form-control" id="textarea" placeholder="What would be the ideal SDR response" cols="10" rows="5" style="resize: none"></textarea>

                            </div>
                        </div>
                        <a href="#" class="delete ml-3">Remove Fields</a>
                    </div>
                    `);

            }
            else {
                $('#max_attempt_error').html('You are reached to maximum limit');
            }
        });

        $(answer_container).on("click",".delete", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
</script>

<script>
    var max = 5;
    // var add = ;
    var link_section_container = $("#link_section_div");

    var z = 1; //input field count intially
    $("#link_section_add_more_btn").click(function(e){

        $('.error_msgs').html('');

        e.preventDefault();

        if(z < max){
            z++;
            $(link_section_container).append(`<div class="row">
                        <div class="col-xl-6" style="padding-right: 30px">
                              <div class="form-group">
                                  <input type="text" name="links_key[]" class="form-control">
                              </div>

                              <div class="form-group">
                                <input type="text" name="links_key[]" class="form-control">
                            </div>

                          </div>

                          <div class="col-xl-6" style="padding-right: 30px">

                            <div class="form-group">
                                <input type="text" name="links_value[]" class="form-control">
                              </div>

                            <div class="form-group">
                              <input type="text" name="links_value[]" class="form-control">
                            </div>
                          </div>
                          <a href="#" class="delete-section ml-3">Remove Fields</a>
                </div>
                `);

        }
        else {
            $('#link_section_max_attempt_error').html('You are reached to maximum limit');
        }
    });

    $(link_section_container).on("click",".delete-section", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); z--;
    })
</script>

<script>
    $(document).ready(function() {
        $('.responseDeleteBtn').click(function(e) {

            e.preventDefault();

            var responseTrainingId = $(this).data('id');

            if(confirm("Are You sure want to delete !")){

                $.ajax({
                type: "DELETE",
                url: "{{ route('auth.trainings.response-training.delete', '') }}" +'/'+ responseTrainingId,
                success: function (data) {

                    if (data.message) {
                        toastr["info"](data.message);
                    }

                    window.location.reload();
                },
                error: function (data) {

                    if(data.responseJSON.error){
                        toastr["error"](data.responseJSON.error);
                    }
                    else {
                        toastr["error"]('Something went wrong, please refresh webpage and try again, if still problem persist contact with administrator');
                    }

                }
                });

            }

        });

        $('.linkDeleteBtn').click(function(e) {

            e.preventDefault();

            var linkId = $(this).data('id');

            if(confirm("Are You sure want to delete !")){

                $.ajax({
                type: "DELETE",
                url: "{{ route('auth.trainings.links.delete', '') }}" +'/'+ linkId,
                success: function (data) {

                    if (data.message) {
                        toastr["info"](data.message);
                    }

                    window.location.reload();
                },
                error: function (data) {

                    if(data.responseJSON.error){
                        toastr["error"](data.responseJSON.error);
                    }
                    else {
                        toastr["error"]('Something went wrong, please refresh webpage and try again, if still problem persist contact with administrator');
                    }

                }
                });

            }

        });

    });
</script>

@endsection
