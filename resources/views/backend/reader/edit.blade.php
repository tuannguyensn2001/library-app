@extends('backend.master')

@push('css')
@endpush

@section('module_name')
    <h1>{{trans('readers.edit')}}</h1>
@endsection

@section('module')
    <li class="breadcrumb-item active"><a href="{{route('readers.index')}}">{{trans('readers.index')}}</a></li>
    <li class="breadcrumb-item active"><p>{{trans('readers.edit')}}</p></li>
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

        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">{{trans('readers.edit')}}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="form_create_reader" method="post" action="{{route('readers.update',['reader' => $reader->id])}}">
                {{ method_field('PUT') }}
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{trans('readers.name')}}</label>
                        <input type="text" name="name" id="name" class="form-control"
                               value="{{old('name',$reader->name)}}">
                    </div>
                    <div class="form-group">
                        <label for="phone">{{trans('readers.phone')}}</label>
                        <input type="text" name="phone" id="phone" class="form-control"
                               value="{{old('phone',$reader->phone)}}">
                    </div>
                    <div class="form-group">
                        <label for="address">{{trans('readers.address')}}</label>
                        <input type="text" name="address" id="address" class="form-control"
                               value="{{old('address',$reader->address)}}">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-flat btn-success">{{trans('action.submit_edit')}}</button>
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
        $(document).ready(function () {
            $('#form_create_reader').validate({
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
