@extends('users.layouts.app')

@section('title')
ایجاد قرعه کشی جدید
@endsection

@section('content')



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>ایجاد قرعه کشی جدید</h3>
            </div>




        </div>
        <div class="clearfix"></div>
        <div class="row" style="padding-top: 10px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>ایجاد قرعه کشی
                            <small>فرم را با دقت پر نمایید</small>
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
                        <div class="alert alert-danger">
                    		@foreach ($errors->all() as $error)
                    			<li>{{$error}}</li>
                    		@endforeach
                        </div>
                    	@endif
	

                        <br/>
                        <form method="POST"  action="{{ route('lotteries.store') }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                        	@csrf
	
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">نام قرعه کشی
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="name" required="required" name="name" 
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">مبلغ وام (تومان)
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="amount" required="required" name="amount" onkeyup="javascript:this.value=itpro(this.value);"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>




                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="day">تاریخ شروع قرعه کشی (اولین قرعه)
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-2 col-xs-4">
                                    <input type="number" id="day" required="required" name="day" 
                                           class="form-control col-md-7 col-xs-12" min="1" max="31" value="{{Verta::tomorrow()->day}}">

                                </div>

                                <div class="col-md-2 col-sm-2 col-xs-4">
                                	<select id="month" name="month" class="form-control col-md-7 col-xs-12">
                                		@foreach (config('lottery.months') as $key => $value)

                                		<option value="{{$key}}" @if ($key == Verta::tomorrow()->month)
                                			selected="selected" 
                                		@endif>{{$value}}</option> 
                                		@endforeach	
                                	</select>

                                </div>

                                <div class="col-md-2 col-sm-2 col-xs-4">
                                	<input type="number" id="year" name="year" required="required" class="form-control col-md-7 col-xs-12" value="{{Verta::tomorrow()->year}}" min="{{Verta::tomorrow()->year}}" max="{{Verta::tomorrow()->year+1}}">
                                </div>

                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" > ساعت برگزاری قرعه کشی ها          <span class="required">*</span>         
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="hour" id="hour" class="form-control col-md-7 col-xs-12" type="number" value="17" min="0"max="24">

                            </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cycle">سیکل قرعه کشی
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<select id="cycle" name="cycle" required="required" class="form-control col-md-7 col-xs-12">
                                		@foreach (config('lottery.cycles') as $key => $cycle)
                                			<option @if ($cycle=='ماهیانه')
                                				selected="selected" 
                                			@endif value="{{$cycle}}">{{$cycle}}</option>
                                		@endforeach
                                		
                                	</select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="count_of_lots">تعداد اقساط
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="number" id="count_of_lots" required="required" name="count_of_lots" 
                                           class="form-control col-md-7 col-xs-12" value="20"min="1"max="100">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type_of_income">نوع درآمد شما
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<select name="type_of_income" id="type_of_income" required="required"
                                           class="form-control col-md-7 col-xs-12">
                                	@foreach (config('lottery.typesincome') as $key => $typeincome)
                                		<option @if ($key == 'firstlot')
                                			selected="selected" 
                                		@endif value="{{$key}}">{{$typeincome}}</option>
                                	@endforeach
                                	</select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type_of_choose_winner">نحوه ی انتخاب برنده
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                	<select id="type_of_choose_winner" name="type_of_choose_winner" required="required" class="form-control col-md-7 col-xs-12">
                                	@foreach (config('lottery.typeofchoosewinner') as $key => $value)
                                		<option @if ($key == 'سیستم')
                                			selected="selected" 
                                		@endif value="{{$key}}">{{$value}}</option>
                                	@endforeach
                                	</select>								
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="short_description">توضیحات کوتاه
                                    
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<textarea class="form-control col-md-7 col-xs-12" id="short_description" name="short_description"></textarea>

                                </div>
                            </div>


                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    
                                    <button type="submit" class="btn btn-success">ثبت مشخصات قرعه کشی</button>
                                    <a href="{{ route('home') }}" class="btn btn-warning">انصراف</a>
                                </div>
                            </div>

                        </form>
                    </div>
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