@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row">
            <h2 class="mb-4">
                My apartment
            </h2>
            
           
            
            
                <section >
                    <div class="container">
                        <div class="row">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-3 mb-3">
                                @foreach ($apartments as $apartment)
                                    <div class="col">
                                        <a href="{{ route('admin.my_apartments.show', $apartment) }}" class="text-decoration-none">
                                            <div class="card p-2" style="height: 350px">
                                                
                                                @if (str_starts_with($apartment->img, 'http'))
                                                    <img  src="{{$apartment->img}}" alt="" >
                                                        
                                                @else
                                                        
                                                    <img src="{{ asset ('storage') . '/' . $apartment->img}}" alt="">
                                                
                                                @endif
                                                <div class="card-body">
                                                    <h3>
                                                        {{$apartment->title}}
                                                    </h3>
                                                </div>
                                               
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
               
            
        </div>
    </div>
@endsection