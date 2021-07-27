<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hello, Bootstrap Table!</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

</head>
<body>
<div class="limiter">
    <div class="container-table100">
        <header class="text-center">
            <h1 class="display-4">Covid-19 latest statistics</h1>
            <h2 class="display-6 text-primary">Data last updated:
                @isset($last_updated_at)
                    {{$last_updated_at}}
                @else
                  never
                @endisset
            </h2>
        </header>
        <div class="wrap-table100">
            <div class="row mt-4">
                <div class="col-lg-4">
                </div>
                <div class="col-lg-2">
                    <form action="{{ route('refreshData') }}" >
                        @csrf
                        <button type="submit" class="btn btn-primary">Refresh table</button>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form  action="{{ route('updateData') }}"  method="get" class="form-inline">
                        @csrf
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary ">Get latest data</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table100">
                <table
                    data-toggle="table"
                    data-pagination="true"
                    data-search="true">
                    <thead>
                    <tr class="table100-head">
                        <th data-sortable="true" data-field="country">Country</th>
                        <th data-sortable="true" data-field="new_cofirmed ">New confirmed </th>
                        <th data-sortable="true" data-field="total_confirmed">Total confirmed</th>
                        <th data-sortable="true" data-field="new_deaths">New deaths</th>
                        <th data-sortable="true" data-field="total_deaths">Total deaths</th>
                        <th data-sortable="true" data-field="new_recovered">New recovered</th>
                        <th data-sortable="true" data-field="total_recovered">Total recovered</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($countries as $country)
                        <tr>
                            <td> <img src="https://img.icons8.com/color/48/000000/{{str_replace(' ', '-', strtolower($country->country))}}.png" alt="{{$country->country}}" onerror="this.style.display='none'"> {{ $country->country }}</td>
                            <td>{{ $country->new_confirmed }}</td>
                            <td>{{ $country->total_confirmed }}</td>
                            <td>{{ $country->new_deaths }}</td>
                            <td>{{ $country->total_deaths }}</td>
                            <td>{{ $country->new_recovered }}</td>
                            <td>{{ $country->total_recovered }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
</body>
</html>

