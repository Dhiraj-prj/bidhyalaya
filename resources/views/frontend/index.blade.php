@extends('layouts.app')

@section('title', $setting->meta_title)

@section('meta_description', $setting->meta_description)

@section('meta_keyword', $setting->meta_keyword)

@section('content')

<!-- Program Heading -->
@if(isset($program))
    <div class="program-heading">
        <h4>{{ $program->name }}</h4>
    </div>
@endif

<!-- Posts Section -->
@if(isset($posts) && count($posts) > 0)
    @foreach ($posts as $postitem)
        <div class="card card-shadow mt-4">
            <div class="card-body">
                <a href="{{ url('program/'.$program->slug .'/' . $postitem->slug)}}" class="text-decoration-none">
                    <h2 class="post-heading">{{ $postitem->name }}</h2>
                </a>
                <div class="container">
                    <div class="float-start">
                        <h6>Posted on: {{ $postitem->created_at->format('d-m-Y') }}</h6>
                    </div>
                    <div class="float-end">
                        <h6>Posted by: {{ $postitem->user->name }}</h6>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<!-- About Section -->
<div class="py-4 bg-light lazy-bg" style="background-image: url('{{ asset('images/HomeAboutSection (1).png') }}'); background-size: cover; background-position: center;">
    <div class="container py-2">
        <div class="row">
            <div class="col-md-5 text-white py-5">
                <h2 class="font-weight-bold text-primary">Bidhyalaya</h2>
                <div class="underline"></div>
                <p class="lead text-light">
                    Bidhyalaya is a comprehensive online learning platform designed to support students in their academic journey.
                    We provide past questions, study notes, and syllabus to make learning more accessible.
                </p>
                <p class="lead text-light">Join us and enhance your learning experience with the tools and support you need to excel.</p>
            </div>
        </div>
    </div>
</div>

