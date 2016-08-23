@extends('layouts.backend')

@push('prestyles')
    {{ HTML::style('/assets/css/backend/products/product.css') }}
@endpush

@section('page-content')
    @include('backend.product._form')
    <div id="content">
        <div class="container-fluid">
            <h3>Quản hàng hóa vật tư</h3>
            <div class="row">
                <div class="col-md-3">
                    <div id="sidebar">
                        <div class="sb-heading">
                            <h3 class="title text-uppercase">Tìm kiếm hàng hóa</h3>
                            <a href="javascript:;" class="toggle-content" references="#sidebar .sb-content" display="1">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>

                        <div class="sb-content">
                            <div class="form-group">
                                <label for="" class="lineside">
                                    <span class="text">Nhập từ khóa</span>
                                </label>
                                <input type="text" class="form-control input-sm" placeholder="Tên hoặc mã khách hàng" />
                            </div>
                            <div class="form-group">
                                <label for="" class="lineside">
                                    <span class="text">Theo chi nhánh</span>
                                </label>
                                <select name="" id="" class="form-control input-sm">
                                    <option value="">Chọn chi nhánh</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="lineside">
                                    <span class="text">Theo Gara</span>
                                </label>
                                <select name="" id="" class="form-control input-sm">
                                    <option value="">Chọn Gara</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="lineside">
                                    <span class="text">Theo kho hàng</span>
                                </label>
                                <select name="" id="" class="form-control input-sm">
                                    <option value="">Chọn kho hàng</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="" class="lineside">
                                    <span class="text">Theo nhóm hàng</span>
                                </label>
                                <select name="" id="" class="form-control input-sm">
                                    <option value="">Chọn nhóm hàng</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="" class="lineside">
                                    <span class="text">Theo hàng hóa</span>
                                </label>
                                <div class="radio">
                                    <label for="test1">
                                        <input type="radio" id="test1" name="test"> Đang hết hàng
                                    </label>
                                </div>
                                <div class="radio">
                                    <label for="">
                                        <input type="radio" name="test"> Đang còn hàng trong kho
                                    </label>
                                </div>
                                <div class="radio">
                                    <label for="">
                                        <input type="radio" name="test"> Đang hết khuyến mãi
                                    </label>
                                </div>
                                <div class="radio">
                                    <label for="">
                                        <input type="radio" name="test"> Đang hết hạn sử dụng
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group text-center">
                                <button class="btn btn-info" type="button">
                                    <span class="glyphicon glyphicon-road"></span> Tìm kiếm
                                </button>

                                <button class="btn btn-warning" type="reset"><i class="glyphicon glyphicon-ban-circle"></i> Clear</button>
                            </div>
                        </div>
                        <div class="sb-footer"></div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="widget">
                        <!-- widget-heading -->
                        <div class="widget-heading">
                            <h1 class="title text-uppercase">Danh sách hàng hóa</h1>
                            <a href="javascript:;" class="toggle-content" references="#productList" display="1">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>

                        <div id="productList">
                            <!-- widget-tools -->
                            <div class="widget-tools">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <form action="" class="form-inline">
                                            <div class="form-group">
                                                <select name="rows" table-name="test" class="form-control input-sm">
                                                    <option value="---">Xem</option>
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="15">15</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <div class="tool">
                                            <a href="#newProduct" role="button" class="btn btn-sm" data-toggle="modal">
                                                <i class="fa fa-plus"></i> Thêm mới
                                            </a>
                                        </div>
                                        <div class="tool">
                                            <a href="javascript:;" class="btn btn-sm">
                                                <i class="fa fa-sign-out"></i> Import
                                            </a>
                                        </div>
                                        <div class="tool">
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle">
                                                    <span class="fa fa-sign-out"></span>
                                                    Export
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#">Excel</a></li>
                                                    <li><a href="#">PDF</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- widget-content -->
                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-default table-bordered table-hover" name="test">
                                        <thead>
                                            <tr class="active">
                                                <th class="text-center">STT</th>
                                                <th class="text-center">Mã</th>
                                                <th>Tên sản phẩm</th>
                                                <th class="text-center">ĐVT</th>
                                                <th>Đơn giá</th>
                                                <th>Số lượng</th>
                                                <th>Khuyễn mãi</th>
                                                <th>Thành tiền</th>
                                                <th class="text-center">HSD</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @for ($i = 1; $i <= 15; $i++)
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center">SP0123</td>
                                                    <td>Samsung Galaxy S3</td>
                                                    <td class="text-center">Cái</td>
                                                    <td>2,000,000</td>
                                                    <td>100</td>
                                                    <td>5%</td>
                                                    <td>190,000,000</td>
                                                    <td class="text-center">01/12/2019</td>
                                                    <td class="text-center"> ... </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- widget-footer -->
                            <div class="widget-footer">
                                <div class="text-right">
                                    <ul class="pagination">
                                        <li class="active"><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">5</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection