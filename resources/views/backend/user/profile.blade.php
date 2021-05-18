@extends('backend.master')
@push('css')
    <style>
        .avatar:hover {
            cursor: pointer;
        }
    </style>
    @endpush


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{trans('users.profile')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{trans('index.home')}}</a></li>
                        <li class="breadcrumb-item active">{{trans('users.profile')}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> {{trans('action.data_not_valid')}}</h5>
                    @foreach($errors->all() as $error )
                        <p>{{$error}}</p>
                    @endforeach
                </div>
            @endif
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div  class="avatar text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{asset(\Illuminate\Support\Facades\Auth::user()->avatar)}}"
                                     alt="User profile picture">
                                <input type="file" id="avatar" hidden>
                            </div>

                            <h3 class="profile-username text-center">{{\Illuminate\Support\Facades\Auth::user()->name}}</h3>

                            <p class="text-muted text-center">{{\Illuminate\Support\Facades\Auth::user()->is_admin == 1 ? trans('users.is_admin') : trans('users.is_not_admin')}}</p>


                        </div>
                        <!-- /.card-body -->
                    </div>


                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">

                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">{{trans('action.settings')}}</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="active tab-pane" id="settings">
                                    <form action="{{route('users.update.profile')}}" method="post" class="form-horizontal">
                                        @csrf
                                       <div class="form-group">
                                           <label for="name">{{trans('users.username')}}</label>
                                           <input class="form-control" type="text" name="name" id="name" value="{{\Illuminate\Support\Facades\Auth::user()->name}}">
                                       </div>
                                        <div class="form-group">
                                            <label for="email">{{trans('users.email')}}</label>
                                            <input disabled class="form-control" type="email" name="email" id="email" value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">{{trans('users.password')}}</label>
                                            <input  class="form-control" type="password" name="password" id="password" >
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_password">{{trans('users.confirm_password')}}</label>
                                            <input  class="form-control" type="password" name="confirm_password" id="confirm_password" >
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-primary btn-flat">{{trans('action.save')}}</button>
                                        </div>





                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('img').click(function(){
                $('#avatar').click();
            })

            $('#avatar').on('change',function(){
                const data = new FormData();
                data.append('avatar',$(this)[0].files[0]);

                axios.post('{{route('users.update.avatar')}}',data)
                .then(response => window.location.reload())
                .catch(err => toastr.error(err.response.data.message));
            })
        })
    </script>
    @endpush
