@extends('adminlte::page')
@section('title', 'Elsner - Category View')

@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">View Category</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" name="frmCat" id="frmCat">
                <div class="box-body">
                   
                   
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $category->name }}" readonly="">
                        </div>
                    </div>
                      <div class="form-group">
                        <label for="logo" class="col-sm-2 control-label">Logo</label>
                        <div class="col-sm-8">
                            <img id="iconImage" src="{{isset($category)?isset($category->logo)?Storage::disk('public')->url('category/'.$category->logo):asset('vendor/assets/images/default.png'):asset('vendor/assets/images/default.png')}}" style="width: 100px;height: 100px;">
                        </div>
                    </div>


                </div>
                <div class="box-footer">
                    <a href="{{route('admin.category.index')}}" class="btn btn-info">Back</a>
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
<script>
@if(isset($category))
    var cat_id='{{$category->parent_id}}';
    $('#parent_id').val(cat_id);
@endif
</script>
@stop