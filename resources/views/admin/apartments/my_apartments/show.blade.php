@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card p-3">
                    <h1>
                        {{$apartment->title}}
                    </h1>
                    @if (str_starts_with($apartment->img, 'http'))

                        <img src="{{$apartment->img}}"  class="mb-3" alt="" >

                    @else

                        <img src="{{ asset ('storage') . '/' . $apartment->img}}" class="mb-3" alt ="">

                    @endif 
                    <div class="">
                        <h4>Description:</h4>
                        <p>
                            {{ $apartment->description}}
                        </p>
                    </div>
                    <div>
                        <p>
                            The house has:
                            <ul>
                                <li>
                                    {{ $apartment->no_rooms}} rooms
                                </li>
                                <li>
                                    {{ $apartment->no_beds}} beds
                                </li>
                                <li>
                                    {{ $apartment->no_bathrooms}} bathrooms
                                </li>
                            </ul>
                        </p>
                        <p class="card-text">
                            User of the apartment: {{$apartment->user->name}} {{$apartment->user->surname}}         
                        </p>
                        @if ($apartment->square_meters !== null)
                            <p>
                                Square meters {{ $apartment->square_meters}}mq, and is located in {{ $apartment->address}}
                            </p>
                        @else
                            <p>
                                There are no square meters inserted...
                            </p>
                            <p>
                                The apartment is located in {{$apartment->address}}
                            </p>
                        @endif
                        <p>
                            Services: 
                            @foreach ( $apartment->services as $service )
                                <ul>
                                    <li>
                                        {{ $service->name }}
                                    </li>
                                </ul>
                            @endforeach
                        </p>
                        {{-- @foreach ($apartment->leads as $message)                             
                            <li>                                 
                                <p class="m-0">messaggio da:{{ $message->name }}</p>                                 
                                <p>{{ $message->message }}</p>                             
                            </li>                         
                        @endforeach --}}
                        <p>
                            {{-- messaggio: {{isset($apartment->lead->message) ? $apartment->lead->message : 'Non ci sono messaggi!' }} --}}
                            {{-- Messaggio: {{ $leadCorrect->message }} --}}
                           
                        </p>
                        @if (count($apartment->sponsors) !== 0)
                            <h1>Sponsored</h1>
                        @endif

                    </div>
                    <a href="{{ route('admin.my_apartments.edit', $apartment) }}" class="text-decoration-none">
                        <button class="btn btn-sm btn-success mb-3">
                            Edit
                        </button>
                    </a>
                    <form class="d-inline-block apartment-eraser"  action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST" data-apartment-name="{{ $apartment['title'] }}">
                        @csrf
                        @method('DELETE')
                        
                        <button class="btn btn-sm btn-warning mb-3" >
                            Delete
                        </button>
                    </form>
                    {{-- @dump(count($apartment->sponsors)) --}}
                    <a href="{{ route('admin.my_apartments.messages', $apartment) }}" class="btn btn-primary btn-sm mb-3" id="message-btn">
                        Messages
                    </a>
                    <!-- Button trigger modal -->
                    <button type="button" id="sponsorship" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Sponsorship
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('admin.sponsor', $apartment)}}" method="GET">
                                    <div class="modal-body">
                                        {{-- @dump($apartment) --}}
                                        <h5>Sponsors</h5>
                                        <ul>
                                            @foreach ($sponsors as $sponsor)
                                                <li><strong>{{$sponsor->name}}</strong>: {{$sponsor->no_hours}} hours of sponsorship. <br>
                                                    {{$sponsor->price}} &euro;
                                                </li>
                                            @endforeach
                                        </ul>
                                        <select class="form-select" aria-label="Default select example" name="sponsors" id="sponsors">
                                            <option selected>Please select a sponsorship plan</option>
                                            @foreach ($sponsors as $sponsor)
                                                <option value="{{$sponsor->id}}"> {{$sponsor->name}} - {{$sponsor->price}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @include('admin.apartments.my_apartments.sponsor')
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

