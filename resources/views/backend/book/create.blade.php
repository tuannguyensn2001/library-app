@extends('backend.master')

@push('css')
@endpush

@section('module_name')
    <h1>{{trans('books.create')}}</h1>
@endsection

@section('module')
    <li class="breadcrumb-item active"><a href="{{route('books.index')}}">{{trans('books.index')}}</a></li>
    <li class="breadcrumb-item active"><p>{{trans('books.create')}}</p></li>
@endsection

@section('content')
    <div class="container">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> {{trans('action.data_not_valid')}}</h5>
                @foreach($errors->all() as $error )
                    <p>{{$error}}</p>
                @endforeach
            </div>
        @endif

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{trans('books.create')}}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="form_create_book" method="post" action="{{route('books.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{trans('books.name')}}</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="author">{{trans('books.author')}}</label>
                        <input type="text" name="author" id="author" class="form-control" value="{{old('author')}}">
                    </div>
                    <div class="form-group">
                        <label for="language">{{trans('books.language')}}</label>
                        <select class="custom-select form-control" id="language" name="language"
                                value="{{old('language')}}">
                            @foreach($_LANGUAGES as $key=>$item)
                                <option value="{{$key}}">{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category_id">{{trans('books.category')}}</label>
                        <select class="custom-select form-control" id="category_id" name="category_id"
                                value="{{old('category_id')}}">
                            @foreach($categories as $key=>$item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">{{trans('books.description')}}</label>
                        <textarea id="description" name="description" class="form-control" rows="3"
                                  value="{{old('description')}}">

                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">{{trans('books.thumbnail')}}</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="thumbnail" type="file" class="custom-file-input" id="thumbnail">
                                <label class="custom-file-label" for="thumbnail">{{trans('action.choose_file')}}</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="quantity">{{trans('books.quantity')}}</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="{{old('quantity')}}">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-flat btn-primary">{{trans('action.submit_create')}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('assets/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('assets/dist/js/demo.js')}}"></script>
    <script>

        $(function () {
            bsCustomFileInput.init();
        });
        $(document).ready(function () {

            $('#form_create_book').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    address: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "{{trans('readers.name_required')}}"
                    },
                    phone: {
                        required: "{{trans('readers.phone_required')}}"
                    },
                    address: {
                        required: "{{trans('readers.address_required')}}"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        })
    </script>
@endpush