<!-- Programs Section -->
<div class="py-4 bg-white mt-5 shadow-sm">
    <div class="container">
        <div class="row mb-5 text-center">
            <div class="col-md-12">
                <h3 class="font-weight-bold text-dark">Programs</h3>
                <div class="underline mx-auto mb-4"></div>
            </div>

            @foreach ($all_programs as $programItem)
                <div class="col-md-3 mb-4">
                    <div class="card border-0 rounded-lg shadow-sm hover-shadow">
                        <div class="card-body text-center">
                            <a href="{{ url('program/'.$programItem->slug) }}" class="text-decoration-none text-dark">
                                <h5 class="mb-0">{{ $programItem->name }}</h5>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination for Programs -->
        <div class="row">
            <div class="col-md-12 text-center">
                {{ $all_programs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Latest Posts Section -->
<div class="py-4 bg-light">
    <div class="container">
        <div class="row mb-5 text-center">
            <div class="col-md-12">
                <h3 class="font-weight-bold text-dark">Latest Posts</h3>
                <div class="underline mx-auto mb-4"></div>
            </div>

            @foreach ($all_posts as $post)
                <div class="col-md-3 mb-4">
                    <div class="card border-0 rounded-lg shadow-sm hover-shadow">
                        <div class="card-body">


                            <a href="{{ $post->program ? url('program/'.$post->program->slug.'/'.$post->slug) : '#' }}" class="text-decoration-none text-dark">
                                <h5 class="mb-0">{{ $post->name }}</h5>
                            </a>

                            <p class="text-muted small mb-0">
                                {{ \Illuminate\Support\Str::limit(strip_tags($post->description ?? 'No description available'), 100, '...') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="text-center mt-4">
                <a href="{{ url('posts') }}" class="btn btn-primary custom-btn">See More</a>
            </div>
        </div>

        <!-- Pagination for Posts -->
        <div class="row">
            <div class="col-md-12 text-center">
                {{ $all_posts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Advertisement Section -->
<div class="py-3 text-white" style="background-color: #8e71d1">
    <div class="container">
        <div class="border text-center p-5 bg-light shadow-sm rounded-lg">
            <h3 class="font-weight-bold text-dark">Advertise Here</h3>
        </div>
    </div>
</div>

<!-- Animated Footer with Dark/Light Toggle -->
<footer id="animated-footer" class="footer-theme bg-gradient-dark text-light pt-5 pb-4 transition-all">
    <div class="container">
        <div class="d-flex justify-content-end mb-3">
            <button id="themeToggle" class="btn btn-outline-light btn-sm">
                <i class="fas fa-adjust me-1"></i> Toggle Theme
            </button>
        </div>

        <div class="row">
            <!-- About -->
            <div class="col-md-4 mb-4">
                <h4 class="fw-bold">BIDHYALAYA</h4>
                <p class="small">Your academic companion for notes, questions, and resources. Power your learning journey with ease.</p>
                <div class="mt-3">
                    <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Links -->
            <div class="col-md-2 mb-4">
                <h6 class="fw-bold">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ url('/home') }}" class="footer-link">Home</a></li>
                    <li><a href="{{ url('/posts') }}" class="footer-link">Posts</a></li>
                    <li><a href="{{ url('/program') }}" class="footer-link">Programs</a></li>
                    <li><a href="{{ url('/contact') }}" class="footer-link">Contact</a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold">Resources</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="footer-link">Notes & Materials</a></li>
                    <li><a href="#" class="footer-link">Past Questions</a></li>
                    <li><a href="#" class="footer-link">Study Abroad</a></li>
                    <li><a href="#" class="footer-link">Diploma Programs</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold">Stay Updated</h6>
                <form>
                    <input type="email" class="form-control form-control-sm mb-2" placeholder="Your email">
                    <button class="btn btn-primary btn-sm w-100">Subscribe</button>
                </form>
                <p class="small mt-2">No spam. Only important updates.</p>
            </div>
        </div>

        <hr class="border-light">

        <div class="row">
            <div class="col-md-6 small">
                &copy; {{ date('Y') }} BIDHYALAYA. All rights reserved.
            </div>
            <div class="col-md-6 text-end small">
                “Choose, Learn, Succeed”
                
            </div>
        </div>
    </div>
</footer>

@endsection









<style>
    /* Hover effects */
    .card:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
    .custom-btn:hover {
        transform: scale(1.1);
        opacity: 0.9;
        transition: transform 0.3s ease;
    }
    .bg-dark:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
    .card-body:hover a {
        color: #007bff;
        text-decoration: underline;
        transition: color 0.3s ease, text-decoration 0.3s ease;
    }
    h3:hover {
        transform: scale(1.05);
        color: #0056b3;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    /* Gradient Background */
.bg-gradient-dark {
    background: linear-gradient(135deg, #1e1e2f, #383b5d);
    background-size: 200% 200%;
    animation: gradientShift 10s ease infinite;
}

.bg-gradient-light {
    background: linear-gradient(135deg, #f8f9fa, #e3eaf0);
    color: #000 !important;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Smooth Transition */
.transition-all {
    transition: all 0.5s ease;
}

/* Footer Link Styling */
.footer-link {
    color: #ccc;
    text-decoration: none;
}
.footer-link:hover {
    color: #fff;
    text-decoration: underline;
}

/* Light theme overrides */
.bg-gradient-light .footer-link {
    color: #333;
}
.bg-gradient-light .footer-link:hover {
    color: #0d6efd;
}
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const lazyBackgrounds = document.querySelectorAll('.lazy-bg');

        const loadBackground = (element) => {
            const bgUrl = element.getAttribute('data-bg');
            if (bgUrl) {
                element.style.backgroundImage = `url(${bgUrl})`;
                element.classList.remove('lazy-bg');
            }
        };

        const inViewport = (element) => {
            const rect = element.getBoundingClientRect();
            return rect.top <= window.innerHeight && rect.bottom >= 0;
        };

        const onScroll = () => {
            lazyBackgrounds.forEach(element => {
                if (inViewport(element)) {
                    loadBackground(element);
                }
            });
        };

        window.addEventListener('scroll', onScroll);
        onScroll(); // Check initially in case the image is already in the viewport
    });

   
document.addEventListener("DOMContentLoaded", function () {
    const footer = document.getElementById("animated-footer");
    const toggleBtn = document.getElementById("themeToggle");

    toggleBtn.addEventListener("click", () => {
        footer.classList.toggle("bg-gradient-light");
        footer.classList.toggle("bg-gradient-dark");
        footer.classList.toggle("text-dark");
        footer.classList.toggle("text-light");
    });
});


    
</script>
