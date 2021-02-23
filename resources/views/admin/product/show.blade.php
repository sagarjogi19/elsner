@extends('adminlte::page')
@section('title', 'Elsner - Product View')

@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">View Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" name="frmProd" id="frmProd">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $product->name}}" readonly>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="category_id" class="col-sm-2 control-label">Category<span class="required"> * </span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="category_id[]" id="category_id" multiple disabled>
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
                            <textarea class="form-control" id="description" name="description" placeholder="Description" disabled>{{ isset($product)?$product->description:old('description') }}</textarea>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="price" disabled onkeypress="return isNumberKey(event)" name="price" placeholder="Price" value="{{ isset($product)?$product->price:old('price') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="logo" class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-8">
                            <img id="iconImage" src="{{isset($product)?isset($product->image)?Storage::disk('public')->url('products/'.$product->image):asset('vendor/assets/images/default.png'):asset('vendor/assets/images/default.png')}}" style="width: 100px;height: 100px;">
                        </div>
                    </div>


                </div>
                <div class="box-footer">
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