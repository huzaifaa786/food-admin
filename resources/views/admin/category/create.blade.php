@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-xxl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Category</h4>
                <div class="flex-shrink-0">
                    
                </div>
            </div><!-- end card header -->

            <div class="card-body">
             
                <div class="live-preview">
                    <form action="{{route('category.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!--end col-->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Name</label>
                                    <input type="text" required class="form-control" placeholder="Enter Category Name" name="name" id="category">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ar_name" class="form-label">Ar_Name</label>
                                    <input type="text" required class="form-control" name="ar_name" placeholder="Enter Ar_Name"  id="ar_name">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Category Image</label>
                                    <input type="file" required class="form-control" id="image" name="image">
                                </div>
                            </div>
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