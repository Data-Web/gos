import Vue from 'vue'
import VueResource from 'vue-resource'
import VueValidator from 'vue-validator'
import UserService from '../services/user'

import DataTable from './components/datatable.vue';
import ModalForm from './components/modal-form.vue';

Vue.use(VueResource)
Vue.use(VueValidator)

Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

Vue.http.options.emulateJSON = true;
new Vue({
    el: '#UsersController',

    components: { DataTable, ModalForm },

    data: function () {
        return {
            item: {
                _token: '',
                id: '',
                code: '',
                fullname: '',
                username: '',
                password: '',
                email: '',
                phone: '',
                address: '',
                birthday: null,
                image: '',
                gender: 1,
                image_thumbnail: '',
                position_id: ''
            },

            positions: [],
            rooms: [],
            permissions: [],
            roles: [],

            modalTitle: '',
            formElement: {},
            errors: {},
            oTable: {
                type: Object
            }
        }
    },

    created: function () {
        UserService.setRouter(window.laroute);
        UserService.setHttp(this.$http);
    },

    methods: {

        create: function() {
            this.item = {};
            this.errors = {},
            this.modalTitle = 'Thêm mới người dùng';
            this.formElement.modal({
                backdrop: 'static',
                show: true
            });
        },

        store: function(params) {
            var self = this;

            UserService.store(params).then((response) => {
                if (response.code === 200) {
                    toastr.success(response.message);
                    $('#newUser').modal('hide');
                    self.oTable.draw();
                } else {
                    toastr.error(response.message);
                }

            }, (response) => {
                if (response.errors) {
                    self.errors = response;
                }
            });
        },

        edit: function(id) {
            var self = this;
            this.modalTitle = 'Cập nhật người dùng';

            UserService.edit(id).then(function(response) {
                self.item = response.item;
            });
            this.errors = {},
            this.formElement.modal({
                backdrop: 'static',
                show: true
            });
        },

        update: function (params, id) {
            var self = this;
            UserService.update(params, id).then((response) => {
                if (response.code === 200) {
                    toastr.success(response.message);
                    $('#newUser').modal('hide');
                    self.oTable.draw();
                } else {
                    toastr.error(response.message);
                }

            }, (response) => {
                if (response.errors) {
                    self.errors = response;
                }
            });
        },

        destroy: function(id, name) {
            var self = this;
            swal({
                title: "Bạn có chắc chắn không ?",
                text: "Bản ghi có tên "+ name + " sẽ bị xóa",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Đồng ý!",
                cancelButtonText: 'Hủy',
                closeOnConfirm: true
            }, function(isConfirm) {
                if (isConfirm) {
                    UserService.destroy(id).then(function(response) {
                        self.oTable.draw();
                    });

                    swal("Đã xóa!", "Bản ghi có tên " + name, "success");
                }
            });
        },
    },

    ready: function () {
        var self = this;

        UserService.index().then(function(response) {
            self.positions = response.positions;
            self.rooms = response.rooms;
            self.permissions = response.permissions;
            self.roles = response.roles;
        });
    },

});
