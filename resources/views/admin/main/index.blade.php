@extends('layouts.main_layout')

@section('meta_description')aaa @endsection

@section('meta_keyword') 管理后台 @endsection

@section('CUSTOM_STYLE')

@endsection
@section('CUSTOM_SCRIPT')

@endsection
@section('content')
    <div class="row">
        <div class="col-lg-9 main-chart">
            <div class="row">
                <div class="col-md-offset-1 col-md-6">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1"></label>
                            <img src="{{ asset('images/default/thumb/timg.jpg') }}" style="width:120px;">
                            <input type="hidden" name="img" value="">
                        </div>
                        <div class="form-group">
                            <label for="name">账号名</label>
                            <input type="text" class="form-control" id="name" placeholder="name" name="name" >
                        </div>
                        <div class="form-group">
                            <label for="py">简拼</label>
                            <input type="text"  class="form-control" id="py" name="py" >
                        </div>
                        <div class="form-group">
                            <label for="pinyin">全拼</label>
                            <input type="text" class="form-control" id="pinyin"  name="pinyin" >
                        </div>
                        <div class="form-group">
                            <label for="description">描述</label>
                            <textarea class="form-control" rows="3"  name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="qq">qq</label>
                            <input type="text" class="form-control" id="qq" name="qq" >
                        </div>
                        <div class="form-group">
                            <label for="phone">电话</label>
                            <input type="text"class="form-control" id="phone"   name="phone"  >
                        </div>
                        <div class="form-group">
                            <label for="address">地址</label>
                            <input type="text" class="form-control" id="address" name="address" >
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">电子邮箱</label>
                            <input type="email" class="form-control" id="inputEmail3"  name="email">
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="control-label">昵称</label>
                            <input type="text" class="form-control" id="nickname" name="nickname">
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">性别</label>
                            <label class="radio-inline">
                                <input type="radio" name="sex" id="sex1" value="1"> 男
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sex" id="sex2" value="2"> 女
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sex" id="sex3" value="0"> 保密
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">保存</button>
                    </form>
                </div>
            </div>
        </div><!-- /col-lg-9 END SECTION MIDDLE -->


        <!-- **********************************************************************************************************************************************************
        RIGHT SIDEBAR CONTENT
        *********************************************************************************************************************************************************** -->

        <div class="col-lg-3 ds">
            <!--COMPLETED ACTIONS DONUTS CHART-->
            <h3>NOTIFICATIONS</h3>

            <!-- First Action -->
            <div class="desc">
                <div class="thumb">
                    <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                </div>
                <div class="details">
                    <p><muted>2 Minutes Ago</muted><br/>
                        <a href="#">James Brown</a> subscribed to your newsletter.<br/>
                    </p>
                </div>
            </div>
            <!-- Second Action -->
            <div class="desc">
                <div class="thumb">
                    <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                </div>
                <div class="details">
                    <p><muted>3 Hours Ago</muted><br/>
                        <a href="#">Diana Kennedy</a> purchased a year subscription.<br/>
                    </p>
                </div>
            </div>
            <!-- Third Action -->
            <div class="desc">
                <div class="thumb">
                    <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                </div>
                <div class="details">
                    <p><muted>7 Hours Ago</muted><br/>
                        <a href="#">Brandon Page</a> purchased a year subscription.<br/>
                    </p>
                </div>
            </div>
            <!-- Fourth Action -->
            <div class="desc">
                <div class="thumb">
                    <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                </div>
                <div class="details">
                    <p><muted>11 Hours Ago</muted><br/>
                        <a href="#">Mark Twain</a> commented your post.<br/>
                    </p>
                </div>
            </div>
            <!-- Fifth Action -->
            <div class="desc">
                <div class="thumb">
                    <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                </div>
                <div class="details">
                    <p><muted>18 Hours Ago</muted><br/>
                        <a href="#">Daniel Pratt</a> purchased a wallet in your store.<br/>
                    </p>
                </div>
            </div>

            <!-- USERS ONLINE SECTION -->
            <h3>TEAM MEMBERS</h3>
            <!-- First Member -->
            <div class="desc">
                <div class="thumb">
                    <img class="img-circle" src="{{ asset('admin/assets/img/ui-divya.jpg')}}" width="35px" height="35px" align="">
                </div>
                <div class="details">
                    <p><a href="#">DIVYA MANIAN</a><br/>
                        <muted>Available</muted>
                    </p>
                </div>
            </div>
            <!-- Second Member -->
            <div class="desc">
                <div class="thumb">
                    <img class="img-circle" src="{{ asset('admin/assets/img/ui-sherman.jpg') }}" width="35px" height="35px" align="">
                </div>
                <div class="details">
                    <p><a href="#">DJ SHERMAN</a><br/>
                        <muted>I am Busy</muted>
                    </p>
                </div>
            </div>
            <!-- Third Member -->
            <div class="desc">
                <div class="thumb">
                    <img class="img-circle" src="{{ asset('admin/assets/img/ui-danro.jpg') }}" width="35px" height="35px" align="">
                </div>
                <div class="details">
                    <p><a href="#">DAN ROGERS</a><br/>
                        <muted>Available</muted>
                    </p>
                </div>
            </div>
            <!-- Fourth Member -->
            <div class="desc">
                <div class="thumb">
                    <img class="img-circle" src="{{ asset('admin/assets/img/ui-zac.jpg') }}" width="35px" height="35px" align="">
                </div>
                <div class="details">
                    <p><a href="#">Zac Sniders</a><br/>
                        <muted>Available</muted>
                    </p>
                </div>
            </div>
            <!-- Fifth Member -->
            <div class="desc">
                <div class="thumb">
                    <img class="img-circle" src="{{ asset('admin/assets/img/ui-sam.jpg') }}" width="35px" height="35px" align="">
                </div>
                <div class="details">
                    <p><a href="#">Marcel Newman</a><br/>
                        <muted>Available</muted>
                    </p>
                </div>
            </div>
        </div><!-- /col-lg-3 -->
    </div><! --/row -->
@endsection

