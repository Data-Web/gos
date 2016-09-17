import Vue from 'vue'
import VueResource from 'vue-resource'
import VueValidator from 'vue-validator'
import WarehouseService from '../services/warehouse'
import DataTable from './components/datatable.vue';

Vue.use(VueResource)
Vue.use(VueValidator)

var token = $('meta[name="csrf-token"]').attr('content');

new Vue({
    el: '#WarehousesController',

    components: { DataTable },

    data: function () {
        return {
            warehouse: {
                _token: '',
                id: '',
                code: '',
                name: '',
                type: '',
                note: '',
                user_id: '',
                branch_id: ''
            },

            branches: [
                {"id": 6,"name":"dsfdsf"},
                {"id":2,"name":"Flossie Lemke"},
                {"id":5,"name":"Josiah Sporer"},
                {"id":4,"name":"Miss Bria Keeling"},
                {"id":1,"name":"Mohammed VonRueden"}
            ],

            modalTitle: 'sadsad',
            errors: {},
            formElement: {},

            oTable: {
                type: Object
            }
        }
    },

    created: function () {
        WarehouseService.setRouter(window.laroute);
        WarehouseService.setHttp(this.$http);
    },

    methods: {

        store: function(params) {
            var self = this;

            WarehouseService.store(params).then((response) => {
                if (response.code === 200) {
                    toastr.success(response.message);
                    this.formElement.modal('hide');
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
                title: "Bạn có chắc chắn không?",
                text: "Bản ghi có tên "+ name + " sẽ bị xóa",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Đồng ý!",
                cancelButtonText: 'Hủy',
                closeOnConfirm: false
            }, function(isConfirm) {
                if (isConfirm) {
                    WarehouseService.destroy(id).then(function(response) {
                        self.oTable.draw();
                    });

                    swal("Đã xóa!", "Bản ghi có tên " + name, "success");
                }
            });
        },

        validate: function () {
                this.errors = {};
                var self = this;

                this.$validate(true, function () {
                    if (self.$validation.invalid) {
                        self.isError = true;
                    } else {
                        self.isError = false;
                        self.warehouse._token = token;

                        if (self.warehouse.id) {
                            self.$parent.update(self.warehouse, self.warehouse.id);
                        } else {
                            self.store(self.warehouse);
                        }
                    }
                });
            }
    },

    ready: function () {
        var self = this;

        WarehouseService.index().then(function(response) {
            self.branches = response.branches;
        });

        $(document).on("click", ".edit-entity", function() {
            var idWarehouse = parseInt($(this).attr('id'));
        });

        $(document).on("click", ".destroy-entity", function() {
            var idWarehouse = $(this).attr('id');
            var nameWarehouse = $(this).attr('name');
            self.destroy(idWarehouse, nameWarehouse);
        });
    }
});