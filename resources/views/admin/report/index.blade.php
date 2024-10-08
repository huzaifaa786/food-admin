@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Reports</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Food Admin</a></li>
                            <li class="breadcrumb-item active">Reports</li>
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
                        <h5 class="card-title mb-0">Reports</h5>
                    </div>
                    <div class="card-body">
                        <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No#</th>
                                    <th>User name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Solved</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (App\Models\Report::all() as $key => $report)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $report->user->name }}</td>
                                        <td>{{ $report->des }}</td>
                                        <td>
                                            <a class="image-popup" href="{{ $report->image }}" title="">
                                                <img src="{{ $report->image }}" alt="cover_image" height="80px"
                                                    width="80px">
                                            </a>
                                        </td>
                                        <td>
                                            @if ($report->solved)
                                                <span class="badge bg-success">Solved</span>
                                            @else
                                                <span class="badge bg-danger">Unsolved</span>
                                            @endif
                                        </td>
                                        <td><a href="{{ route('report.solve', $report->id) }}"
                                            class="btn btn-primary " data-id="1">Mark As Done</a></td>
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
    {{-- <div class="modal fade" id="userShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </div> --}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/glightbox/css/glightbox.min.css') }}">
@endsection
@section('script')
    <script src="{{ asset('assets/libs/glightbox/js/glightbox.min.js') }}"></script>

    <!-- isotope-layout -->
    <script src="{{ asset('assets/libs/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/gallery.init.js') }}"></script>
@endsection


{{-- @section('script')
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
@endsection --}}
