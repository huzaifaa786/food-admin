@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Sale Detail</h4>

                </div><!-- end card header -->

                <div class="card-body">

                    <div class="live-preview">
                        <form action="{{ route('sales.table') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="startdate" class="form-label">Start Date</label>
                                        <input type="date"
                                            value="{{ $startDate ?? Carbon\Carbon::now()->toDateString() }}"
                                            name="start_date" class="form-control" placeholder="Enter Start date"
                                            id="startdate">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="enddate" class="form-label">End Date</label>
                                        <input type="date" value="{{ $endDate ?? Carbon\Carbon::now()->toDateString() }}"
                                            name="end_date" class="form-control" placeholder="Enter End date"
                                            id="enddate">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="enddate" class="form-label">Restaurant</label>
                                        <select name="restaurant_id" id="" class="form-control">
                                            <option value="" @if (!isset($restraunt_id) && $restraunt_id == null) selected @endif
                                                >All Restaurant</option>
                                            @foreach (App\Models\Restraunt::all() as $restaurant)
                                                <option value="{{ $restaurant->id }}"
                                                    @if (isset($restraunt_id) && $restaurant->id == $restraunt_id) selected @endif>
                                                    {{ $restaurant->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->


                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->

    </div>

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
                                <th>Restaurants Name</th>
                                <th>Total Amount</th>
                                <th>Total Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($saledata as $key => $salesdata)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $salesdata->restraunt->name }}</td>
                                    <td>{{ $salesdata->total_amount }}</td>
                                    <td>{{ $salesdata->total_quantity }}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-info items"
                                            order-id={{ $salesdata->id }}>Items</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td> <b>Total: {{$saledata != [] ? $saledata->sum('total_amount') : 0}}</b></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
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
