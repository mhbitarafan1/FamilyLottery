@extends('auth.layouts.master')

@section('content')




        <div class="animate form">
          <section class="login_content">
            





                      
            <form method="get" action="{{ route('show.activation.code2') }} ">
                
              <h1>ایجاد حساب</h1>
              <div>

                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="نام و نام خانوادگی" >

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror


              </div>
              <div>
                
                <input type="text" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone-number') }}" required autocomplete="phone_number" placeholder="شماره تلفن همراه">

                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>


              <div>
                <button type="submit" class="btn btn-primary">
                    ثبت نام
                </button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">در حال حاضر عضو هستید؟
                  <a href="{{ route('login') }}" class="to_register"> ورود </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©1397 تمامی حقوق محفوظ. Gentelella Alela! یک قالب بوت استرپ 3. حریم خصوصی و شرایط</p>
                </div>
              </div>
            </form>
          






          </section>
        </div>



@endsection
