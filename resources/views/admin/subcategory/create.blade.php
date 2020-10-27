@extends('admin.layouts.main')
@section('content')

  <div class="d-sm-flex align-item-center justify-content-between mb-4">
    <h1 class="h3 mb-0 ml-4 text-gray-800">
      SubCategory
    </h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="./">
          Home
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        SubCategory
      </li>
    </ol>
  </div>

  <div class="row justify-content-center">
    @if(Session::has('message'))
      <div class="alert alert-success">
        {{Session::get('message')}}
      </div>
    @endif
    <div class="col-lg-10">
      <form action="{{ route('subcategory.store') }}" method="POST">
        @csrf
        <div class="card mb-6">
          <div>
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">
                Create SubCategory
              </h6>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="">
                  Name
                </label>
                <input
                  type="text"
                  name="name"
                  class="form-control @error('name') is-invalid @enderror"
                  id=""
                  aria-describedby=""
                  placeholder="Enter the name of subcategory">
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="form-group">
                <div class="custom-file">
                 <label class="custom-file">
                    Choose Category
                  </label>
                  <select name="category" class="form-control">
                    <option value="">Select Category</option>
                    @foreach(App\Category::all() as $category)
                    <option value="{{$category -> id}}">
                      {{$category -> name}}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
            <button type="submit" class="btn btn-primary">
              Submit
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

@endsection
