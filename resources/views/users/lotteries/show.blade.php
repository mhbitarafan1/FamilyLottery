@extends('users.layouts.app')


@section('title')
قرعه کشی {{$lottery->name}}
@endsection




@section('content')

<div class="right_col" role="main" style="min-height: 1208px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>قرعه کشی  {{$lottery->name}}
                    <small> طراحی</small>
                </h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="جست و جو برای...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">برو!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>مشاوره قراردادهای شریک جدید</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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

                        <div class="col-md-9 col-sm-9 col-xs-12">

                            <ul class="stats-overview">
                                <li>
                                    <span class="name"> بودجه تخمینی </span>
                                    <span class="value text-success"> 2300 </span>
                                </li>
                                <li>
                                    <span class="name"> مجموع پرداخت ها </span>
                                    <span class="value text-success"> 2000 </span>
                                </li>
                                <li class="hidden-phone">
                                    <span class="name"> تخمین مدت پروژه </span>
                                    <span class="value text-success"> 20 </span>
                                </li>
                            </ul>
                            <br>



                            <div>

                               
                                <div class="x_content">
                                    <div class="panel-body">
                                    <div  style="background-color: #c7ecee;color:#34495e " class="alert alert-dismissible fade in">

                                    <h3>قرعه پیش رو : </h3>
                                                                         <strong>قرعه شماره  : </strong>  {{$nextLot->number}}<br>
                                        <strong>تاریخ برگزاری: </strong>   {{verta($nextLot->time_holding)->format('j %B %Y ساعت G')}}<br>
                                        <strong>مبلغ قرعه: </strong>   {{number_format($nextLot->amount)}} تومان<br>

                                        <strong>سهام های بدهکار:</strong>

                                        @foreach ($nextLot->installments as $installment)

                                        @if ($installment->paid==0)

                                        {{$stocks->find($installment->lottery_stock_id)->number}}
                                        @endif
                                        @endforeach






                                        <br>

                                        @if (!$amIManager)
                                        @if ($amIMember)
                                        <input class="btn btn-warning btn-sm" type="submit" value="پرداخت قسط  این قرعه">
                                        @endif



                                        @else


                                        <form action="{{ route('installments.manage',$nextLot->id) }}">
                                            <input class="btn btn-warning btn-sm" type="submit" value="مدیریت اقساط این قرعه">

                                        </form>  



                                        @if ($lottery->type_of_choose_winner=='مدیر قرعه کشی' && $nextLot->time_holding < now())
                                        <br>
                                        <form method="post" class="form-inline" action="{{ route('lots.choose.winner') }}">
                                            @csrf

                                            <input type="hidden" id="lot_id" name="lot_id" value="{{$nextLot->id}}">







                                            @if ($lottery->type_of_income=='firstlot' && $nextLot->number==1)


                                            @if ($firstManagerStock = $lottery->lotterystocks->where('owner',$lotteryManagerUserId)->first())
                                            <div><label for="winnerId">انتخاب و معرفی برنده قرعه  ی شماره {{$nextLot->number}}: </label></div>
                                            <div class="input-group">
                                                <select class="form-control" name="stock_winner" id="stock_winner">
                                                    <option value="{{$firstManagerStock->id}}">سهام شماره ی {{$firstManagerStock->number}} متعلق به برگزار کننده ی قرعه کشی</option>
                                                </select> 
                                                <span class="input-group-btn">
                                                    <button onclick="return confirm('مطمئن هستید؟ \nدقت نمایید که پس از تایید امکان تغییر  برنده نمی باشد')" type="submit" class="btn btn-primary"><i class="fa fa-caret-left"></i> انتخاب  برنده</button>
                                                </span>
                                                @endif

                                                @else



                                                @if ($stocksDontWinned)

                                                @foreach ($stocksDontWinned as $stockDontWinned) 
                                                @php
                                                $paidInstallments = $stockDontWinned->installments->where('lot_id','<=',$nextLot->id)->where('paid',true);
                                                @endphp


                                                @if(count($paidInstallments) >= $nextLot->number)
                                                @php
                                                $inclodedStocksOnLotId[] =  $stockDontWinned->id;
                                                @endphp

                                                @endif
                                                @endforeach
                                                @endif

                                                @if(isset($inclodedStocksOnLotId))
                                                <div><label for="winnerId">انتخاب و معرفی برنده قرعه  ی شماره {{$nextLot->number}}: </label></div>
                                                <div class="input-group">
                                                    <select class="form-control" name="stock_winner" id="stock_winner">

                                                        @foreach ($inclodedStocksOnLotId as $inclodedStockOnLotId)
                                                        <option value="{{$inclodedStockOnLotId}}">سهام شماره ی {{$stocks->where('id',$inclodedStockOnLotId)->first()->number}} متعلق به 
                                                            @if ($stockUserId= $stocks->where('id',$inclodedStockOnLotId)->first()->owner)
                                                            {{$users->find($stockUserId)->name}}
                                                            @else
                                                            هیچکس
                                                            @endif

                                                        </option>
                                                        @endforeach

                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button onclick="return confirm('مطمئن هستید؟ \nدقت نمایید که پس از تایید امکان تغییر  برنده نمی باشد')" type="submit" class="btn btn-primary"><i class="fa fa-caret-left"></i>انتخاب  برنده </button>
                                                    </span>



                                                    @endif









                                                    @endif


                                                </div>

                                            </form>
                                            @endif


                                            @endif




                                        </div>
                                        @if ($lastLot)







                                         <div style="background-color: #ffeaa7;color:#7a5f17" class="alert alert-dismissible fade in">
                                        <h3 class="">قرعه قبلی: </h3>

                                      
                                            <strong>قرعه شماره  : </strong>  {{$lastLot->number}}<br>
                                            <strong>تاریخ برگزاری: </strong>   {{verta($lastLot->time_holding)->format('j %B %Y ساعت G')}}<br>
                                            <strong>مبلغ قرعه: </strong>   {{number_format($lastLot->amount)}} تومان<br>
                                            <strong>برنده ی قرعه کشی :</strong> @if ($winnerStockId=$lastLot->stock_winner)
                                            سهام شماره ی 
                                            {{$stocks->find($winnerStockId)->number}} متعلق به 

                                            @if($user= $users->find($stocks->find($winnerStockId)->owner))
                                            {{$user->name}}
                                            @else
                                            ...
                                            @endif
                                            @else
                                            ...
                                            @endif<br>
                                            <strong>سهام های بدهکار:</strong>

                                            @foreach ($lastLot->installments as $installment)

                                            @if ($installment->paid==0)

                                            {{$stocks->find($installment->lottery_stock_id)->number}}
                                            @endif
                                            @endforeach






                                            <br>
                                            @if (!$amIManager)
                                            @if ($amIMember)
                                            <input class="btn btn-warning btn-sm" type="submit" value="پرداخت قسط  این قرعه">
                                            @endif



                                            @else


                                            <form action="{{ route('installments.manage',$lastLot->id) }}">
                                                <input class="btn btn-warning btn-sm" type="submit" value="مدیریت اقساط این قرعه">

                                            </form>   


                                            @endif




                                        </div>

                                        @endif


                                    </div>

                                    
                                    </div>

                                    <h3> تاریخچه و اطلاعات تکمیلی: </h3>
                                    <div class="panel-body">
   

                                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                            <ul id="myTab1" class="nav nav-tabs bar_tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="#tab_content11" id="home-tabb" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">قرعه ها</a>
                                                </li>
                                                <li role="presentation" class=""><a href="#tab_content22" role="tab" id="profile-tabb" data-toggle="tab" aria-controls="profile" aria-expanded="false">سهام ها</a>
                                                </li>











                                                @if (!$amIManager)
                                                <li role="presentation" class=""><a href="#tab_content33" role="tab" id="profile-tabb3" data-toggle="tab" aria-controls="profile" aria-expanded="false">درخواست  من</a>
                                                </li>
                                                @else
                                                <li role="presentation" class=""><a href="#tab_content44" role="tab" id="profile-tabb4" data-toggle="tab" aria-controls="profile" aria-expanded="false">درخواست ها</a>
                                                </li>


                                                @endif




                                            </ul>
                                            <div id="myTabContent2" class="tab-content">
                                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">


                                                    <!-- start accordion -->
                                                    <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">




                                                        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">

                                                            @foreach ($lots as $lot)


                                                            <div class="panel">
                                                                <a class="panel-heading @if ($lot->number != 1)
                                                                    collapsed
                                                                    @endif" role="tab" id="heading{{$lot->number}}" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$lot->number}}" aria-expanded=" @if ($lot->number != 1)
                                                                    false
                                                                    @else
                                                                    true
                                                                    @endif" aria-controls="collapse{{$lot->number}}">
                                                                    <p class="panel-title">قرعه ی شماره {{$lot->number}} <i class="fa fa-caret-down"></i> </p>

                                                                </a>
                                                                <div id="collapse{{$lot->number}}" class="panel-collapse collapse @if ($lot->number == 1)
                                                                    in
                                                                    @endif" role="tabpanel" aria-labelledby="heading{{$lot->number}}">

                                                                    <div class="panel-body">
                                                                        <strong>تاریخ برگزاری: </strong>   {{verta($lot->time_holding)->format('j %B %Y ساعت G')}}<br>
                                                                        <strong>مبلغ قرعه: </strong>   {{number_format($lot->amount)}} تومان<br>
                                                                        @if ($winnerStockId=$lot->stock_winner)
                                                                        <strong>برنده ی قرعه کشی :</strong>
                                                                        سهام شماره ی 
                                                                        {{$stocks->find($winnerStockId)->number}} متعلق به 
                                                                        @if($user= $users->find($stocks->find($winnerStockId)->owner))
                                                                        {{$user->name}}
                                                                        @else
                                                                        ...
                                                                        @endif
                                                                        <br>
                                                                        @endif








                                                                        @if ($amIManager)
                                                                        <form action="{{ route('installments.manage',$lot->id) }}">
                                                                            <input class="btn btn-warning btn-sm" type="submit" value="مدیریت اقساط این قرعه">


                                                                        </form>
                                                                        @elseif($amIMember)


                                                                        <input class="btn btn-warning btn-sm" type="submit" value="پرداخت قسط  این قرعه">


                                                                        @endif




                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @endforeach


                                                        </div>


                                                    </div>
                                                    <!-- end of accordion -->
                                                </div>




                                                <div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="profile-tab">




                                                    <!-- start accordion -->
                                                    <div class="accordion" id="accordionOne" role="tablist" aria-multiselectable="true">
                                                        @foreach ($stocks as $stock)
                                                        <div class="panel">
                                                            <a class="panel-heading @if ($stock->number != 1)
                                                                collapsed
                                                                @endif" role="tab" id="headingOne{{$stock->number}}" data-toggle="collapse" data-parent="#accordionOne" href="#collapseOne{{$stock->number}}" aria-expanded="@if ($stock->number != 1)
                                                                false
                                                                @else
                                                                true
                                                                @endif" aria-controls="collapseOne{{$stock->number}}">
                                                                <p class="panel-title">سهام شماره ی {{$stock->number}} <i class="fa fa-caret-down"></i></p>
                                                            </a>
                                                            <div id="collapseOne{{$stock->number}}" class="panel-collapse collapse @if ($stock->number == 1)
                                                                in
                                                                @endif" role="tabpanel" aria-labelledby="headingOne{{$stock->number}}" >




                                                                <div class="panel-body">

                                                                    @if ($stock->owner)
                                                                    متعلق به
                                                                    {{$users->find($stock->owner)->name}}
                                                                    @if ($amIManager)
                                                                    <form method="post" action="{{ route('stocks.change.owner',$stock->id) }}">
                                                                        <input class="btn btn-warning btn-sm" type="submit" value="لغو مالکیت  این سهام">
                                                                        @csrf

                                                                    </form>
                                                                    @endif

                                                                    @else
                                                                    <form method="post" action="{{ route('add.stocks.for.manager',$stock->id) }}">
                                                                        <input class="btn btn-info btn-sm" type="submit" value="برداشتن این سهم برای خودم">
                                                                        @csrf

                                                                    </form>

                                                                    @endif
                                                                    <br>

                                                                    <strong>تعداد اقساط پرداخت شده:</strong>
                                                                    {{count($stock->installments->where('paid',true))}} قسط<br>
                                                                    <strong>مجموع پرداختی : </strong>
                                                                    {{number_format($stock->total_payment)}} تومن<br>
                                                                    <strong>قبلا برنده شده ؟ </strong>
                                                                    @if ($stock->winned)
                                                                    بله در قرعه ی شماره 
                                                                    {{$lots->where('stock_winner',$stock->id)->first()->number}}
                                                                    @else
                                                                    خیر
                                                                    @endif
                                                                    <br>

                                                                    <strong>تعداد اقساط پرداختی: </strong>
                                                                    {{count($stock->installments->where('paid',true))}} قسط

                                                                    <br>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach

                                                    </div>
                                                    <!-- end of accordion -->



                                                </div>

                                                @if (!$amIManager)
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content33" aria-labelledby="profile-tab">






                                                    @if ($myStockRequest)
                                                    شما درخواست 
                                                    @if ($myStockRequest->type_of_request=='buy')
                                                    خرید
                                                    @else
                                                    <strong>واگذاری</strong>
                                                    @endif
                                                    {{$myStockRequest->count_of_stock}} سهم داده اید . 

                                                    <form method="post" action="{{ route('stockrequests.destroy',$myStockRequest->id) }}">
                                                        @csrf
                                                        @method('delete')


                                                        <input type="submit" class="btn btn-danger" name="no" value="انصراف">
                                                    </form><br>
                                                    @else
                                                    شما هیچ درخواست بدون رسیدگی توسط مدیر ندارید ...
                                                    @endif





                                                </div>
                                                @else
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content44" aria-labelledby="profile-tab">



                                                    @if (count($stockRequests)==0)
                                                    هیچ درخواستی وجود ندارد...
                                                    @endif

                                                    @foreach ($stockRequests as $stockRequest)
                                                    <strong>{{$users->where('id',$lotteryMembers->where('id',$stockRequest->lottery_member_id)->first()->user_id)->first()->name}}</strong> درخواست  
                                                    @if ($stockRequest->type_of_request=='buy')
                                                    خرید
                                                    @else
                                                    <strong>واگذاری</strong>
                                                    @endif
                                                    {{$stockRequest->count_of_stock}} سهم دارد . آیا قبول می کنید :  


                                                    <form method="post" action="{{ route('stock.request.answer',$stockRequest->id) }}">
                                                        @csrf

                                                        <input type="submit" class="btn btn-success" name="yes" value="بله">
                                                        <input type="submit" class="btn btn-danger" name="no" value="خیر">
                                                    </form><br>








                                                    @endforeach









                                                </div>

                                                @endif




                                            </div>
                                        </div>

                                    </div>          








                                </div>


                            </div>

                            <!-- start project-detail sidebar -->
                            <div class="col-md-3 col-sm-3 col-xs-12">

                                <section class="panel">


                                    <div class="panel-body">
                                        {{-- <h3 class="green"><i class="fa fa-paint-brush"></i> عملیات ها</h3> --}}
                                        <div class="mtop20">
                                            @if (!$amIManager)
                                            @if($amIMember)
                                            <a href="{{ route('stockrequests.create',[$lottery->id,'buy']) }}" class="btn btn-primary">
                                                <i class="fa fa-arrow-circle-up"> </i>  خرید سهام بیشتر
                                            </a> 
                                            <a href="{{ route('stockrequests.create',[$lottery->id,'sell']) }}"  class="btn btn-danger">
                                                <i class="fa fa-arrow-circle-down"> </i> واگذاری سهام 
                                            </a> 


                                            @else
                                            <a href="{{ route('stockrequests.create',[$lottery->id,'buy']) }}" style="background-color: #05c46b;color:#fff"class="btn">
                                                <i class="fa fa-plus"> </i> 
                                                درخواست عضویت
                                            </a>
                                            @endif
                                            @else


                                            <form method="post" action="{{ route('lotteries.destroy',$lottery->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('مطمئن هستید؟ \nبعد از حذف دیگر امکان بازگردانی  اطلاعات نمی باشد')" class="btn btn-danger" type="submit" value="delete">حذف قرعه کشی</button>
                                            </form>




                                            @endif


                                        </div>

                                        <br>

                                        <div class="project_detail">

                                            <p class="title">شرکت مشتری</p>
                                            <p>شرکت مجازی</p>
                                            <p class="title">رهبر پروژه</p>
                                            <p>مرتضی کریمی</p>
                                        </div>

                                        <br>
                                        <h5>فایل های پروژه</h5>
                                        <ul class="list-unstyled project_files">
                                            <li><a href=""><i class="fa fa-file-word-o"></i>
                                            Functional-requirements.docx</a>
                                        </li>
                                        <li><a href=""><i class="fa fa-file-pdf-o"></i> UAT.pdf</a>
                                        </li>
                                        <li><a href=""><i class="fa fa-mail-forward"></i> Email-from-flatbal.mln</a>
                                        </li>
                                        <li><a href=""><i class="fa fa-picture-o"></i> Logo.png</a>
                                        </li>
                                        <li><a href=""><i class="fa fa-file-word-o"></i> Contract-10_12_2014.docx</a>
                                        </li>
                                    </ul>
                                    <br>


                                </div>

                            </section>

                        </div>
                        <!-- end project-detail sidebar -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection