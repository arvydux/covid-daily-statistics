<div class="limiter">
    <div class="container-table100">
        <header class="text-center">
            <h1 class="display-4">Covid-19 latest statistics</h1>
            <h2 class="text-center text-primary">Last updated: {{$lastUpdatedAt}}</h2>
        </header>
        <div class="wrap-table100">
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
