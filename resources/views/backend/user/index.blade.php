@extends('backend.master')

@push('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
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
    <h1>{{trans('users.index')}}</h1>
@endsection

@section('module')
    <li class="breadcrumb-item active"><p>{{trans('users.index')}}</p></li>
@endsection

@section('content')
    <div class="container-fluid">
        <div id="app">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{trans('users.list')}}</h3>
                            <div class="d-flex justify-content-end">
                                <button @click="openModal('create')"
                                        class="btn btn-primary btn-flat">{{trans('users.create')}}</button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div>
                                <table class="table  table-bordered table-striped ">
                                    <thead>
                                    <th scope="col">{{trans('action.number')}}</th>
                                    <th scope="col">{{trans('users.username')}}</th>
                                    <th scope="col">{{trans('users.email')}}
                                    <th scope="col">{{trans('users.role')}}</th>
                                    <th scope="col">{{trans('users.status')}}</th>
                                    <th scope="col">{{trans('action.name')}}</th>
                                    </thead>
                                    <tbody>
                                    <tr :key="user.id" v-for="(user,index) in lists">
                                        <td>@{{ index+1 }}</td>
                                        <td>@{{ user.name }}</td>
                                        <td>@{{ user.email }}</td>
                                        <td>
                                            <span :class="user.is_admin.class">@{{ user.is_admin.text }}</span>
                                        </td>
                                        <td>
                                            <span :class="user.is_active.class">@{{ user.is_active.text }}</span>
                                        </td>
                                        <td>
                                            <button
                                                @click="openModal('edit',user.id)"
                                                class="btn btn-primary btn-flat">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                @click="openModelDelete(user.id)"
                                                class="btn btn-danger delete-reader btn-flat">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

            </div>

            <div class="modal fade" id="modal-user">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">@{{ getType }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="username">{{trans('users.username')}}</label>
                                <input type="text" class="form-control" id="username" v-model="user.name">
                            </div>
                            <div class="form-group">
                                <label for="email">{{trans('users.email')}}</label>
                                <input :disabled="type === 'edit'" type="email" class="form-control" id="email"
                                       v-model="user.email">
                            </div>

                            <div v-if="type !=='edit'">
                                <div class="form-group">
                                    <label for="password">{{trans('users.password')}}</label>
                                    <input type="password" class="form-control" id="password" v-model="user.password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">{{trans('users.confirm_password')}}</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                           v-model="user.confirm_password">
                                </div>
                            </div>

                            <div class="d-flex">
                                <div style="margin-right: 20px" class="form-group">
                                    <div class="icheck-primary ">
                                        <input v-model="user.is_admin" value="0" name="is_admin" type="radio"
                                               id="is_not_admin">
                                        <label for="is_not_admin">
                                            {{trans('users.is_not_admin')}}
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="icheck-primary ">
                                        <input v-model="user.is_admin" value="1" name="is_admin" type="radio"
                                               id="is_admin">
                                        <label for="is_admin">
                                            {{trans('users.is_admin')}}
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="icheck-primary ">
                                        <input v-model="user.is_admin" value="2" name="is_admin" type="radio"
                                               id="is_member">
                                        <label for="is_member">
                                            {{trans('users.members')}}
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <template v-if="user.is_admin==2">
                                <div class="form-group">
                                    <label for="member">Chọn thành viên</label>
                                    <select v-model="user.reader_id" name="member" id="member">
                                        @foreach(\App\Models\Reader::all() as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </template>

                            <div class="form-group">
                                <div class="icheck-primary ">
                                    <input v-model="user.is_active" name="is_active" type="checkbox" id="is_active">
                                    <label for="is_active">
                                        {{trans('users.is_active')}}
                                    </label>
                                </div>
                            </div>


                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default btn-flat"
                                    data-dismiss="modal">{{trans('action.cancel')}}</button>
                            <button type="button"
                                    @click="confirm"
                                    class="btn btn-primary btn-flat">{{trans('action.confirm')}}</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
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
                            <button type="button" @click="deleteUser"
                                    class="btn btn-danger btn-flat confirm_delete_reader">{{trans('action.confirm')}}</button>
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
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script>
        $(document).ready(function () {
            let route;
            // $('table').dataTable({
            //     "paging": true,
            //     "lengthChange": true,
            //     "searching": true,
            //     "ordering": true,
            //     "info": true,
            //     "autoWidth": false,
            //     "responsive": true,
            //     'select': true,
            //     order: false,
            //     'language': {
            //         'sLengthMenu': 'Xem _MENU_ bản',
            //         'sSearch': 'Tìm kiếm',
            //         "info": "Hiển thị trang _PAGE_ của _PAGES_",
            //         "paginate": {
            //             "previous": 'Trang trước',
            //             'next': 'Trang sau'
            //         },
            //         'emptyTable': 'Không tìm thấy kết quả',
            //         "zeroRecords": 'Không tìm thấy kết quả'
            //
            //     }
            // });

            new Vue({
                el: '#app',
                data: {
                    user: {
                        name: null,
                        email: null,
                        password: null,
                        confirm_password: null,
                        is_admin: 0,
                        is_active: 1,
                        reader_id: null
                    },
                    listUsers: JSON.parse(`{!! $users !!}`),
                    type: null
                },
                methods: {
                    openModal(type, id = null) {
                        this.type = type;
                        if (!!id) {
                            this.user = this.listUsers.find(user => user.id === id);
                        }
                        $('#modal-user').modal('show');
                    },
                    openModelDelete(id) {
                        this.user = this.listUsers.find(item => item.id === id);
                        $('#modal-default').modal('show');
                    },
                    deleteUser() {
                        axios.delete(`/admin/users/${this.user.id}`)
                            .then(response => {
                                toastr.success('{{trans('action.delete_success')}}');
                                this.listUsers = this.listUsers.filter(item => item.id !== this.user.id);
                            })
                            .catch(err => toastr.err('{{trans('action.delete_error')}}'))
                            .finally(() => {
                                $('#modal-default').modal('hide');
                            })
                    },
                    confirm() {
                        if (this.type === 'create') {
                            const user = {...this.user};

                            if (!user.name) {
                                toastr.error('Tên không được để trống');
                                return;
                            }

                            if (!user.email) {
                                toastr.error('Email không được để trống');
                                return;
                            }
                            if (user.password.length < 6) {
                                toastr.error('Mật khẩu tối thiểu 6 ký tự');
                                return;
                            }

                            if (user.password !== user.confirm_password) {
                                toastr.error('Mật khẩu xác nhận không trùng khớp');
                                return;
                            }

                            delete user.confirm_password;

                            axios.post('{{route('users.store')}}', {
                                user
                            })
                                .then(response => {
                                    const {data, message} = response.data;
                                    toastr.success(message);
                                    this.listUsers.push(data);
                                    $('#modal-user').modal('hide');
                                })
                                .catch(err => toastr.error(err.response.data.message));
                            return;
                        }

                        const user = {...this.user};
                        delete user.confirm_password;
                        delete user.password;

                        if (!user.name) {
                            toastr.error('Tên không được để trống');
                            return;
                        }


                        axios.put(`/admin/users/${user.id}`, {user})
                            .then(response => {
                                const {data, message} = response.data;
                                toastr.success(message);

                                for (let i = 0; i < this.listUsers; ++i) {
                                    if (this.listUsers[i].id === data.id) {
                                        this.listUsers[i] = data;
                                    }
                                }

                                $('#modal-user').modal('hide');
                            })
                            .catch(err => toastr.error(err.response.data.message));

                    }
                },
                computed: {
                    getType() {
                        const type = {
                            'create': '{{trans('users.create')}}',
                            'edit': `{{trans('users.edit')}}`,
                        }
                        return type[this.type];
                    },
                    lists() {
                        return this.listUsers.map(user => {
                            return {
                                ...user,
                                is_admin: {
                                    class: parseInt(user.is_admin) === 1 ? 'badge badge-success' : 'badge badge-primary',
                                    text: parseInt(user.is_admin) === 1 ? '{{trans('users.is_admin')}}' : '{{trans('users.is_not_admin')}}'
                                },
                                is_active: {
                                    class: !!user.is_active ? 'badge badge-success' : 'badge badge-danger',
                                    text: !!user.is_active ? '{{trans('users.active')}}' : '{{trans('users.not_active')}}'
                                }
                            }
                        })
                    }
                }
            })


        })
    </script>
@endpush
