@extends('auth.layouts.master')

@section('content')
<div class="animate form">
  <section class="login_content">

<form method="post" action="{{ route('login2') }}">
        @csrf
      <h1>کد فعالسازی</h1>
      <div>
            <input id="active_code" type="text"  class="form-control @error('active_code') is-invalid @enderror" name="active_code" required autocomplete="active_code" autofocus >

            @error('active_code')
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
          <a href="aaa" class="to_register">ثبت نام</a>
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