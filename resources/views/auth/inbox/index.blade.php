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
                            <a href="email-compose.html" class="btn btn-block btn-primary btn-pill mb-4 mb-xl-5">Compose</a>
                            <ul class="pb-2">
                                <li class="d-block active mb-4">
                                    <a href="email-inbox.html">
                                        <i class="mdi mdi-download mr-2"></i> Inbox</a>
                                    <span class="badge badge-secondary">20</span>
                                </li>
                                <li class="d-block mb-4">
                                    <a href="#">
                                        <i class="mdi mdi-star-outline mr-2"></i> Favorite</a>
                                    <span class="badge badge-secondary">56</span>
                                </li>
                                <li class="d-block mb-4">
                                    <a href="#">
                                        <i class="mdi mdi-playlist-edit mr-2"></i> Drafts</a>
                                </li>
                                <li class="d-block mb-4">
                                    <a href="#">
                                        <i class="mdi mdi-open-in-new mr-2"></i> Sent Mail</a>
                                </li>
                                <li class="d-block mb-4">
                                    <a href="#">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i> Trash</a>
                                </li>
                            </ul>
                            <p class="text-dark font-weight-medium">Labels</p>
                            <ul>
                                <li class="mt-4">
                                    <a href="#">
                                        <i class="mdi mdi-checkbox-blank-circle-outline text-primary mr-3"></i>Work</a>
                                </li>
                                <li class="mt-4">
                                    <a href="#">
                                        <i class="mdi mdi-checkbox-blank-circle-outline text-warning mr-3"></i>Private</a>
                                </li>
                                <li class="mt-4">
                                    <a href="#">
                                        <i class="mdi mdi-checkbox-blank-circle-outline text-danger mr-3"></i>Family</a>
                                </li>
                                <li class="mt-4">
                                    <a href="#">
                                        <i class="mdi mdi-checkbox-blank-circle-outline text-success mr-3"></i>Friends</a>
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
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1">Select All</label>
                                    </div>
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
                            <div class="border border-top-0 rounded table-responsive email-list">
                                <table class="table mb-0 table-email">
                                    <tbody>
                                        <tr class="unread">
                                            <td class="mark-mail">
                                                <label class="control control-checkbox mb-0">
                                                    <input type="checkbox" />
                                                    <div class="control-indicator"></div>
                                                </label>
                                            </td>
                                            <td class="star">
                                                <i class="mdi mdi-star-outline"></i>
                                            </td>
                                            <td class="sender-name text-dark">
                                                Walter Reuter
                                            </td>
                                            <td class="">
                                                <a href="{{ route('auth.inbox.details') }}" class="text-default d-inline-block text-smoke">
                                                    <span class="badge badge-primary">New</span>
                                                    <span class="subject text-dark">
                                                        Statement belting with double
                                                    </span>
                                                    - Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit nihil
                                                    illum animi vitae beatae. Dolorum eos tempora ex autem voluptatum sint
                                                    voluptas, explicabo debitis perferendis distinctio labore quibusdam quam
                                                    quaerat quas architecto minus tempore.
                                                </a>
                                            </td>
                                            <td class="attachment">
                                                <i class="mdi mdi-paperclip"></i>
                                            </td>
                                            <td class="date">
                                                Mar 18
                                            </td>
                                        </tr>
                                        <tr class="read">
                                            <td class="mark-mail">
                                                <label class="control control-checkbox mb-0">
                                                    <input type="checkbox" />
                                                    <div class="control-indicator"></div>
                                                </label>
                                            </td>
                                            <td class="">
                                                <i class="mdi mdi-star-outline"></i>
                                            </td>
                                            <td class="sender-name text-dark">
                                                Antoine Chevallier
                                            </td>
                                            <td class="">
                                                <a href="{{ route('auth.inbox.details') }}"
                                                    class="text-default d-inline-block text-smoke">
                                                    <span class="subject text-dark">
                                                        Statement belting with double
                                                    </span>
                                                    - Duis nec ligula sed augue consequat mattis sed eget lacusq uisque erat
                                                    urna, gravida id orci in, euismod scelerisque tortor. In hac habitasse
                                                    platea dictumst. Aenean efficitur varius volutpat. Donec eu faucibus
                                                    leo. Quisque lacinia tempor quam sit amet consectetur.
                                                    </p>
                                            </td>
                                            <td class="attachment">

                                            </td>
                                            <td class="date">
                                                Mar 10
                                            </td>
                                        </tr>
                                        <tr class="unread">
                                            <td class="mark-mail">
                                                <label class="control control-checkbox mb-0">
                                                    <input type="checkbox" />
                                                    <div class="control-indicator"></div>
                                                </label>
                                            </td>
                                            <td class="">
                                                <i class="mdi mdi-star-outline"></i>
                                            </td>
                                            <td class="sender-name text-dark">
                                                Nicolas Dumas
                                            </td>
                                            <td class="">
                                                <a href="{{ route('auth.inbox.details') }}" class="text-default d-inline-block">
                                                    <span class="badge badge-primary">New</span>
                                                    <span class="subject text-dark">
                                                        Statement belting with double
                                                    </span>
                                                    - In hac habitasse platea dictumst. Morbi eu elit vitae nunc porttitor
                                                    ornare. Etiam tristique lorem leo, vitae eleifend arcu semper et. Sed
                                                    eget erat sit amet tortor ultrices vestibulum nec et nunc. Nunc lobortis
                                                    turpis mi, sit amet lacinia quam bibendum in.
                                                </a>
                                            </td>
                                            <td class="attachment">

                                            </td>
                                            <td class="date">
                                                Feb 20
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
