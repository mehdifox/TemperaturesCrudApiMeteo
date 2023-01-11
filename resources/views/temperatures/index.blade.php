@extends('layouts.app')

@section('content')
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
