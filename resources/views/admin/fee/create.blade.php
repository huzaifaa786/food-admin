@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Restaurant Registration Fee</h4>
                    <div class="flex-shrink-0">

                    </div>
                </div><!-- end card header -->

                <div class="card-body">

                    <div class="live-preview">
                        <form action="{{ route('fee.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!--end col-->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Fee Amount</label>
                                        <input type="number" required class="form-control" placeholder="Enter Fee Amount"
                                            name="amount" value="{{ $fee->amount ?? 0 }}" id="category" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Service charge</label>
                                        <input type="number" required class="form-control"
                                            placeholder="Enter Service Charges" name="service_charges"
                                            value="{{ $fee->service_charges ?? 0 }}" id="category" required>
                                    </div>
                                </div>
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
@endsection
