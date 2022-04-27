@extends('layouts.app')

<!--['lat' => 57.78326001570019, 'long' => 14.162159960732922, 'info' => 'Your Title'] -->


@section('content')
<x-maps-leaflet 
zoomLevel="6" 
:markers="$units" 
:centerPoint="['lat' => 57.58753126651317, 'long' => 13.922573161065014]"
></x-maps-leaflet>
@endsection
