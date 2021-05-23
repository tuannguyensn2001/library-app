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
    <h1>Thống kê</h1>
@endsection

@section('module')
    <li class="breadcrumb-item active"><p>Thống kê</p></li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{trans("index.{$type}")}}</h3>
                        <div class="d-flex justify-content-end">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div>
                            @switch($type)
                                @case('order_not_done')
                                <table id="readers_table" class="table table-bordered table-head-fixed ">
                                    <thead>
                                    <tr>
                                        <th>{{trans('action.number')}}</th>
                                        <th>{{trans('books.thumbnail')}}</th>
                                        <th>{{trans('books.name')}}</th>
                                        <th>{{trans('books.author')}}</th>
                                        <th>{{trans('books.category')}}</th>
                                        <th>{{trans('order.status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($data as $key=>$book)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img class="img-thumbnail" src="{{asset($book->thumbnail)}}" width="50"
                                                     height="50" alt="">
                                            </td>
                                            <td>{{$book->name}}</td>
                                            <td>{{$book->author}}</td>
                                            <td>{{$book->category->name}}</td>
                                            <td>
                                                <span class="badge badge-danger">{{trans('order.late')}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                @break
                                @case('books')
                                <table id="readers_table" class="table table-bordered table-head-fixed ">
                                    <thead>
                                    <tr>
                                        <th>{{trans('action.number')}}</th>
                                        <th>{{trans('books.thumbnail')}}</th>
                                        <th>{{trans('books.name')}}</th>
                                        <th>{{trans('books.author')}}</th>
                                        <th>{{trans('books.category')}}</th>
                                        <th>{{trans('books.quantity')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key=>$book)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img class="img-thumbnail" src="{{asset($book->thumbnail)}}" width="50"
                                                     height="50" alt="">
                                            </td>
                                            <td>{{$book->name}}</td>
                                            <td>{{$book->author}}</td>
                                            <td>{{$book->category->name}}</td>
                                            <td>
                                                {{$book->quantity}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                @break
                                @case('reader_ordering')
                                <table id="readers_table" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{trans('action.number')}}</th>
                                        <th>{{trans('readers.name')}}</th>
                                        <th>{{trans('readers.phone')}}</th>
                                        <th>{{trans('readers.address')}}</th>
                                        <th>{{trans('order.status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key=>$reader)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$reader->name}}</td>
                                            <td>{{$reader->phone}}</td>
                                            <td>{{$reader->address}}</td>
                                            <td>
                                                <span class="badge badge-primary">{{trans('order.ordering')}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                @break
                                @case('reader_order_late')
                                <table id="readers_table" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{trans('action.number')}}</th>
                                        <th>{{trans('readers.name')}}</th>
                                        <th>{{trans('readers.phone')}}</th>
                                        <th>{{trans('readers.address')}}</th>
                                        <th>{{trans('order.status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key=>$reader)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$reader->name}}</td>
                                            <td>{{$reader->phone}}</td>
                                            <td>{{$reader->address}}</td>
                                            <td>
                                                <span class="badge badge-danger">{{trans('order.late')}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                @break
                            @endswitch
                        </div>
                    </div>

                </div>
            </div>

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


        })
    </script>
@endpush
