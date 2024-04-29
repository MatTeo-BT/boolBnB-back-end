@extends('layouts.app')

@section('head-title')
    @yield('page-title')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">

            @include('partials.error')

            <form action="@yield('form-action')" method="POST" enctype="multipart/form-data">
                @csrf
                @yield('form-method')
                
                <div class="form-group mb-3">
                    <label for="title">Insert title *</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{old('title', $apartment->title)}}">
                </div>
                <div class="form-group mb-3">
                    <label for="description">Please type a description</label>
                    <textarea type="description" class="form-control" id="description" name="description" cols="30" rows="10"> {{old('description', $apartment->description)}}
                    </textarea>
                </div>
                <div class="form-group mb-3">
                    <div>
                        <label for="no_rooms">Number of rooms *</label>
                        <input type="number" class="form-control w-50" id="no_rooms" name="no_rooms" value="{{old('no_rooms', $apartment->no_rooms)}}">
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="no_beds">Number of beds *</label>
                    <input type="number" class="form-control w-50" id="no_beds" value="{{old('no_beds', $apartment->no_beds)}}" name="no_beds">
                </div>

                <div class="form-group mb-3">
                    <label for="no_bathrooms">Number of bath *</label>
                    <input type="text" class="form-control w-50" id="no_bathrooms" name="no_bathrooms" value="{{old('no_bathrooms', $apartment->no_bathrooms)}}">
                </div>
                <div class="form-group mb-3">
                    <label for="square_meters">Square meters</label>
                    <input type="number" class="form-control w-50" id="square_meters" name="square_meters" value="{{old('square_meters', $apartment->square_meters)}}">
                </div>
                <div class="form-group position-relative mb-3">
                    <label for="address">Address of the apartment *</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{old('address', $apartment->address)}}">
                    
                    <ul id="searchResults" class="position-absolute d-none" >

                    </ul>
                </div>
                {{-- <div class="form-group mb-3">
                    <label>Select if u want to put an url or upload a file</label>
                    <input type="radio" class="form-check-input mt-0" id="file" name="file" value="file">
                    <input type="radio" class="form-check-input" id="url" name="url" value="url">
                </div> --}}

                @if (str_starts_with($apartment->img, 'http://127'))
                <div class="form-group mb-3">
                    <label for="img" class="form-label">Image *</label>
                    <input type="file" class="form-control" id="img" name="img" value="{{old('img', $apartment->img)}}">
                </div>
                @else
                    <div class="form-group mb-3">
                        <label for="img" class="form-label">Image *</label>
                        <input type="text" class="form-control" id="img" name="img" value="{{old('img', $apartment->img)}}">
                    </div>
                @endif
                {{-- <div class="form-group mb-3">
                    <label for="visible" class="form-label">Visible?</label>
                    <input type="radio" class="form-control" id="visible" name="visible" value="{{old('visible', $apartment->visible)}}">
                </div> --}}
                <div class="form-group mb-3">
                    <label for="price">Price *</label>
                    <input type="number" class="form-control d-inline w-50" id="price" name="price" value="{{old('price', $apartment->price)}}" step="0.01">
                </div>
                <div class="mb-3 input-group">
                    <div>
                        @foreach ($services as $service )
                            <input class="form-check-input" type="checkbox" name="services[]" id="services {{ $service->id }}" value="{{ $service->id }}"
                            {{ in_Array( $service->id, old('service', $apartment->services->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label for="services {{ $service->id }}">{{ $service->name }}</label>
                            
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">@yield('page-title')</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="../../../../js/app.js"></script>
@endsection