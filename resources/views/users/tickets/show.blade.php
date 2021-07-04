@extends('users.layouts.app')

@section('title')
ویرایش پروفایل
@endsection

@section('content')



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3></h3>
            </div>




        </div>
        <div class="clearfix"></div>
 

        <div class="row" style="padding-top: 10px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>درخواست های قبلی                   <small>فرم را با دقت پر نمایید</small>
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




                





<div>

                                <h4>{{$ticket->title}}</h4>

                                <!-- end of user messages -->
                                <ul class="messages">
                       
                                 
                                      <li>
                                        <img 
                                        @if ($users->find($ticket->user_id)->avatar_url)
                                                src="{{$users->find($ticket->user_id)->avatar_url}}"
                                            @else
                                                src="/users/build/images/profile/user.png" 
                                            @endif

                                             class="avatar" alt="Avatar">
                                        <div class="message_date">
                                            <h3 class="date text-info">{{verta($ticket->created_at)->day}}</h3>
                                            <p class="month">{{verta($ticket->created_at)->format('%B')}}</p>
                                        </div>
                                        <div class="message_wrapper">
                                            <h4 class="heading">{{$users->find($ticket->user_id)->name}}</h4>
                                            <blockquote class="message">
                                                {{$ticket->body}}
                                            </blockquote>
                                            <br>
                                            
                                        </div>
                                    </li>
                                 
                                    
                                    

                                    @foreach ($ticketReplys as $ticketReply)
                                         <li>
                                        <img @if ($users->find($ticketReply->user_id)->avatar_url)
                                                src="{{$users->find($ticketReply->user_id)->avatar_url}}"
                                            @else
                                                src="/users/build/images/profile/user.png" 
                                            @endif
                                         class="avatar" alt="Avatar">
                                        <div class="message_date">
                                            <h3 class="date text-info">{{verta($ticketReply->created_at)->day}}</h3>
                                            <p class="month">{{verta($ticketReply->created_at)->format('%B')}}</p>
                                        </div>
                                        <div class="message_wrapper">
                                            <h4 class="heading">{{$users->find($ticketReply->user_id)->name}}</h4>
                                            <blockquote class="message">
                                                {{$ticketReply->body}}
                                            </blockquote>
                                            <br>
                                            
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                <!-- end of user messages -->

<form method="POST"  action="{{ route('tickets.store') }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                            
                            @csrf
    
                            <div class="form-group">
                                
                                <div hidden="hidden" class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="title" required="required" name="title" 
                                           class="form-control col-md-7 col-xs-12" value="{{$ticket->title}}">
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <div hidden="hidden" class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="parent" required="required" name="parent" 
                                           class="form-control col-md-7 col-xs-12" value="{{$ticket->id}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="body">پاسخ شما 
                                    
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea type="text" id="body" required="required" name="body" value="{{auth()->user()->phone_number}}"  class="form-control col-md-7 col-xs-12"></textarea>
                                </div>
                            </div>

                            


                            




                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    
                                    <button type="submit" class="btn btn-success">ارسال</button>

                                   
                                </div>
                            </div>

                        </form>

                            </div>



















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