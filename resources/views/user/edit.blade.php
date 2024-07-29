@extends('layouts.admin')

@section('title') Edit User @endsection

@section('content')

@push('page_style')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
@endpush

<!-- Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('farmers.index')}}">User</a>
                            </li>
                            <li class="breadcrumb-item active">Edit Farmer
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Farmer</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('farmers.update', encrypt($userObj->id)) }}">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="last_name">Last Name <span class="text-danger asteric-sign">&#42;</span></label>
                                            <input id="last_name" type="text" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ (old('last_name')) ? (old('last_name')) : ($userObj->last_name) }}" placeholder="Last Name">
                                            @if ($errors->has('last_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                            @endif
                                        
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="first_name">First Name <span class="text-danger asteric-sign">&#42;</span></label>
                                            <input id="first_name" type="text" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ (old('first_name')) ? (old('first_name')) : ($userObj->first_name) }}" placeholder="First Name">
                                            @if ($errors->has('first_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                        
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email">Email <span class="text-danger asteric-sign">&#42;</span></label>
                                            <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ (old('email')) ? (old('email')) : ($userObj->email) }}" placeholder="Enter Email" autocomplete="off">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="phone_number">Phone Number <span class="text-danger asteric-sign">&#42;</span></label><br>
                                        <input type="hidden" name="phone_code" id="phone_code" value="{{ old('phone_code', str_replace("+", "", $userObj->phone_code ?? '63')) }}"/>
                                        <input type="hidden" name="iso_code" id="iso_code" value="{{ old('iso_code', $userObj->iso_code ?? 'PH') }}"/>
                                        
                                        <input id="phone_number" type="text" class="form-control {{ $errors->has('phone_number') || $errors->has('phone_code') || $errors->has('iso_code') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number', $userObj->phone_number ?? '') }}">
                                        @if ($errors->has('phone_number'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('phone_number') }}</strong>
                                            </span>
                                        @elseif($errors->has('phone_code'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('phone_code') }}</strong>
                                            </span>
                                        @elseif($errors->has('iso_code'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('iso_code') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="dob">Birthdate <span class="text-danger asteric-sign">&#42;</span></label>
                                            <input id="dob" type="date" class="form-control {{ $errors->has('dob') ? ' is-invalid' : '' }}" name="dob" value="{{ (old('dob')) ? (old('dob')) : (date('Y-m-d', strtotime($userObj->dob))) }}" autocomplete="off">
                                        @if ($errors->has('dob'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('dob') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="gender">Gender <span class="text-danger asteric-sign">&#42;</span></label><br>\
                                        <input type="radio" id="male" name="gender" value="0" {{ ($userObj->gender == 0) ? "checked" : ""}}>
                                        <label for="male">Male</label><br>
                                        <input type="radio" id="female" name="gender" value="1"{{ ($userObj->gender == 1) ? "checked" : ""}}>
                                        <label for="female">Female</label><br>
                                        @if ($errors->has('gender'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('gender') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="region">Region <span class="text-danger asteric-sign">&#42;</span></label>
                                            {{-- <input id="region" type="text" class="form-control {{ $errors->has('region') ? ' is-invalid' : '' }}" name="region" value="{{ (old('region')) ? (old('region')) : ($userObj->region) }}" placeholder="Region">
                                            @if ($errors->has('region'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('region') }}</strong>
                                                </span>
                                            @endif --}}
                                            <select name="region" id="region" class="form-control {{ $errors->has('region') ? ' is-invalid' : '' }}">
                                                @foreach ($regionList as $region)
                                                    <option value="{{ $region->regcode }}" {{ ($userObj->region == $region->regcode) ? "selected" : "" }}>{{ $region->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('region'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('region') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="province">Province <span class="text-danger asteric-sign">&#42;</span></label>
                                            {{-- <input id="province" type="text" class="form-control {{ $errors->has('province') ? ' is-invalid' : '' }}" name="province" value="{{ (old('province')) ? (old('province')) : ($userObj->province) }}" placeholder="Province">
                                            @if ($errors->has('province'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('province') }}</strong>
                                                </span>
                                            @endif --}}
                                            
                                            <select name="province" id="province" class="form-control {{ $errors->has('province') ? ' is-invalid' : '' }}">
                                                @foreach ($provList as $province)
                                                    <option value="{{ $province->provcode }}" {{ ($userObj->province == $province->provcode) ? "selected" : "" }}>{{ $province->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('province'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('province') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="municipality">Municipality <span class="text-danger asteric-sign">&#42;</span></label>
                                            {{-- <input id="municipality" type="text" class="form-control {{ $errors->has('municipality') ? ' is-invalid' : '' }}" name="municipality" value="{{ (old('municipality')) ? (old('municipality')) : ($userObj->municipality) }}" placeholder="Municipality">
                                            @if ($errors->has('municipality'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('municipality') }}</strong>
                                                </span>
                                            @endif --}}
                                            <select name="municipality" id="municipality" class="form-control {{ $errors->has('municipality') ? ' is-invalid' : '' }}">
                                                @foreach ($munList as $municipality)
                                                    <option value="{{ $municipality->muncode }}" {{ ($userObj->municipality == $municipality->muncode) ? "selected" : "" }}>{{ $municipality->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('municipality'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('municipality') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="barangay">Barangay <span class="text-danger asteric-sign">&#42;</span></label>
                                            <input id="barangay" type="text" class="form-control {{ $errors->has('barangay') ? ' is-invalid' : '' }}" name="barangay" value="{{ (old('barangay')) ? (old('barangay')) : ($userObj->barangay) }}" placeholder="Barangay" oninput="toUpperCaseInput(this)">
                                            @if ($errors->has('barangay'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('barangay') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="role">Role <span class="text-danger asteric-sign">&#42;</span></label>
                                        {{-- <input id="role" type="text" class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" value="{{ (old('role')) ? (old('role')) : ($userObj->role) }}" placeholder="Role">
                                        @if ($errors->has('role'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('role') }}</strong>
                                            </span>
                                        @endif --}}

                                        <select name="role" id="role" class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}">
                                            @foreach ($roleList as $role)
                                                <option value="{{ $role->id }}" {{ ($userObj->role == $role->id) ? "selected" : "" }}>{{ $role->title }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('role'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('role') }}</strong>
                                            </span>
                                        @endif
                                        
                                    </div>
                                </div>

                    
                                <div class="col-12">
                                    <button type="Submit" class="btn btn-primary me-1">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Basic Floating Label Form section end -->

@push('page_script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script>

        var isoCode = ($("#iso_code").val()) ? ($("#iso_code").val()) : ('US');
        var isoCode2 = ($("#iso_code_2").val()) ? ($("#iso_code_2").val()) : ('US');
        //  phone 1 input
        var phoneInput = document.querySelector("#phone_number");
        var phoneInstance = window.intlTelInput(phoneInput, {
            autoPlaceholder: "off",
            separateDialCode: true,
            initialCountry: isoCode
            // utilsScript: '{{URL::asset("frontend/build/js/utils.js")}}',
        });


        $("#phone_code").val(phoneInstance.getSelectedCountryData().dialCode);
        $("#iso_code").val(phoneInstance.getSelectedCountryData().iso2);
        phoneInput.addEventListener("countrychange",function() {
            $("#phone_code").val(phoneInstance.getSelectedCountryData().dialCode);
            $("#iso_code").val(phoneInstance.getSelectedCountryData().iso2);
        });
        
    </script>
    <script>

        const clearLocation = (level) => {
            if(level == "region"){
                $("#province").empty();
                $("#municipality").empty();
                $("#barangay").empty();
            } else if (level == "province") {
                $("#municipality").empty();
                $("#barangay").empty();
            } else {
                $("#barangay").empty();
            }
        }

        $("#region").change(() => {
            clearLocation("region");
            let selected_region = $("#region").val();
            fetchData("region", selected_region);
        })

        $("#province").change(() => {
            clearLocation("province");
            let selected_province = $("#province").val();
            fetchData("province", selected_province);
        })

        $("#municipality").change(() => {
            clearLocation("municipality");
            fetchData("province", selected_province);
        })
        
        const fetchData = (level, code) => {

            let id_name = "";
            let location_name = "";
            let dropdown_id = "";

            if(level == "region"){
                id_name = "provcode";
                location_name = "name";
                dropdown_id = "province";
            } else {
                id_name = "muncode";
                location_name = "name";
                dropdown_id = "municipality";
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '../../calibrate/' + level + '/' + code,
                type: 'GET',

                success: function (data) {
                    console.log(data);

                    let html = "";
                    data.forEach(element => {
                        // html += `<option value="${element.id}">${element.category}</option>`;
                        html += `<option value="${ element[id_name] }">${ element[location_name] }</option>`;
                    });
                    $(`#${dropdown_id}`).empty().append(html);
                }
            });
        }

        const toUpperCaseInput = (input) => {
            input.value = input.value.toUpperCase();
        }
    </script>
@endpush

@endsection