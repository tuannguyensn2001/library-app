@extends('backend.master')

@push('css')
    <style>
        table {
            text-align: center;
        }

        .delete-reader {
            color: #fff;
        }

        .book_thumbnail {
            border-radius: 50%;
        }
    </style>
@endpush

@section('module_name')
    <h1>{{trans('books.index')}}</h1>
@endsection

@section('module')
    <li class="breadcrumb-item active"><p>{{trans('books.index')}}</p></li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{trans('books.list')}}</h3>
                        <div class="d-flex justify-content-end">
                            <a href="{{route('books.create')}}"
                               class="btn btn-primary btn-flat">{{trans('books.create')}}</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div>
                            <table id="readers_table" class="table table-bordered table-head-fixed ">
                                <thead>
                                <tr>
                                    <th>{{trans('action.number')}}</th>
                                    <th>{{trans('books.thumbnail')}}</th>
                                    <th>{{trans('books.name')}}</th>
                                    <th>{{trans('books.author')}}</th>
                                    <th>{{trans('books.category')}}</th>
                                    <th>{{trans('books.quantity')}}</th>
                                    <th>{{trans('action.name')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($books as $key=>$book)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <img class="img-thumbnail" src="{{asset($book->thumbnail)}}" width="50"
                                                 height="50" alt="">
                                        </td>
                                        <td>{{$book->name}}</td>
                                        <td>{{$book->author}}</td>
                                        <td>{{$book->category->name}}</td>
                                        <td>{{$book->quantity}}</td>
                                        <td>
                                            <form method="post" action="{{route('books.order',['book' => $book->id])}}">
                                                @csrf
                                                @if(auth()->user()->is_admin === 2)
                                                    <button type="submit"
                                                            class="btn btn-success btn-flat">
                                                        <i class="fab fa-first-order"></i>
                                                    </button>
                                                @endif
                                                <a href="{{route('books.edit',['book' => $book->id])}}"
                                                   class="btn btn-primary btn-flat">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{route('books.destroy',['book' => $book->id])}}"
                                                   class="btn btn-danger delete-reader btn-flat">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </form>


                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
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
                        <button type="button" class="btn btn-default btn-flat"
                                data-dismiss="modal">{{trans('action.cancel')}}</button>
                        <button type="button"
                                class="btn btn-danger btn-flat confirm_delete_reader">{{trans('action.confirm')}}</button>
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
                order: false,
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

            $('.delete-reader').click(function (event) {
                event.preventDefault();
                $('#modal-default').modal('show');
                route = $(this).attr('href');
            })

            $('#modal-default').find('.confirm_delete_reader').click(function () {
                axios.delete(route)
                    .then(() => {
                        window.location.reload();
                    })
                    .catch(err => toastr.error(err.response.data.message));
            })

        })
    </script>
@endpush
