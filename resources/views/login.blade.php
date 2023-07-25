@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>
                    <div class="card-body">
                        {{-- <form method="POST" action="{{ route('login.post') }}">
                            @csrf --}}
                        <span id="credential-errorr" style="display: none;color:red"></span>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="email" name="email" required autofocus>
                            <span id="email-error" style="display: none;color:red">Email is required</span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <span id="password-error" style="display: none; color:red"></span>

                        </div>
                        <div class="form-group mt-4 mb-4">
                            <div class="captcha">
                                <span>{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-danger" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                name="captcha">
                            <span id="captcha-error" style="display: none;color:red">Captcha is required</span>

                        </div>
                        <button type="submit" class="btn btn-primary login">Login</button>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('js/projects.js') }}" defer></script>
@section('scripts')
    <script>
        // Refresh CAPTCHA image on click
        $(document).on('click',
            '.login',
            function() {
                var email = $('#email').val();
                var password = $('#password').val();
                var captcha = $('#captcha').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url('/login/user') }}',
                    type: 'POST',
                    data: {
                        email: email,
                        password: password,
                        captcha: captcha
                    },
                    success: function(response) {
                        console.log(response.validator.password);
                        if (response.validator.password) {
                            $('#password-error').text(response.validator.password).show();
                        }
                        if (response.validator.email) {
                            $('#email-error').text(response.validator.email).show();
                        }
                        if (response.validator.captcha) {
                            $('#captcha-error').text(response.validator.captcha).show();
                        }
                        if (response.status == 400) {
                            $('#credential-error').text(response.message).show();

                        }


                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'reload-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
@endsection
