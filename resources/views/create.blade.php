@extends('marketing::layouts.app')

@section('title', __('Social Sharing'))

@section('heading')
    {{ __('Create Account') }}
@endsection

@section('content')

    <!-- Cards !-->
    <div class="card">
        <div class="card-table table-responsive">
          <form method="post" action="{{ route('social.save') }}">
              //laravel csrf
                @csrf
              <div class="form-group">
                  <label for="exampleInputEmail1">Account Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Enter Account Name">
              </div>
              <input type="hidden" name="user_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
@endsection
