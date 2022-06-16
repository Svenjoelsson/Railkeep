@extends('layouts.app')


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Search results</h1>
            </div>
        </div>
    </div>
</section>

<section class="content-header">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12">
            @if ($result)
            <label>Search value:</label> {{ $searchValue[0]["title"] }}<br /><br />
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Result</td>
                        <td>Type</td>
                    </tr>
                </thead>   
                <tbody>
                
                    @foreach ($result as $row)
                    @if ($row["type"] != 'Search')

                    <tr style="cursor: pointer;" onclick="window.location='{{ $row["link"] }}';">
                        <td><?php if (str_contains($row["title"], $searchValue[0]["title"])) { echo "".$row["title"].""; } else { echo $row["title"]; } ?></td>
                        <td>{{ $row["type"] }}</td>
                    </tr>
                    @endif 
                @endforeach

                
                </tbody>
            </table>
            @else
                   No results found...
            @endif 

        </div>
    </div>
</section>
<script>

$("#content").on('click-row.bs.table', function (e, row, $element) {
    alert('ä    ');
    window.location = $element.data('href');
});


</script>
@endsection
