@extends('admin.layouts.app')
@section('content')
    <div class="content-body">

        <div class="container-fluid mt-3">
            <div class="row p-5">
                <form action="{{route('sale-graph')}}" method="POST" id="graph" style="width:100%" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="duration">Select Duration</label>
                            <select name="duration" id="duration" class="form-select form-control form-select-lg">
                                <option value="1">Weekly</option>
                                <option value="2">Monthly</option>
                                <option value="3">Yearly</option>
                            </select>
                        </div>
                        <div class="col-sm-2" id="weekly">
                            <label for="date">Select Date</label>
                            <input class="form-control" type="date" name="date" class="mydate" id="date">
                        </div>
                        <div class="col-sm-2" id="monthly">
                            <label for="date">Select Month</label>
                            <input class="form-control" type="month" name="month" class="mydate" id="month">
                        </div>
                        <div class="col-sm-2" id="yearly">
                            <label for="year">Select Year</label>
                            <select class="form-select form-control" name="year" id="year">
                                <option value="">---Select year----</option>

                            </select>
                        </div>
                        <div class="col-sm-2" style="margin-top:32px ">
                            <button type="submit" style="height:40px " id="show"
                                class="btn btn-primary form-control btn-sm">Show Sales</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row ">
                <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

                <body>

                    <div id="myPlot" style="width:100%;"></div>

                    <script>
                        const xArray = [];
                        const yArray = [];

                        const data = [{
                            x: xArray,
                            y: yArray,
                            type: "bar"
                        }];

                        const layout = {
                            title: "Sales report",
                            yaxis: {
                                title: 'Count',
                                // range: [150000, Math.max(...response.count) + 10000] // Adjust the range as needed
                            }
                        };
                        Plotly.newPlot("myPlot", data, layout);
                    </script>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="https://cdn.plot.ly/plotly-latest.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#weekly').show();
            $('#monthly').hide();
            $('#yearly').hide();


            for (let i = 1999; i <= 2550; i++) {
                $('#year').append('<option value="' + i + '">' + i + '</option>');
            }


            $('body').on('submit', '#graph', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    dataType: "JSON",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        const xArray = [];
                        const yArray = [];

                        const data = [{
                            x: response.dates,
                            y: response.count,
                            type: "bar"
                        }];

                        const layout = {
                            title: "Sales report"
                        };

                        Plotly.newPlot("myPlot", data, layout);
                    },
                    error: function(error) {
                        console.log(error);
                        var myWindow = window.open("", "MsgWindow", "width=500,height=250");
                        myWindow.document.write(error.responseText);
                    }
                });
            });

            $('body').on('change', '#duration', function(e) {
                e.preventDefault();
                var option = $(this).val();

                if (option == 1) {

                    $('#weekly').show();
                    $('#monthly').hide();
                    $('#yearly').hide();
                } else if (option == 2) {
                    $('#monthly').show();
                    $('#weekly').hide();
                    $('#yearly').hide();
                } else if (option == 3) {
                    $('#yearly').show();
                    $('#monthly').hide();
                    $('#weekly').hide();
                }
            });
        });
    </script>
@endsection

