<template>
    <div class="widget-content">
        <div class="table-responsive">
            <table class="table table-condensed table-default table-bordered table-hover" id="table-index">
                <thead>
                    <tr>
                        <th style="display:none">ID</th>
                        <th>Mã địa điểm</th>
                        <th>Tên địa điểm</th>
                        <th>Mô tả</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                    <tr style="background: #e3eff1;">
                        <td style="display:none"></td>
                        <td><input v-model="code" type="text" class="form-control input-sm" ></td>
                        <td><input v-model="name" type="text" class="form-control input-sm"> </td>
                        <td></td>
                        <td class="text-center">
                            <a v-on:click.prevent="search" class="btn btn-info input-sm">
                                <span class="glyphicon glyphicon-search"></span> Tìm kiếm
                            </a>
                            <a v-on:click.prevent="reset" class="btn btn-danger input-sm">
                                <span class="glyphicon glyphicon glyphicon-ban-circle"></span> Reset
                            </a>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        data: function () {
            var self = this;
            return {
                route: {
                    url: window.laroute.route('api.v1.locations.data'),
                    data: function (d) {
                        d.code = self.code;
                        d.name = self.name;
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'code', name: 'code'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false, sClass: "text-center"}
                ],
                code: '',
                name: '',
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

                        var actionHtml = $('td', row).eq(4);

                        actionHtml.html('');
                    }
                });
            },

            search: function () {
                this.$parent.oTable.draw();
            },

            reset: function () {
                this.$set('code', '');
                this.$set('name', '');
                this.$parent.oTable.draw();
            }
        },

        ready: function () {
            this.tableRender();
        }
    }
</script>
