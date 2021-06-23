@extends('backend.master')

@push('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}}">
    <style>
        img {
            border-radius: 50%;
        }

        .reader-card {
            margin-top: 10px;
            display: flex;
            background: #fff;
            border-radius: 2px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        }

        .reader-card > div {
            font-weight: lighter;
            text-align: center;

        }

        .reader-card:hover {
            cursor: pointer;
        }
    </style>
@endpush

@section('module_name')
    <h1>{{trans('order.create')}}</h1>
@endsection

@section('module')
    <li class="breadcrumb-item active"><a href="{{route('orders.index')}}">{{trans('order.index')}}</a></li>
    <li class="breadcrumb-item active"><p>{{trans('order.create')}}</p></li>
@endsection

@section('content')
    <div id="app">
        <div class="container">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{trans('order.create')}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">
                    <form action="{{route('orders.store')}}" method="post" @submit="submitForm">
                        <div class="form-group">
                            <label for="reader">{{trans('order.reader')}}</label>
                            <label>
                                <input v-model="order.reader_id" type="text" hidden name="reader_id">
                            </label>
                            <input v-model="order.reader_name" @focus="openModal('reader')" type="text"
                                   class="form-control" id="reader">
                        </div>
                        <div class="form-group">
                            <label for="book">{{trans('order.book')}}</label>
                            <label>
                                <input v-model="order.book_id" type="text" hidden name="book_id">
                            </label>
                            <input v-model="order.book_name" @focus="openModal('book')" type="text" class="form-control"
                                   id="book">
                        </div>
                        <div class="form-group">
                            <label>{{trans('order.from')}}</label>
                            <div class="input-group date" id="from" data-target-input="nearest">
                                <input v-model="order.from" type="text" class="form-control datetimepicker-input"
                                       data-target="#from"/>
                                <div class="input-group-append" data-target="#from" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{trans('order.to')}}</label>
                            <div class="input-group date" id="to" data-target-input="nearest">
                                <input v-model="order.to" type="text" class="form-control datetimepicker-input"
                                       data-target="#to"/>
                                <div class="input-group-append" data-target="#to" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quantity">{{trans('order.quantity')}}</label>
                            <input type="number" class="form-control" id="quantity" v-model="order.quantity">
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-flat">{{trans('action.save')}}</button>
                        </div>
                    </form>
                </div>
            </div>


            <div class="modal fade" id="modal-xl">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">@{{getType}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <template v-if="type ==='reader'">
                                <div class="form-group d-flex justify-content-around">
                                    <div class="form-check">
                                        <input class="form-check-input" name="reader_type" type="radio" value="id"
                                               v-model="readerType" checked>
                                        <label class="form-check-label">{{trans('readers.id')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="reader_type" type="radio"
                                               v-model="readerType" value="name">
                                        <label class="form-check-label">{{trans('readers.name')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="reader_type" type="radio"
                                               v-model="readerType" value="phone">
                                        <label class="form-check-label">{{trans('readers.phone')}}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="search">{{trans('action.search',['name' => 'độc giả'])}}</label>
                                    <input class="form-control" type="text" id="search" placeholder="Tìm kiếm độc giả"
                                           v-model="readerSearch">
                                </div>

                                <div class="row" v-if="true">
                                    <div class="col-md-4" v-for="reader in readers" :key="reader.id">
                                        <div @click="pickReader(reader.id)"
                                             class="reader-card d-flex justify-content-center">
                                            {{--                                            <img width="50" height="50" :src="reader.avatar" alt="">--}}
                                            <div>
                                                <p>@{{ reader.name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-else>
                                    <div class="alert alert-danger" style="width:100%; text-align: center" role="alert">
                                        {{trans('action.not_found',['name' => 'độc giả'])}}
                                    </div>
                                </div>

                            </template>
                            <template v-else>
                                <div class="form-group d-flex justify-content-around">
                                    <div class="form-check">
                                        <input class="form-check-input" name="book_type" type="radio" value="id"
                                               v-model="bookType" checked>
                                        <label class="form-check-label">{{trans('books.id')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="book_type" type="radio" v-model="bookType"
                                               value="name">
                                        <label class="form-check-label">{{trans('books.name')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="book_type" type="radio" v-model="bookType"
                                               value="author">
                                        <label class="form-check-label">{{trans('books.author')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="book_type" type="radio" v-model="bookType"
                                               value="language">
                                        <label class="form-check-label">{{trans('books.language')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="book_type" type="radio" v-model="bookType"
                                               value="category">
                                        <label class="form-check-label">{{trans('books.category')}}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="search">{{trans('action.search',['name' => 'sách'])}}</label>
                                    <select class="form-control" v-if="bookType=='category'" v-model="bookSearch"
                                            id="search">
                                        <option value="-1">Chọn thể loại</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            @{{ category.name }}
                                        </option>
                                    </select>
                                    <select class="form-control" v-else-if="bookType=='language'" v-model="bookSearch"
                                            id="search">
                                        <option value="-1">Chọn ngôn ngữ</option>
                                        <option v-for="(language,key) in languages" :key="key" :value="key">@{{ language
                                            }}
                                        </option>
                                    </select>

                                    <input v-else class="form-control" type="text" id="search"
                                           placeholder="Tìm kiếm sách"
                                           v-model="bookSearch">
                                </div>

                                <div class="row" v-if="true">
                                    <div class="col-md-4" v-for="book in books" :key="book.id">
                                        <div @click="pickBook(book.id)" class="reader-card">
                                            <div>
                                                <p>@{{ book.name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-else>
                                    <div class="alert alert-danger" style="width:100%; text-align: center" role="alert">
                                        {{trans('action.not_found',['name' => 'sách'])}}
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{trans('action.cancel')}}</button>
                            <button type="button" class="btn btn-primary">{{trans('action.save')}}</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('assets/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
    <!-- date-range-picker -->
    <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('assets/dist/js/demo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    {{--    <script src="https://unpkg.com/vue/dist/vue.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>

        $(function () {
            bsCustomFileInput.init();
        });

        // setTimeout(() => {
        //     $('#app').show()
        // },1000);

        let reader_id = null;
        let book_id = null;

        @if(session('reader_id'))
            reader_id = '{{session('reader_id')}}'
        @endif

            @if(session('book_id'))
            book_id = '{{session('book_id')}}'
        @endif

        console.log(book_id, reader_id);

        new Vue({
            el: '#app',
            data: {
                type: null,
                readerType: 'name',
                categories: JSON.parse('{!! $categories !!}'),
                languages: JSON.parse('{!! $languages !!}'),
                bookType: 'name',
                readerSearch: null,
                bookSearch: null,
                {{--readers: JSON.parse('{!! json_encode(\App\Models\Reader::all()) !!}'),--}}
                    {{--books: JSON.parse('{!! json_encode(\App\Models\Book::all()) !!}'),--}}
                readers: [],
                books: [],
                timeOut: null,
                searchIsEmpty: false,
                order: {
                    reader_id: null,
                    reader_name: null,
                    book_id: null,
                    book_name: null,
                    from: moment().format('DD/MM/YYYY'),
                    to: null,
                    quantity: 1,
                }
            },
            methods: {
                openModal(type) {
                    this.type = type;
                    $('#modal-xl').modal('show');
                },
                pickReader(id) {
                    this.order.reader_id = id;
                    this.order.reader_name = this.readers.find(reader => reader.id === id).name;
                    $('#modal-xl').modal('hide');
                },
                pickBook(id) {
                    this.order.book_id = id;
                    this.order.book_name = this.books.find(book => book.id === id).name;
                    $('#modal-xl').modal('hide');
                },
                submitForm(event) {
                    event.preventDefault();
                    const action = event.target.getAttribute('action');

                    console.log(action);


                    axios.post(action, {
                        order: this.order
                    })
                        .then(response => {
                            const {redirect} = response.data;
                            window.location.href = redirect;
                        })
                        .catch(err => {
                            if (err.response.data.errors) {
                                toastr.error(err.response.data.errors[0])
                            } else {
                                toastr.error(err.response.data.message);
                            }
                        });

                }
            },
            computed: {
                getType() {
                    return this.type === 'reader' ? 'Chọn độc giả' : 'Chọn sách'
                },
                quantity() {
                    return this.order.quantity;
                }
            },
            mounted() {
                this.books = JSON.parse(`{!! \App\Models\Book::all() !!}`);
                this.order.book_id = book_id;
                this.order.book_name = this.books.find(book => book.id === Number(book_id)).name;

                axios.get('{{route('readers.index',['type' => 'api'])}}')
                    .then(response => {
                        this.readers = response.data.data;
                        this.order.reader_id = reader_id;
                        this.order.reader_name = this.readers.find(reader => reader.id === Number(reader_id)).name;
                    })
                    .catch(err => console.log(err));


                // this.reader_id = reader_id;
                // this.book_id = book_id;
                $('.date').datetimepicker({
                    format: 'DD/MM/YYYY',
                    setDateTime: new Date(),
                });


                $('#from').find('input').on('input', event => {
                    this.order.from = event.target.value;
                })
                $('#to').find('input').on('input', event => {
                    this.order.to = event.target.value;
                })

            },
            watch: {
                // 'order.reader_id'(value) {
                //     console.log(value);
                //     this.order.reader_name = this.readers.find(reader => reader.id === value).name;
                // },
                // 'order.book_id'(value) {
                //     console.log(value);
                //     this.order.book_name = this.books.find(book => book.id === value).name;
                // },
                readerType(value) {
                    this.readerSearch = null;
                    this.readers = [];
                },
                bookType(value) {
                    if (value === 'category' || value === 'language') this.bookSearch = -1;
                    else this.bookSearch = null;
                },
                bookSearch(value) {
                    clearTimeout(this.timeOut)
                    this.timeOut = setTimeout(() => {
                        axios.get(`/admin/books?type=api&search=${this.bookType}&value=${value}`)
                            .then(response => {
                                this.books = response.data.data;
                                this.searchIsEmpty = this.books.length === 0;
                            })
                            .catch(err => console.log(err));
                    }, 500);
                },
                readerSearch(value) {
                    clearTimeout(this.timeOut)
                    this.timeOut = setTimeout(() => {
                        axios.get(`/admin/readers?type=api&search=${this.readerType}&value=${value}`)
                            .then(response => {
                                this.readers = response.data.data
                                this.searchIsEmpty = this.books.length === 0;
                            })
                            .catch(err => console.log(err));
                    }, 500);
                },
                quantity(value) {
                    if (value < 0) this.order.quantity = 0;
                }

            }
        })

    </script>
@endpush
