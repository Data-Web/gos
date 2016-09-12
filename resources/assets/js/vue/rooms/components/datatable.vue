<template>
	<table class="table table-condensed table-default table-bordered table-hover" id="table-index">
        <thead>
            <tr class="active">
                <th class="text-center" width="100">Mã</th>
                <th>Tên phòng</th>
                <th>Trưởng phòng</th>
                <th>Số nhân viên</th>
                <th>Ngày thành lập</th>
                <th width="100">Thao tác</th>
            </tr>
        </thead>

        <tbody>
            <tr style="background: #e3eff1;">
                <td><input type="" name="" class="form-control input-sm" /></td>
                <td><input type="" name="" class="form-control input-sm" /></td>
                <td><input type="" name="" class="form-control input-sm" /></td>
                <td></td>
                <td class="text-right" colspan="2">
                    <button type="button" class="btn btn-info btn-filter">
                        <span class="glyphicon glyphicon-search"></span> Tìm kiếm
                    </button>

                    <button type="button" class="btn btn-danger btn-filter">
                        <span class="glyphicon glyphicon glyphicon-ban-circle"></span> Reset
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script type="text/javascript">
    export default {
        data: function () {
            var self = this;
            return {
                route: {
                    url: window.laroute.route('api.v1.rooms.data'),
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
                    {data: 'manager', name: 'manager'},
                    {data: 'member', name: 'member'},
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
                    	$('.row').eq(0).remove();
                        var actions = data.actions;
                        
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