@extends('layouts.backend')

@push('prestyles')
    {{ HTML::style('vendor/datatables-bs/css/dataTables.bootstrap.min.css') }}
@endpush

@push('prescripts')
    {{ HTML::script("vendor/datatables/js/jquery.dataTables.min.js") }}
    {{ HTML::script("vendor/datatables-bs/js/dataTables.bootstrap.min.js") }}
    {{ HTML::script("assets/vue/rooms/room.js") }}
@endpush

@section('page-content')

<div id="RoomsController">

    <modal-form :item="item" :branches="branches" :permissions="permissions" :modal-title="modalTitle" :errors="errors"></modal-form>

    <div id="content">
        <div class="container-fluid">
            <h3>Quản lý phòng ban
                <a href="#" v-on:click="create" role="button" class="btn btn-success pull-right">
                    <i class="fa fa-plus"></i> Thêm mới phòng ban
                </a>
            </h3>
            <div class="row">
                <div class="col-xs-12">
                    <div class="widget">

                        <div class="widget-heading">
                            <h1 class="title text-uppercase">Danh sách phòng ban</h1>
                            <a href="javascript:;" class="toggle-content" references="#providerList" display="1">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                        
                        <div id="providerList">
                            <data-table></data-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
