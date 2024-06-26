@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Orders</h4>
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
                                    <th>Sr#</th>
                                    <th>User</th>
                                    <th>Driver</th>
                                    <th>Total Amount</th>
                                    <th>Total Quantity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->driver_id }}</td>
                                        <td>{{ $order->total_amount }}</td>
                                        <td>{{ $order->total_quantity }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $order->status === 'REJECTED' ? 'bg-danger-subtle text-danger' : ($order->status === 'DELIVERED' ? 'bg-success' : '') }}">{{ $order->status }}</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-info items"
                                                order-id={{ $order->id }}>Items</a>
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

    <!-- User Show Modal -->
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="userShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Menu Item</th>
                                <th scope="col">Quatity</th>
                                <th scope="col">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '.items', function(e) {
                e.preventDefault();
                let id = $(this).attr('order-id');
                orderitems(id);
            });
        });

        function orderitems(orderid) {
            let data = {
                id: orderid,
                expectsJson: true,
                _token: '{{ csrf_token() }}',
            };
            $.ajax({
                url: "{{ route('order.item') }}",
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#userShowModal').modal('show');

                    $('#userShowModal tbody').empty();
                    response.forEach(function(orderitems, index) {
                        $('#userShowModal tbody').append(
                            `<tr>
                <th scope="row">${index + 1}</th>
                <td>${orderitems.menu_item.name}</td>
                <td>${orderitems.quantity}</td>
                <td>${orderitems.subtotal}</td>
            </tr>`
                        );
                    });
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
@endsection
