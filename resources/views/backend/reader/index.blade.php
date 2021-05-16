@extends('backend.master')

@push('css')
    <style>
        table {
            text-align: center;
        }

        .delete-reader{
            color: #fff;
        }
    </style>
@endpush

@section('module_name')
    <h1>{{trans('readers.index')}}</h1>
@endsection

@section('module')
    <li class="breadcrumb-item active"><p>{{trans('readers.index')}}</p></li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{trans('readers.list')}}</h3>
                        <div class="d-flex justify-content-end">
                            <a href="{{route('readers.create')}}" class="btn btn-primary btn-flat">{{trans('readers.create')}}</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="readers_table" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{trans('action.number')}}</th>
                                <th>{{trans('readers.name')}}</th>
                                <th>{{trans('readers.phone')}}</th>
                                <th>{{trans('readers.address')}}</th>
                                <th>{{trans('action.name')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($readers as $key=>$reader)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$reader->name}}</td>
                                    <td>{{$reader->phone}}</td>
                                    <td>{{$reader->address}}</td>
                                    <td>
                                        <a href="{{route('readers.edit',['reader' => $reader->id])}}"
                                           class="btn btn-primary btn-flat">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a  href="{{route('readers.destroy',['reader' => $reader->id])}}"
                                           class="btn btn-danger delete-reader btn-flat">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

        </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{trans('action.confirm_delete')}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">{{trans('action.cancel')}}</button>
                        <button type="button" class="btn btn-danger btn-flat confirm_delete_reader">{{trans('action.confirm')}}</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function () {
            let route;
            $('#readers_table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                'select': true,
                'language': {
                    'sLengthMenu': 'Xem _MENU_ bản',
                    'sSearch': 'Tìm kiếm',
                    "info": "Hiển thị trang _PAGE_ của _PAGES_",
                    "paginate": {
                        "previous": 'Trang trước',
                        'next': 'Trang sau'
                    },
                    'emptyTable': 'Không tìm thấy kết quả',
                    "zeroRecords": 'Không tìm thấy kết quả'
                }
            });

            $('.delete-reader').click(function(event){
                event.preventDefault();
                $('#modal-default').modal('show');
                route = $(this).attr('href');
            })

            $('#modal-default').find('.confirm_delete_reader').click(function(){
                axios.delete(route)
                .then(() => {
                    window.location.reload();
                })
                .catch(err => toastr.error(err.response.data.message));
            })

        })
    </script>
@endpush
