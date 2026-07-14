@extends('layouts.master')

@section('title','Add program')
@section('content')

<div>
    <div class="container-fluid px-4">

        <div class="card mt-4">

            <div class="card-header">
                <h4>Add program</h4>

            </div>
            <div class="card-body">

                @if($errors->any())
                    @foreach ($errors->all() as $error) <!-- Corrected here -->
                     <div class="alert alert-danger">{{ $error }}</div>
                  @endforeach
                @endif


                <form action="{{url('admin/add-program')}}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">
                        <label for="" class="mb-1">Program Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="" class="mb-1">Slug</label>
                        <input type="text" name="slug" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="" class="mb-1">Description</label>
                        <textarea type="text" id="mySummernote" name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <h6>Level Type</h6>
                   <div class="row mb-4">
                        <div class="col-md-3 md3">
                            <input type="radio" name="levelType" value="1">
                        <label for="levelType">is Semester</label>
                        </div>

                        <div class="col-md-3 md3">
                            <input type="radio" name="levelType" value="2">
                        <label for="levelType">is Year</label>
                        </div>
                   </div>
                    <div class="mt-4 mb-3">
                        <h5 >SEO Tags</h5>
                    </div>


                    <div class="mb-3">
                        <label for="" class="mb-1">Meta Tile</label>
                        <input type="text" name="meta_title" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="" class="mb-1">Meta Description</label>
                        <input type="text" name="meta_description" class="form-control">
                    </div>


                    <div class="mb-3">
                        <label for="" class="mb-1">Meta Keyword</label>
                        <input type="text" name="meta_keyword" class="form-control">
                    </div>


                    <h6>Status Mode</h6>
                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <input type="checkbox" name="navbarHiddenStatus">
                            <label for="Navbar Status">Hide from Navbar</label>
                        </div>

                        <div class="col-md-3 mb-3">
                            <input type="checkbox" name="hideStatus">
                            <label for="Status">Hide Post</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Create Program</button>
                    </div>
                </form>
            </div>

        </div>

</div>



@endsection

