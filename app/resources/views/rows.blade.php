<!DOCTYPE html>
<html>
<head>
    <title>Список rows with group by date</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
</head>
<body>
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            {{ __('Rows') }}
        </div>
        <div class="card-body">
            @forelse ($rows as $k => $row )
                <b>{{ __('Group_by_date') }} {{ $k }}</b><hr>
                @foreach ($row as $el)
                    <p style="padding-left: 2rem">Id: {{ $el->id }} name: {{ $el->name }} date: {{ $el->publish_date }}</p>
                @endforeach
            @empty
                <p>{{ __('No_rows_found') }}</p>
            @endforelse
        </div>
    </div>
</div>
</body>
</html>
