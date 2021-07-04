@extends('auth.layouts.master')

@section('content')



        <div class="animate form">
          <section class="login_content">
            <!-- /password recovery -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
              <h1>بازیابی رمز عبور</h1>
              <div class="form-group has-feedback">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="form-control-feedback">
                  <i class="fa fa-envelope-o text-muted"></i>
                </div>
              </div>
              <button type="submit" class="btn btn-default btn-block">
                  {{ __('Send Password Reset Link') }}
              </button>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">جدید در سایت؟
                  <a href="#signup" class="to_register"> ایجاد حساب </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©1397 تمامی حقوق محفوظ. Gentelella Alela! یک قالب بوت استرپ 3. حریم خصوصی و شرایط</p>
                </div>
              </div>
            </form>
            <!-- Password recovery -->
          </section>
        </div>

@endsection








