@extends('layouts.app')


@section('content')
<x-maps-leaflet zoomLevel="6" :centerPoint="['lat' => 57.58753126651317, 'long' => 13.922573161065014]"></x-maps-leaflet>
@endsection
