@extends('layout')

@section('page_title', 'Transfer Settings - ')

@section('content')
<div class="w-100">
    <div class="container">
        <h3 class="text-center">Transfer Settings</h3>
        <div class="col mt-5 mb-5 text-center">
            <form action="{{ route('settings') }}" method="POST" id="otp_form">
                {{ csrf_field() }}
                <div class="custom-control custom-switch my-4">
                    <input type="checkbox" class="custom-control-input inputfield" name="{{ $otp_setting->name }}" value="true" id="require_otp" {{ ($otp_setting->value == 'true') ? "checked" : "" }} />
                    <label class="custom-control-label" for="{{ $otp_setting->name }}">{{ $otp_setting->label_name }}</label>
                </div>
                <hr class="col-4 col-offset-4"/>

                <button type="submit" name="submit" value="settings" id="updateotp" class="btn btn-success mt-3">Update Settings</button>
            </form>
        </div>
        <hr>
        <div class="col mt-5 text-center">
            <a href="/" class="btn btn-primary">Go back</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha256-KsRuvuRtUVvobe66OFtOQfjP8WA2SzYsmm4VPfMnxms=" crossorigin="anonymous"></script>
    <script>
        document.querySelector("#updateotp").addEventListener("click", function(event) {
            event.preventDefault();
            swal({
                title: "Action!",
                text: "Confirm Change OTP Settings?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((confirmAction) => {
                if (confirmAction) {
                    document.getElementById('otp_form').submit();
                } else {
                    swal("Settings Unchanged!");
                }
            })
        }, false);
    </script>
@endsection