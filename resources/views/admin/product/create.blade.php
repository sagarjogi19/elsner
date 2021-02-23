@extends('adminlte::page')
@section('title', 'Elsner - Product Add')

@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{isset($product)?'Edit':'Add'}} Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" name="frmProd" id="frmProd" method="post" action="{{route('admin.products.store')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="box-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                                {{ session()->get('success') }}
                        </div>
                @endif
                @if (!empty($errors->toarray()))
                 <div class="alert alert-danger">
                        <span>{{ $errors->first() }}</span>
                </div>
                @endif
                    <input type="hidden" id="prod_id" name="prod_id" value="{{ isset($product)?be64($product->id):'' }}">
                   
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name<span class="required"> * </span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ isset($product)?$product->name:old('name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-sm-2 control-label">Category<span class="required"> * </span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="category_id[]" id="category_id" multiple>
                                <option value="">Select Category</option>
                                @foreach($category as $v)
                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="description" name="description" placeholder="Description">{{ isset($product)?$product->description:old('description') }}</textarea>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Price<span class="required"> * </span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="price" onkeypress="return isNumberKey(event)" name="price" placeholder="Price" value="{{ isset($product)?$product->price:old('price') }}">
                        </div>
                    </div>
                      <div class="form-group">
                        <label for="logo" class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="image" name="image">
                            <img id="iconImage" src="{{isset($product)?isset($product->image)?Storage::disk('public')->url('products/'.$product->image):asset('vendor/assets/images/default.png'):asset('vendor/assets/images/default.png')}}" style="width: 100px;height: 100px;">
                        </div>
                    </div>


                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary submit">Submit</button>
                    <a href="{{route('admin.products.index')}}" class="btn btn-info">Back</a>
                </div>
            </form>
        </div>

        <!-- /.box-body -->

        <!-- /.box-footer -->

    </div>
    <!-- /.box -->
    <!-- general form elements disabled -->

    <!-- /.box -->
</div>

@endsection
@section('css')

@stop
@section('js')
<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    CKEDITOR.replace('description');
    $('#category_id').select2();
      function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
       $("#image").change(function () {
        readImageData(this);//Call image read and render function
    });
    function readImageData(imgData) {
        if (imgData.files && imgData.files[0]) {
            var readerObj = new FileReader();

            readerObj.onload = function (element) {
                $('#iconImage').attr('src', element.target.result);
            }

            readerObj.readAsDataURL(imgData.files[0]);
        }
    }
@if(isset($product))
    var cat_id=[];
    @foreach($product->categories as $v)
        cat_id.push('{{$v->category_id}}');
    @endforeach
    $('#category_id').val(cat_id);
    $('#category_id').trigger('change');
@endif
</script>
@stop