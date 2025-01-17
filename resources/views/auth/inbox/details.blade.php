@extends('layouts.auth')

@section('title', 'Auth Dashboard')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="email-wrapper rounded border bg-white">
                <div class="row no-gutters justify-content-center">
                    <div class="col-lg-4 col-xl-3 col-xxl-2">
                        <div class="email-left-column email-options p-4 p-xl-5">
                            <ul class="pb-2">
                                <li class="d-block active mb-4">
                                    <a href="{{ route('auth.inbox.index') }}">
                                        <i class="mdi mdi-download mr-2"></i> Inbox</a>
                                    <span class="badge badge-secondary">20</span>
                                </li>
                                <li class="d-block mb-4">
                                    <a href="#">
                                        <i class="mdi mdi-playlist-edit mr-2"></i> Drafts</a>
                                </li>

                            </ul>

                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-9 col-xxl-10">
                        <div class="email-right-column p-4 p-xl-5">
                            <!-- Email Right Header -->
                            <div class="email-right-header mb-5">
                                <!-- head left option -->
                                <div class="head-left-options">
                                    <button type="button" class="btn btn-icon btn-outline btn-rounded-circle">
                                        <i class="mdi mdi-refresh"></i>
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle border rounded-pill" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">More
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                            x-placement="bottom-start"
                                            style="position: absolute; transform: translate3d(0px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- head right option -->
                                <div class="head-right-options">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn border btn-pill">
                                            <i class="mdi mdi-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn border btn-pill">
                                            <i class="mdi mdi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="border rounded email-details">

                                <div class="email-details-header">
                                    <h4 class="text-dark">Introducing our new tool</h4>
                                </div>

                                <div class="email-details-content">
                                    <div class="email-details-content-header">

                                        <div class="media media-sm mb-lg-0">
                                            <div class="media-sm-wrapper">
                                                <img src="{{  asset('assets/auth/images/user/user-sm-03.jpg')  }}" alt="User Image">
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 text-dark font-weight-bold">Larissa Gebhardt</h6>
                                                <span>
                                                    From:
                                                    <i class="mdi mdi-chevron-left"></i>@selena.oi
                                                    <i class="mdi mdi-chevron-right"></i>to me
                                                </span>
                                            </div>
                                        </div>

                                        <div class="email-details-content-header-right">
                                            <time class="p-1 p-xl-2">Mar 18</time>

                                            <a class="text-color p-1 p-xl-2" href="#">
                                                <i class="mdi mdi-star-outline"></i>
                                            </a>

                                            <a class="text-color p-1 p-xl-2" href="#">
                                                <i class="mdi mdi-attachment"></i>
                                            </a>

                                            <div class="btn-group p-1 p-xl-2" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-pill mdi mdi-reply"></button>
                                                <button type="button" class="btn btn-pill mdi mdi-printer"></button>
                                                <button type="button"
                                                    class="btn btn-pill mdi mdi-trash-can-outline"></button>
                                            </div>

                                            <div class="dropdown">

                                                <a class="btn dropdown-toggle icon-burger-mini" href="#"
                                                    role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <p class="pb-4">Hi Selena</p>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. ut enim ad minim veniam, quis nostrud
                                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                        irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                        pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                                        deserunt mollit anim id est laborum.
                                    </p>
                                    <br>
                                    <p>
                                        Perspiciatis unde omnis iste natus error sit voluptatem accusantium oloremque
                                        laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
                                        architecto.
                                    </p>
                                    <p class="pt-4">
                                        <i class="fa fa-paperclip ml-2"></i>
                                        <span class="text-dark">2 Attachments</span>
                                    </p>
                                    <div
                                        class="email-img d-inline-block rounded overflow-hidden mt-3 mt-lg-4 mr-2 mr-md-3 mr-lg-4">
                                        <img src="{{ asset('assets/auth/images/products/pa1.jpg') }}" alt="Product">
                                    </div>
                                    <div
                                        class="email-img d-inline-block rounded overflow-hidden mt-3 mt-lg-4 mr-2 mr-md-3 mr-lg-4">
                                        <img src="{{ asset('assets/auth/images/products/pa2.jpg') }}" alt="Product">
                                    </div>


                                    <div class="email-content-footer mt-5 pb-5 px-4 pt-4 border rounded">
                                        <p>Click here to
                                            <a class="text-blue btn btn-primary btn-pill ml-2" href="#">Reply</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')

@endsection
