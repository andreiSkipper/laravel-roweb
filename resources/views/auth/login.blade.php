@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="text-center">
                            LOG IN TO YOUR ACCOUNT
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user-circle-o faa-pulse animated"></i>
                                        </span>
                                        <input id="email" type="email" class="form-control" name="email"
                                               placeholder="E-mail Address"
                                               value="{{ old('email') }}" required autofocus>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block text-center">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-key faa-pulse animated"></i>
                                        </span>
                                        <input id="password" type="password" class="form-control" name="password"
                                               placeholder="Password" required>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="help-block text-center">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group text-center{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                {!! app('captcha')->display(); !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2 text-center">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2 text-center">
                                    <button type="submit" class="btn btn-primary col-xs-12 faa-parent animated-hover">
                                        <i class="fa fa-sign-in faa-horizontal"></i>
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>


                        <hr class="row">

                        <p class="text-center">
                            Log in with:
                        </p>

                        <?php
                        $fb = app(SammyK\LaravelFacebookSdk\LaravelFacebookSdk::class);
                        $login_url = $fb->getReAuthenticationUrl(Config::get('constants.facebook_permissions'));
                        ?>
                        <div class="form-group text-center">
                            <a href="<?= $login_url ?>" class="faa-parent animated-hover">
                                <span class="fa fa-facebook-official fa-3x faa-shake"
                                      title="Login with Facebook"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
