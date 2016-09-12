<template>
<div class="widget-content">
    <div class="table-responsive">
        <table class="table table-condensed table-default table-bordered table-hover" id="table-index" width="100%">
            <thead>
                <tr>
                    <th style="display:none">ID</th>
                    <th class="text-center">Mã</th>
                    <th>Họ và tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Chức vụ</th>
                    <th>Phòng ban</th>
                    <th class="text-center">Thao tác</th>
                </tr>
                <tr style="background: #e3eff1;">
                    <td style="display:none"></td>
                    <td><input v-model="code" type="text" class="form-control input-sm"></td>
                    <td><input v-model="fullname" type="text" class="form-control input-sm"> </td>
                    <td><input v-model="username" type="text" class="form-control input-sm"> </td>
                    <td><input v-model="email" type="text" class="form-control input-sm"></td>
                    <td><input v-model="phone" type="text" class="form-control input-sm"></td>
                    <td>
                        <select v-model="position_id" class="form-control input-sm">
                            <option value="">--Chọn--</option>
                            <option v-for="position in positions" :value="position.id">{{ position.name }}</option>
                        </select>
                    </td>
                    <td>
                        <select v-model="room_id" class="form-control input-sm">
                            <option value="">--Chọn--</option>
                            <option v-for="room in rooms" :value="room.id">{{ room.name }}</option>
                        </select>
                    </td>
                    <td>
                        <a v-on:click.prevent="search" class="btn btn-info input-sm"><span class="glyphicon glyphicon-search"></span> Tìm kiếm</a>
                        <a v-on:click.prevent="reset" class="btn btn-danger input-sm"><span class="glyphicon glyphicon glyphicon-ban-circle"></span> Reset</a>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>
</template>

<script>
    export default {
        props: {
            positions: [],
            rooms: [],
        },

        data: function () {
            var self = this;
            return {
                route: {
                    url: window.laroute.route('api.v1.users.data'),
                    data: function (d) {
                        d.code = self.code;
                        d.fullname = self.fullname;
                        d.username = self.username;
                        d.email = self.email;
                        d.phone = self.phone;
                        d.position_id = self.position_id;
                        d.room_id = self.room_id;
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'code', name: 'code'},
                    {data: 'fullname', name: 'fullname'},
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'position', name: 'position'},
                    {data: 'rooms', orderable: false, name: 'rooms'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false, sClass: "text-center"}
                ],
                code: '',
                fullname: '',
                username: '',
                email: '',
                phone: '',
                position_id: '',
                room_id: '',
            }
        },

        methods: {
            tableRender: function () {
                var self = this;
                this.$parent.oTable = renderTable(this.route, this.columns, {
                    createdRow: function (row, data, index) {
                        $('td', row).eq(0).css('display', 'none');
                        var actions = data.actions;

                        if (! actions || actions.length < 1) {
                            return ;
                        }

                        var actionHtml = $('td', row).eq(8);

                        actionHtml.html('');

                        if (actions.edit) { 
                            var edit = actionHtml.append('<a href="#" v-on:click="edit('+data.id+')" title="Sửa" class="btn-icon label-edit"><span class="glyphicon glyphicon-edit"></span></a>');
                            self.$compile(edit.get(0));
                        }

                        if (actions.delete) {   
                            var destroy = actionHtml.append('<a href="#" title="Xóa" class="btn-icon label-delete btn-xs" v-on:click="destroy(' + data.id + ', \'' + data.fullname + '\')" ><span class="glyphicon glyphicon-remove-circle"></span></a>');
                            self.$compile(destroy.get(0));
                        }
                    }
                });
            },
            edit: function (id) {
                this.$parent.edit(id);
            },

            destroy: function(id, name) {
                this.$parent.destroy(id, name);
            },

            search: function () {
                this.$parent.oTable.draw();
            },

            reset: function () {
                this.$set('code', '');
                this.$set('fullname', '');
                this.$set('username', '');
                this.$set('email', '');
                this.$set('phone', '');
                this.$set('position_id', '');
                this.$set('room_id', '');
                this.$parent.oTable.draw();
            },
        },

        ready: function () {
            this.tableRender();
        }
    }

</script>