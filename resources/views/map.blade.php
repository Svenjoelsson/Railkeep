@extends('layouts.app')

@section('content')
<x-maps-leaflet
zoomLevel="5" 
:markers="$units" 
:centerPoint="['lat' => 61.68051903629829, 'long' => 13.747171927808145]"
></x-maps-leaflet>
@endsection 