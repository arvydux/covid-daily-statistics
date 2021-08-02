<div class="limiter">
    <div class="container-table100">
        <header class="text-center">
            <h1 class="display-4">Covid-19 statistics by request</h1>
        </header>
        <div class="wrap-table100">
            <div class="mt-2">
                <form action="{{ route('showCovidData') }}" >
                    <div class="row">
                        @csrf
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>From</label>
                                <input type ="date" name="from" value=@if(request()->get('from')) {{request()->get('from')}} @else  {{date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-d'))))}} @endif?>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>To</label>
                                <input type ="date" name="to"   max="{{ now()->toDateString('Y-m-d') }}" value=@if(request()->get('to')) {{request()->get('to')}} @else  {{date('Y-m-d')}} @endif>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Select countries or provinces</label>
                                <select id="countriesNames" name="country">
                                    <option value="" selected disabled>Countries and provinces</option>
                                    @foreach($countryNamesList as $slug => $country)
                                        <option @if($slug === request()->get('country')) selected @endif value="{{ $slug }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary ">Get requested data</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table100">
                <h2 class="text-center"> {{ucfirst($singleCountryName)}} <span><img src="https://img.icons8.com/color/48/000000/{{$singleCountryName}}.png" alt="{{$singleCountryName}}" onerror="this.style.display='none'"></span></h2>
                <table class="mt-2"
                       data-toggle="table"
                       data-pagination="true">
                    <thead>
                    <tr class="table100-head">
                        <th data-sortable="true" data-field="country">Date</th>
                        <th data-sortable="true" data-field="new_cofirmed ">Confirmed</th>
                        <th data-sortable="true" data-field="new_deaths">Deaths</th>
                        <th data-sortable="true" data-field="new_recovered">Recovered</th>
                        <th data-sortable="true" data-field="total_recovered">Active</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($singleCountryData as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d\T00:00:00\Z", $item->Date )->format("Y-m-d") }}</td>
                            <td>{{ $item->Confirmed }}</td>
                            <td>{{ $item->Deaths }}</td>
                            <td>{{ $item->Recovered }}</td>
                            <td>{{ $item->Active }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
