@extends('users.layouts.app')

@section('title')
درخواست های پشتیبانی
@endsection

@section('content')



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>درخواست های پشتیبانی</h3>
            </div>




        </div>
        <div class="clearfix"></div>
        <div class="row" style="padding-top: 10px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>تیکت                          <small>فرم را با دقت پر نمایید</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">تنظیمات 1</a>
                                    </li>
                                    <li><a href="#">تنظیمات 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                    	@if ($errors->any()>0)
                    		@foreach ($errors->all() as $error)
                    			<li>{{$error}}</li>
                    		@endforeach
                    	@endif
	

                        <br/>
                        <form method="POST"  action="{{ route('tickets.store') }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                            
                        	@csrf
	
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">عنوان
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="title" required="required" name="title" 
                                           class="form-control col-md-7 col-xs-12" value="{{old('title')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="body">متن 
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea type="text" id="body" required="required" name="body" value="{{auth()->user()->phone_number}}"  class="form-control col-md-7 col-xs-12"></textarea>
                                </div>
                            </div>

                            


                            




                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    
                                    <button type="submit" class="btn btn-success">ارسال</button>

                                    <a href="{{ route('home') }}" class="btn btn-warning">انصراف</a>
                                </div>
                            </div>

                        </form>
                    </div>


                </div>

                                <div class="x_panel">
                    <div class="x_title">
                        <h2>تیکت های قبلی                          <small>فرم را با دقت پر نمایید</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">تنظیمات 1</a>
                                    </li>
                                    <li><a href="#">تنظیمات 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        @if ($errors->any()>0)
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        @endif
    

                        <br/>
                     



                        <table class="table table-striped text-center">
                            <thead >
                            <tr >
                                  
                                <th class="text-center">عنوان</th>
                                
                                <th class="text-center">تاریخ</th>
                                <th class="text-center">وضعیت</th>
                                
                                
                                
                                
                            </tr>
                            </thead>

                            <tbody>
                          @foreach ($tickets as $ticket)

                                 
                                  <tr>
                                   <td class="text-center">
                                      <a href="{{ route('tickets.show',$ticket->id) }}">{{$ticket->title}}</a>
                                   </td>
                                  
                                   <td class="text-center">{{verta($ticket->created_at)->format('%Y/%m/j (H:i:s)')}}</td>
                                  
                                   <td class="text-center">{{$ticket->status}}</td>
                                    <td class="text-center">
                                      
                                   </td>
                                  
                                  
                                  </tr>

                              @endforeach


                            </tbody>
                        </table>                                












                </div>

            </div>
        </div>


    </div>
</div>
<!-- /page content -->

@endsection

@section('scripts')
<script>
	function itpro(Number) 
	  {
	       Number+= '';
	        Number= Number.replace(',', ''); Number= Number.replace(',', ''); Number= Number.replace(',', '');
	        Number= Number.replace(',', ''); Number= Number.replace(',', ''); Number= Number.replace(',', '');
	        x = Number.split('.');
	        y = x[0];
	        z= x.length > 1 ? '.' + x[1] : '';
	        var rgx = /(\d+)(\d{3})/;
	         while (rgx.test(y))
	          y= y.replace(rgx, '$1' + ',' + '$2');
	          return y+ z;
	  }

</script>

@endsection