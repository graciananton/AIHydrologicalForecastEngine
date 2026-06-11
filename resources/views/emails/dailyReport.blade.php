<p>
    The following are the errors/successes for the AI Hydrological Forecast Engine:
</p>
@php
    $groupedErrors = collect($errors)->groupBy('category');
@endphp

@foreach($groupedErrors as $category => $items)

    <div style="margin-bottom:20px;">
        <h3>{{ $category }}</h3>

        {{-- Errors --}}
        <div>
            <h3>Errors</h3>

            @php
                $errorItems = $items->where('status', '!=', 'success');
            @endphp

            @if($errorItems->count() > 0)
                <ul>
                    @foreach($errorItems as $item)
                        <li>{{ $item['message'] }}</li>
                    @endforeach
                </ul>
            @else
                0 errors found
            @endif
        </div>

        {{-- Success --}}
        <div>
            <h3>Success</h3>

            @php
                $successItems = $items->where('status', 'success');
            @endphp

            @if($successItems->count() > 0)
                <ul>
                    @foreach($successItems as $item)
                        <li>{{ $item['message'] }}</li>
                    @endforeach
                </ul>
            @else
                0 successes found
            @endif
        </div>
    </div>

@endforeach
