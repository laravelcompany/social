@extends('marketing::layouts.app')

@section('title', __('Configuration Sharing'))

@section('heading')
    {{ __('Social Accounts') }}
@endsection

@section('content')

    <!-- Cards !-->
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">{{ __('Edit Account Credentials') }} {{ $socialAccountConfiguration->type }}</h3>
        </div>


        <div class="card-body">
            <form method="post" action="{{ route('social.credentials.update') }}">
                @csrf

                <input type="hidden" name="id" value="{{ $socialAccountConfiguration->id }}">

                <div class="form-group">
                    <label for="exampleInputEmail1">Client Id</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="clientID"
                           value="{{ $credentials->clientId }}"
                           placeholder="Enter Client ID">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Client Secret</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="clientSecret"
                           value="{{ $credentials->clientSecret }}"
                           placeholder="Enter Client ID">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Client Redirect Url</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="redirect_uri"
                           value="{{ $credentials->redirectUri }}"
                           placeholder="Enter Client ID">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
