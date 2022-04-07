@extends('admin_layout');
@section('admin_content');

<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm Slider
                        </header>
                    <?php
                            $messages = Session::get('message');
                            if($messages){
                                echo '<span class="text-alert">',$messages. '</span>';
                                Session::put('message',null);
                            }
                            ?>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/insert-slider')}}" method="post" enctype="multipart/form-data">
                                   @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên Slider</label>
                                    <input type="text" name="slider_name" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file" name="silder_image" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả Slider</label>
                                    <textarea style="resize: none" rows="8"class="form-control" name="slider_desc"type="password" class="form-control" id="ckeditor" placeholder="Mô tả danh mục">

                                    </textarea>
                                </div>
                                <div class="form-group">
                                <select name="slider_status" class="form-control input-sm m-bot15">
                                    <option value="1">Ẩn</option>
                                    <option value="0">Hiển thị</option>
                                 
                                </select>
                               
                                <button type="submit" name="add_slider" class="btn btn-info">Thêm Slider</button>
                            </form>
</div>
@endsection