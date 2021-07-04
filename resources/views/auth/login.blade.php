@extends('auth.layouts.master')

@section('content')
<div class="animate form">
  <section class="login_content">
    








<form method="get" action="{{ route('show.activation.code') }}">
        
      <h1>فرم ورود</h1>
      <div>
            <input id="phone_number" type="text" pattern="[0]{1}[0-9]{10}" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number" autofocus placeholder="شماره تلفن همراه">

            @error('phone_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        

      </div>
     
 
      <div>
        <button class="btn btn-primary submit">ورود</button>
        
      </div>




      <div class="clearfix"></div>

      <div class="separator">
        <p class="change_link">
          <a href="{{ route('register') }}" class="to_register">ثبت نام</a>
        </p>

        <div class="clearfix"></div>
        <br />

        <div>
          <h1><i class="fa fa-paw"></i> سامانه قرعه کشی</h1>
          <p>تمامی حقوق محفوظ. </p>
        </div>
      </div>
    </form>







  </section>
</div>
@endsection