@extends('layouts.front')

@section('title','Home')

@section('content')

<x-slider :sliders="$globalSliders"/>

<x-home.services />

<x-home.about />

<x-home.team />

@endsection
