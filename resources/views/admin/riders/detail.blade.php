@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Drivers</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Food Admin</a></li>
                            <li class="breadcrumb-item active">Drivers</li>
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
                        <h5 class="card-title mb-0">Restaurant Drivers</h5>
                    </div>
                    <div class="card-body">
                        <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Order</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riders as $key => $rider)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $rider->name }}</td>
                                        <td>{{ $rider->email }}</td>
                                        <td>{{ $rider->phone }}</td>
                                        <td>
                                            @php
                                                $badgeClass = '';
                                                $status = $rider->active == 1 ? 'Active' : 'Non-Active';
                                                switch ($rider->active) {
                                                    case '1':
                                                        $badgeClass = 'bg-success';
                                                        break;
                                                    case '0':
                                                        $badgeClass = 'bg-info';
                                                        break;
                                                    default:
                                                        $badgeClass = 'bg-secondary';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                        </td>

                                        <td><img src="{{ asset($rider->image) }}" alt="logo_image" height="80px"
                                                width="80px"></td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-info items"
                                                rider-id={{ $rider->id }}>Orders</a>
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
                                <th>User Address</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>

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
                let id = $(this).attr('rider-id');
                orderitems(id);
            });
        });

        function orderitems(riderid) {
            let data = {
                id: riderid,
                expectsJson: true,
                _token: '{{ csrf_token() }}',
            };
            $.ajax({
                url: "{{ route('rider.order.detail') }}",
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log(response);
                    $('#userShowModal').modal('show');
                    $('#userShowModal tbody').empty();
                    response.forEach(function(order, index) {
                        const createdAt = new Date(order.created_at);
                        const formattedDate =
                            `${createdAt.getFullYear()}-${(createdAt.getMonth() + 1).toString().padStart(2, '0')}-${createdAt.getDate().toString().padStart(2, '0')} ${createdAt.getHours().toString().padStart(2, '0')}:${createdAt.getMinutes().toString().padStart(2, '0')}:${createdAt.getSeconds().toString().padStart(2, '0')}`;
                        $('#userShowModal tbody').append(
                            `<tr>
                <th scope="row">${index + 1}</th>
                <td>${order.user_address_id}</td>
                <td>${order.status}</td>
                <td>${formattedDate}</td>
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
