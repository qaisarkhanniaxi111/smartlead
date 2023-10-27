@extends('layouts.auth')

@section('title', 'Auth Dashboard')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-xl-12">
                    <!-- Billing Information -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h2 class="mb-5">Billing Information</h2>

                        </div>

                        <div class="card-body">

                            <form method="post" action="{{ route('auth.billings.store') }}">
                            @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="firstName">Name</label>
                                            <input type="text" class="form-control" id="firstName" placeholder="Enter fullname">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="text-dark font-weight-medium">Country</label>
                                    <div class="form-group">
                                        <select class="country form-control select2-hidden-accessible" data-select2-id="1"
                                            tabindex="-1" aria-hidden="true">
                                            <option value="AL" data-select2-id="3">Alabana</option>
                                            <option value="NY">New York</option>
                                            <option value="VR">Virginia</option>
                                            <option value="WA">Washington</option>
                                            <option value="CA">California</option>
                                            <option value="WY">Wyoming</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="adress1">Address line 1</label>
                                    <input type="text" class="form-control" id="adress1" placeholder="Address line 1">
                                </div>

                                <div class="form-group mb-4">
                                    <label for="address2">Address line 2</label>
                                    <input type="text" class="form-control" id="address2" placeholder="Address line 2">
                                </div>


                                <div class="form-group mb-4">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" placeholder="City">
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="State">State</label>
                                            <input type="text" class="form-control" id="State" placeholder="State">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="zipCode">Zip code</label>
                                            <input type="text" class="form-control" id="zipCode" placeholder="Zip Code">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="city">Amount</label>
                                    <input type="text" name="amount" class="form-control" value="20">
                                </div>

                                <div class="d-flex justify-content-end mt-6">
                                    <button type="submit" class="btn btn-primary mb-2 btn-pill">Proceed to payment</button>
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

@endsection
