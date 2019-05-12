@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tin tức
                            <small>{{$tintuc->TieuDe}}</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                        <!--xử lý trường hợp lỗi-->
                        @if(count($errors)>0)
                        <div class = "alert alert-danger">
                            @foreach($errors->all() as $err)
                                {{$err}}
                            @endforeach
                        </div>
                        @endif

                        <!-- xử lý trường hợp ok -->
                        @if(session('Thongbao'))
                        <div class="alert alert-success">
                            {{session('Thongbao')}}
                        </div>
                        @endif
                        <form action="admin/tintuc/sua/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <div class="form-group">
                                <label>Chọn thể loại</label>
                                <select class="form-control" name="TheLoai" id= "TheLoai">
                                    @foreach($dsTheLoai as $tl)
                                    <option
                                    @if($tintuc->loaitin->theloai->id == $tl->id)
                                    {{"selected"}}
                                    @endif
                                    value="{{$tl->id}}">{{$tl->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Chọn loại tin</label>
                                <select class="form-control" name="LoaiTin" id = "LoaiTin">
                                    @foreach($dsLoaiTin as $lt)
                                    <option 
                                    @if($tintuc->loaitin->id == $lt->id)
                                    {{"selected"}}
                                    @endif
                                    value="{{$lt->id}}">{{$lt->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <input class="form-control" name="TieuDe" placeholder="Nhập tiêu đề" value="{{$tintuc->TieuDe}}" />
                            </div>

                            <div class="form-group">
                                <label>Tóm tắt</label>
                                <textarea name = "TomTat" id = "demo" class="form-control ckeditor" rows="3">
                                    {{$tintuc->TomTat}}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name = "NoiDung" id = "demo" class="form-control ckeditor" rows="5">
                                    {{$tintuc->NoiDung}}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <p>
                                <img width="400px" src="upload/tintuc/{{$tintuc->Hinh}}">
                                </p>
                                <input type="file" name="Hinh" class="form-control"/>

                            <div class="form-group">
                                <label>Nổi bật</label>
                                <label class="radio-inline">
                                    <input name="rdoStatus" value="0" 
                                    @if($tintuc->NoiBat == 0)
                                    {{"checked"}}
                                    @endif
                                    type="radio">Không
                                </label>
                                <label class="radio-inline">
                                    <input name="rdoStatus" value="1" 
                                    @if($tintuc->NoiBat == 1)
                                    {{"checked"}}
                                    @endif
                                    type="radio">Có
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $("#Theloai").change(function(){
                var idTheLoai = $(this).val();
                // alert(idTheLoai); để xem id thể loại ở trang localhost
                $.get("admin/ajax/loaitin/"+idTheloai,function($data){
                    $("#LoaiTin").html(data);
                }); //truyền id thể loại để nhận thể loại về
            });
        });
    </script>
@endsection