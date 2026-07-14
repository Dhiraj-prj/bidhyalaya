<div class="global-navbar">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary p-3">
      <div class="container">
  <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ url('/home') }}">
    <img src="{{ asset('logo.png') }}" alt="Logo" style="height: 60px; width: auto;">
    <span class="text-white fw-bold">BIDHYALAYA</span>
  </a>
</div>



            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <!-- Programs Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Programs
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                            @php
                                $categories = App\Models\Program::where("navbarHiddenStatus", "0")
                                    ->where('hideStatus', '0')
                                    ->where('is_deleted', '0')
                                    ->get();
                            @endphp
                            @foreach($categories as $cateitem)
                                <li><a class="dropdown-item" href="{{ url('program/' . $cateitem->slug) }}">{{ $cateitem->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>

                    <!-- Notes Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="notesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Notes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="notesDropdown">
                            @php
                                $notes = App\Models\Post::where('hideStatus', '0')
                                    ->where('is_deleted', '0')
                                    ->where('postType', 'note')
                                    ->get();
                            @endphp
                            @foreach($notes as $post)
                                <li><a class="dropdown-item" href="{{ route('view.note.by.id', $post->id) }}">{{ $post->name }}</a></li>
                            @endforeach

                        </ul>
                    </li>

                    <!-- Past Questions Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="questionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Past Questions
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="questionsDropdown">
                            <li><a class="dropdown-item" href="{{ url('past-questions?program=BBS&type=yearly') }}">BBS</a></li>
                            <li><a class="dropdown-item" href="{{ url('past-questions?program=BBA&type=semester') }}">BBA</a></li>
                        </ul>
                    </li>

<!-- Syllabus Dropdown -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-white" href="#" id="syllabusDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Syllabus
    </a>
    <ul class="dropdown-menu" aria-labelledby="syllabusDropdown">
        <li><a class="dropdown-item" href="{{ url('syllabus?program=BCA') }}" target="_blank">BCA</a></li>
        <li><a class="dropdown-item" href="{{ url('syllabus?program=BBS') }}" target="_blank">BBS</a></li>
    </ul>
</li>


                    <!-- Logout -->
                    @auth
                        <li class="nav-item">
                            <a class="nav-link btn-danger text-white" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- CSS for Hover Effect -->
<style>
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
        transition: opacity 0.2s ease-in-out;
    }

    .dropdown-menu {
        border-radius: 0.5rem;
        padding: 0.5rem;
    }

    .nav-link {
        font-size: 1rem;
        font-weight: 500;
    }
</style>
