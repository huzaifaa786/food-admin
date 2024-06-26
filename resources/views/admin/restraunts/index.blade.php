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
                                    <th>Sr#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Logo</th>
                                    <th>Cover</th>
                                    <th>licence</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th>Rating</th>
                                    <th>Description</th>
                                    <th>Payment ID</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                    <th>Account Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($restaurants as $key => $restaurant)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $restaurant->name }}</td>
                                        <td>{{ $restaurant->email }}</td>
                                        <td>{{ $restaurant->phone }}</td>
                                        <td><a class="image-popup" href="{{ asset($restaurant->logo) }}" title=""><img
                                                    src="{{ asset($restaurant->logo) }}" alt="logo_image" height="80px"
                                                    width="80px"></a></td>
                                        <td><a class="image-popup" href="{{ asset($restaurant->cover) }}"
                                                title=""><img src="{{ asset($restaurant->cover) }}" alt="cover_image"
                                                    height="80px" width="80px"></a></td>
                                        <td><a class="image-popup" href="{{ asset($restaurant->license) }}"
                                                title=""><img src="{{ asset($restaurant->license) }}"
                                                    alt="license_image" height="80px" width="80px"></a></td>
                                        <td>
                                            @php
                                                $badgeClass = '';
                                                switch ($restaurant->status) {
                                                    case 'OPENED':
                                                        $badgeClass = 'bg-success';
                                                        break;
                                                    case 'BUSY':
                                                        $badgeClass = 'bg-info';
                                                        break;
                                                    case 'CLOSED':
                                                        $badgeClass = 'bg-danger';
                                                        break;
                                                    default:
                                                        $badgeClass = 'bg-secondary';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $restaurant->status }}</span>
                                        </td>


                                        <td>{{ $restaurant->category->name }}</td>
                                        <td>
                                            @php
                                                $totalRating = 0;
                                                $ratingCount = $restaurant->ratings->count();
                                                if ($ratingCount > 0) {
                                                    foreach ($restaurant->ratings as $rating) {
                                                        $totalRating += $rating->rating;
                                                    }
                                                    $averageRating = $totalRating / $ratingCount;
                                                    echo round($averageRating, 1);
                                                } else {
                                                    echo 'No ratings yet';
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            {{ $restaurant->description }}
                                        </td>
                                        <td>
                                            {{ $restaurant->payment_intent }}
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = '';
                                                switch ($restaurant->payment_status) {
                                                    case 'Paid':
                                                        $badgeClass = 'bg-success';
                                                        break;
                                                    case 'Pending':
                                                        $badgeClass = 'bg-danger';
                                                        break;
                                                    default:
                                                        $badgeClass = 'bg-danger';
                                                }
                                            @endphp
                                            <span
                                                class="badge {{ $badgeClass }}">{{ $restaurant->payment_status }}</span>
                                        </td>
                                        <td><a href="{{ route('resturant.order', $restaurant->id) }}"
                                                class="btn btn-primary delete-btn" data-id="1">Orders</a></td>
                                        <td><a href="{{ route('resturant.status', $restaurant->id) }}"
                                                class="btn @if ($restaurant->is_approved) btn-danger  @else btn-success @endif  delete-btn"
                                                data-id="1">
                                                @if ($restaurant->is_approved)
                                                    Reject
                                                @else
                                                    Approve
                                                @endif
                                            </a></td>
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
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/glightbox/css/glightbox.min.css') }}">
@endsection
@section('script')
    <script src="{{ asset('assets/libs/glightbox/js/glightbox.min.js') }}"></script>

    <!-- isotope-layout -->
    <script src="{{ asset('assets/libs/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/gallery.init.js') }}"></script>
@endsection
