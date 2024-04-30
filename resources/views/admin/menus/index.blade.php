@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Restaurant</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Food Admin</a></li>
                            <li class="breadcrumb-item active">Restaurant</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Restaurant</h5>
                    </div>
                    <div class="card-body">
                        <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Restaurant Name</th>
                                    <th>Menu Category</th>
                                    <th>Menu Items</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menuCategories as $menuCategory)
                                    <tr>
                                        <td>{{ $menuCategory->restraunt->name }}</td>
                                        <td>{{ $menuCategory->name }}</td>
                                        <td><a href="{{ route('menu.items', ['restaurant_id' => $menuCategory->restraunt->id, 'menu_category_id' => $menuCategory->id]) }}" class="btn btn-info delete-btn" data-id="1">Menu
                                                Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div>
@endsection
