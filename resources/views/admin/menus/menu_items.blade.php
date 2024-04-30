@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Menu Items</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Food Admin</a></li>
                            <li class="breadcrumb-item active">MenuItems</li>
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
                        <h5 class="card-title mb-0">Menu Items</h5>
                    </div>
                    <div class="card-body">
                        <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Menu Category</th>
                                    <th>Restraunt</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Discount Days</th>
                                    <th>Discount Till Date</th>
                                    <th>Available</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menuItems as $menuItem)
                                    <tr>
                                        <td>{{ $menuItem->name }}</td>
                                        <td>{{ $menuItem->menu_category->name }}</td>
                                        <td>{{ $menuItem->restraunt->name }}</td>
                                        <td><img src="{{ asset($menuItem->image) }}" alt="Menu Image"
                                                style="max-width: 100px;"></td>
                                        <td>{{ $menuItem->description }}</td>
                                        <td>{{ $menuItem->price }}</td>
                                        <td>{{ $menuItem->discount }}</td>
                                        <td>{{ $menuItem->discount_days }}</td>
                                        <td>{{ $menuItem->discount_till_date }}</td>
                                        <<td>
                                            @php
                                                $badgeClass = '';
                                                $available = $menuItem->available == 1 ? 'available' : 'Not-available';
                                                switch ($menuItem->available) {
                                                    case '1':
                                                        $badgeClass = 'bg-success';
                                                        break;
                                                    case '0':
                                                        $badgeClass = 'bg-primary';
                                                        break;
                                                    default:
                                                        $badgeClass = 'bg-secondary';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $available }}</span>
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
