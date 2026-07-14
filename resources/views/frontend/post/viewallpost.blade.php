@extends('layouts.app')

@section('title',$setting->meta_title)

@section('meta_description', "$setting->meta_description")

@section('meta_keyword', "$setting->meta_keyword")

@section('content')



    <div class="py-5">

        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    {{-- <div class="Program-heading">
                        <h4>{{ $program->name }}</h4>
                    </div> --}}

                        <div class="Program-heading">
                            <h3>All Posts</h3>

                        </div>
                    @forelse ($posts as $postitem)
                        <div class="card card-shadow mt-4">

                            <div class="card-body">
                                @if($program->isNotEmpty())
                                <a href="{{ url('program/' . $program->first()->slug . '/' . $postitem->slug) }}" class="text-decoration-none">
                                    <h2 class="post-heading">{{ $postitem->name }}</h2>
                                </a>
                            @else
                                <a href="#" class="text-decoration-none">
                                    <h2 class="post-heading">{{ $postitem->name }}</h2>
                                </a>
                            @endif
                                <div class="container">
                                    <div class="float-start">
                                        <h6>Posted on: {{ $postitem->created_at ->format('d-m-yy') }}</h6>
                                    </div>
                                    <div class="float-end">
                                        <h6>Posted by: {{ $postitem->user->name  }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card card-shadow mt-4">
                            <div class="card-body">
                                <h2 class="post-heading">No posts available</h2>
                            </div>
                        </div>
                    @endforelse

                    <div class="col-md-12 text-center">
                        {{ $posts->links('pagination::bootstrap-5') }}
                    </div>

                </div>

                <div class="col-md-3">
                    <div class="border p-2">
                        <h4>Advertising Area</h4>
                        <!-- Facebook Page Plugin Embed -->
                        <div class="mt-3">
                            <div class="fb-page"
                                data-href="https://www.facebook.com/Literary-Association-of-Vishwa-Adarsha-Academy-LAVAA-61555370344258/"
                                data-tabs="timeline"
                                data-width="300"
                                data-height="300"
                                data-small-header="false"
                                data-adapt-container-width="true"
                                data-hide-cover="false"
                                data-show-facepile="true">
                                <blockquote cite="https://www.facebook.com/Literary-Association-of-Vishwa-Adarsha-Academy-LAVAA-61555370344258/" class="fb-xfbml-parse-ignore">
                                    <a href="https://www.facebook.com/Literary-Association-of-Vishwa-Adarsha-Academy-LAVAA-61555370344258/">Literary Association of Vishwa Adarsha Academy (LAVAA)</a>
                                </blockquote>
                            </div>
                        </div>

                        <!-- Example Banner Ad -->
                        <div class="mt-4">
                            <a href="https://www.facebook.com/Literary-Association-of-Vishwa-Adarsha-Academy-LAVAA-61555370344258/">
                                <img src="https://via.placeholder.com/300x250" alt="Advertisement" class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('scripts')
    <!-- Include Facebook SDK -->
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0"
        nonce="random_nonce"></script>
@endsection
