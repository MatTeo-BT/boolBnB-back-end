@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row">
            <h1 class="mb-4">
                My apartment
            </h1>
            @foreach ($apartments as $apartment)
            
            <div class="col-3">
                <a href="{{ route('guest.apartments.show', $apartment) }}" class="text-decoration-none">
                <div class="card p-2 mb-3" style="height: 350px">
                            
                            {{-- @dump(json_decode($apartment->imgs)) --}}
                            {{--  @foreach (json_decode($apartment->imgs) as $img)
                            <img src="{{$img}}" alt="">
                                
                            @endforeach --}}
                            @if (str_starts_with($apartment->img, 'http'))
                                <img src="{{$apartment->img}}" alt="" >
                                    
                            @else
                                    
                                <img src="{{ asset ('storage') . '/' . $apartment->img}}" alt="">
                            
                            @endif 
                            <h3 class="mt-4">
                                {{$apartment->title}}
                            </h3>
                        </div>
                    </a> 
                </div>
            @endforeach
        </div>
    </div>
@endsection