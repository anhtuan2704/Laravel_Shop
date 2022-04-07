@extends('admin_layout');
@section('admin_content');
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê Slider
    </div>
    
    <div class="table-responsive">
                          <?php
                            $messages = Session::get('message');
                            if($messages){
                                echo '<span class="text-alert">',$messages. '</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên Slider</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Tình trạng</th>
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_slider as $key => $slider)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$slider->slider_name}}</td>
            <td><span class="text-ellipsis">
            <?php
              if($slider->slider_status==0){
                ?>
                <a href="{{URL::to('/unactive-slider', $slider->slider_id)}}">
                  <span class="fa-thumbs-styling fa fa-thumbs-up"></span></a>;
                <?php
              }else{
              ?>
                <a href="{{URL::to('/active-slider', $slider->slider_id)}}">
                  <span class="fa-thumbs-styling fa fa-thumbs-down"></span></a>;
              <?php
              }
              ?>
            </span></td>
            <td>
              </a>
              <a onclick="return (confirm('Bạn có muốn xóa danh mục này không?'))" href="{{URL::to('/delete-brand', $brand_pro->brand_id)}}" class="active styling-detele" ui-toggle-class="">
             
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          @endforeach
        </tbody>

      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection