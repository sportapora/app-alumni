@php use Illuminate\Support\Str; @endphp
@extends('layouts.dashboard')

@section('title')
    My Posts in Community
@endsection

@section('content')
    @include('layouts.sections.alert')

    @forelse($posts as $post)
        <div class="card mb-3" style="width:18rem;">
            <img src="{{ asset('storage/' . $post->foto) }}" class="card-img-top" alt="Post Image" width="250px">
            <div class="card-body">
                <h5 class="font-weight-bold">{{ $post->judul }}</h5>
                <p class="card-text d-flex">{!! Str::limit($post->pesan, 150) !!}</p>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#exampleModal{{ $post->id }}">
                    Read More ...
                </button>

                <a href="{{ route('communities.edit', [$post->id]) }}"><button class="btn btn-success">
                        Edit</button></a>

                <button type="submit" class="btn btn-outline-danger">Delete</button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{ $post->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bold" id="exampleModalLabel">{{ $post->judul }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ asset($post->foto) }}" width="400px" alt=""
                                class="rounded rounded-2 img-fluid">
                            <p>{!! $post->pesan !!}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <h3 class="text-center mt-4 font-weight-bold">Tidak ada post terkini</h3>
    @endforelse
@endsection
