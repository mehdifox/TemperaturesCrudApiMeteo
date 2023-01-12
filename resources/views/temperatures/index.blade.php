@extends('layouts.app')

@section('content')
<div class="">
    <div id="myPlot" class="m-auto" style="width:100%;max-width:1000px;height:700px !important"></div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Les Températures') }}</div>

                <div class="card-body">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <p><a class="btn btn-success" href='{{ route("temperatures.create") }}'><i class="fa fa-plus"></i> Nouvelle Température</a></p>

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>
                                    Temps
                                </th>
                                <th>
                                    Temperature
                                </th>
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($temperatures as $temperature)
                            <tr>
                                <td>
                                    {{ date('d/m/Y h:i', strtotime($temperature->time))  }}
                                </td>

                                <td>
                                    {{ $temperature->temperature }} °C
                                </td>

                                <td class="d-flex" style="align-items: flex-start;">
                                    <a class="btn btn-success d-block mb-2 px-3" href='{{ route("temperatures.edit", $temperature->id) }}'> Edit</a> 

                                    <form method="POST" action="{{ route('temperatures.destroy', $temperature->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <div class="form-group">
                                            <i class="fa fa-times"></i>
                                            <input type="submit" class="btn btn-danger d-block" value="Delete" onclick="return confirm('Confirmation la suppression?')">
                                        </div>
                                    </form>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" align="center">table vide</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    $(document).ready(function() {
        //CAll APi
        $.ajax({
        url: "https://api.open-meteo.com/v1/forecast?latitude=28.50&longitude=-10.00&hourly=temperature_2m",
        type: 'GET',
        data: {
            stuff: "here"
        },
        success: function (data) {
            // recover times
            var time = data.hourly.time;
            // recover temperatures
            var temperature = data.hourly.temperature_2m;
            // horizontal values variable
            var data_y = [];
            // vertical value variable
            var data_x = [];

            // retrieve only the temperature values of the current day
            time.forEach( function(value, key) {
            dateTime1 = moment(value).format("YYYY-MM-DD"); 
            dateTime2 = moment(new Date()).format("YYYY-MM-DD");
            if(dateTime1 == dateTime2){
                data_y.push(temperature[key]);
                data_x.push(value.substr(11, 2)+'H');
            }
            });

            // add value to myPlot
            var trace = {
            x: data_x,
            y : data_y,
            mode: 'lines+markers',
            connectgaps: true
            };

            var data = [trace];

            var layout = {
            title: 'Météo du jour',
            showlegend: false
            };
            //create newPlot
            Plotly.newPlot('myPlot', data, layout);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Empty most of the time...
        }
    });

    });
 
   </script>
@endsection
