@extends('adminlte::page')
@section('title', 'Elsner - Category Add')

@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{isset($category)?'Edit':'Add'}} Category</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" name="frmCat" id="frmCat" method="post" action="{{route('admin.category.store')}}" enctype="multipart/form-data">
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
                    <input type="hidden" id="cat_id" name="cat_id" value="{{ isset($category)?be64($category->id):'' }}">
                   
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name<span class="required"> * </span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ isset($category)?$category->name:old('name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="logo" class="col-sm-2 control-label">Logo</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="logo" name="logo">
                            <img id="iconImage" src="{{isset($category)?isset($category->logo)?Storage::disk('public')->url('category/'.$category->logo):asset('vendor/assets/images/default.png'):asset('vendor/assets/images/default.png')}}" style="width: 100px;height: 100px;">
                        </div>
                    </div>


                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary submit">Submit</button>
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
    $("#logo").change(function () {
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
</script>
@stop