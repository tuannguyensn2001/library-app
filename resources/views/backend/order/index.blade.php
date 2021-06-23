@extends('backend.master')

@push('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <style>
        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            white-space: nowrap;
            text-align: center;
        }

        .table-wrapper {
            display: none;
            animation-name: move;
            animation-duration: 0.2s;
        }

        .loading {
            display: none;
            position: relative;
        }

        @keyframes move {
            from {
                top: 400px;
            }
            to {
                top: 0;
            }
        }


        /*body {*/
        /*    background-color: black;*/
        /*    width: 100vw;*/
        /*    height: 100vh;*/
        /*    margin: 0;*/
        /*}*/

        @keyframes anim-loading-pill {
            to {
                transform: scale(0.5);
                opacity: 0.9;
            }
        }

        .loading {
            margin-top: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .loading .loading__pill {
            width: 20px;
            height: 20px;
            background-color: #0c0c0c;
            border-radius: 50%;
            animation: anim-loading-pill 1s ease-in infinite alternate;
        }

        .loading .loading__pill:nth-last-child(1) {
            animation-delay: -0.3333333333s;
        }

        .loading .loading__pill:nth-last-child(2) {
            animation-delay: -0.6666666667s;
        }

        .loading .loading__pill:nth-last-child(3) {
            animation-delay: -1s;
        }

        .loading .loading__pill:not(:last-child) {
            margin-right: 15px;
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
        <h2 class="text-center display-4">{{trans('action.search',['name' => trans('order.index_name')])}}</h2>
        <form id="form_search" action="{{route('orders.search')}}" method="get">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="reader_name">{{trans('order.search_by')['reader_name']}}</label>
                            <input type="text" class="form-control" name="reader_name" id="reader_name">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="book_name">{{trans('order.search_by')['book_name']}}</label>
                            <input type="text" class="form-control" name="book_name" id="book_name">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="reader_id">{{trans('order.search_by')['reader_id']}}</label>
                            <input type="text" class="form-control" name="reader_id" id="reader_id">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="book_id">{{trans('order.search_by')['book_id']}}</label>
                            <input type="text" class="form-control" name="book_id" id="book_id">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="from">{{trans('order.search_by')['from']}}</label>
                            <div class="input-group date" id="from" data-target-input="nearest">
                                <input name="from" type="text" class="form-control datetimepicker-input"
                                       data-target="#from"/>
                                <div class="input-group-append" data-target="#from" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="from">{{trans('order.search_by')['to']}}</label>
                            <div class="input-group date" id="to" data-target-input="nearest">
                                <input name="to" type="text" class="form-control datetimepicker-input"
                                       data-target="#to"/>
                                <div class="input-group-append" data-target="#to" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <div class="form-group">
                                    <label for="is_done">{{trans('order.search_by')['is_done']}}</label>
                                    <select class="form-control" name="is_done" id="is_done">
                                        <option value="">Tùy chọn</option>
                                        <option value="0">Chưa trả</option>
                                        <option value="1">Đã trả</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="icheck-primary ">
                                    <input name="created_by" type="checkbox" id="created_by">
                                    <label for="created_by">
                                        {{trans('order.search_by')['created_by']}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="icheck-primary ">
                                    <input name="updated_by" type="checkbox" id="updated_by">
                                    <label for="updated_by">
                                        {{trans('order.search_by')['updated_by']}}
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit"
                                class="btn btn-primary btn-flat">{{trans('action.search',['name' => ''])}}</button>
                    </div>

                </div>
            </div>
        </form>

        <div class="contents">
            <div class="table-wrapper col-md-10 offset-1">
                <table class="table table-bordered">
                    <thead>
                    <th scope="col">{{trans('action.number')}}</th>
                    <th scope="col">{{trans('order.search_by')['reader_name']}}</th>
                    <th scope="col">{{trans('order.search_by')['book_name']}}</th>
                    <th scope="col">{{trans('order.search_by')['from']}}</th>
                    <th scope="col">{{trans('order.search_by')['to']}}</th>
                    <th scope="col">{{trans('order.status')}}</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="loading"><span class="loading__pill"></span><span class="loading__pill"></span><span
                class="loading__pill"></span></div>
    </div>
@endsection


@push('scripts')

    <script>
        $(document).ready(function () {
            $('.date').datetimepicker({
                format: 'DD/MM/YYYY',
                setDateTime: new Date(),
            });


            function render(element) {
                const query = [];
                element.find('input').each(function () {
                    if ($(this).attr('type') === 'checkbox') {
                        if ($(this).is(':checked')) {
                            query.push(`${$(this).attr('name')}=1`);
                        }
                        return;
                    }
                    if ($(this).val() !== '') query.push(`${$(this).attr('name')}=${$(this).val()}`);
                })

                element.find('select').each(function () {
                    if ($(this).val() !== '') query.push(`${$(this).attr('name')}=${$(this).val()}`);
                })

                const stringQuery = query.length !== 0 ? '?' + query.join('&') : '';

                const href = element.attr('action');

                $('.contents').empty();

                $('.loading').show();

                $('.contents').append(`
                     <div class="table-wrapper col-md-10 offset-1">
                <table class="table table-bordered">
                    <thead>
                    <th scope="col">{{trans('action.number')}}</th>
                    <th scope="col">{{trans('order.search_by')['reader_name']}}</th>
                    <th scope="col">{{trans('order.search_by')['book_name']}}</th>
                    <th scope="col">{{trans('order.search_by')['from']}}</th>
                    <th scope="col">{{trans('order.search_by')['to']}}</th>
                    <th scope="col">{{trans('order.status')}}</th>
                    <th scope="col">{{trans('action.name')}}</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
                `)

                axios.get(`${href}${stringQuery}`)
                    .then(response => {
                        const {data} = response.data;

                        data.forEach((item, index) => {

                            const {status} = item;

                            const label = {
                                'DONE': '<span class="badge badge-success">Đã trả</span>',
                                'NOT_DONE': `<span class="badge badge-warning">Chưa trả</span>`,
                                'LATE': `<span class="badge badge-danger">Qúa hạn</span>`
                            };

                            const html = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.reader.name}</td>
                                    <td>${item.book.name}</td>
                                    <td>${item.from}</td>
                                    <td>${item.to}</td>
                                    <td>${label[status]}</td>
                                     <td style="display: flex">
                                                  <a style='display: ${item.is_check === 0 ? 'block' : 'none'}' href="/admin/orders/${item.id}/check"  class="btn btn-warning btn-flat">
                                               <i class="fas fa-check"></i>
                                            </a>
                                                <a style='display: ${item.is_check !== 0 ? 'block' : 'none'}' href="/admin/orders/${item.id}/edit"  class="btn btn-primary btn-flat">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            </td>
                                </tr>
                            `

                            $('tbody').append(html);


                        })

                        setTimeout(() => {
                            $('.table-wrapper').css('display', 'block');
                            $('.loading').hide();

                        }, 1000);

                        $('table').dataTable({
                            searching: false,
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
                    .catch(err => console.log(err));
            }

            render($('#form_search'));


            $('#form_search').on('submit', function (event) {
                event.preventDefault();

                render($(this));


            })
        })
    </script>


@endpush
