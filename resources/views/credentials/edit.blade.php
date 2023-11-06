@extends('marketing::layouts.app')

@section('title', __('Configuration Sharing'))

@section('heading')
    {{ __('Social Accounts') }}
@endsection

@section('content')

    <!-- Cards !-->
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">{{ __('Edit Account Credentials') }}</h3>
        </div>


        <div class="card-body">
            <form method="post" action="{{ route('social.credentials.update') }}">
                @csrf

                <input type="hidden" name="id" value="{{ $credentials->social_account_id }}">
                <div class="form-group">
                    <label for="exampleInputEmail1">
                        {{ __('Type') }}
                    </label>
                    <select class="form-control" id="exampleInputEmail1" name="type">
                        <option value="facebook" @if($credentials->type == 'facebook') selected @endif>Facebook</option>
                        <option value="twitter" @if($credentials->type == 'twitter') selected @endif>Twitter</option>
                        <option value="linkedin" @if($credentials->type == 'linkedin') selected @endif>Linkedin</option>
                        <option value="instagram" @if($credentials->type == 'instagram') selected @endif>Instagram</option>
                    </select>
                </div>
                <?php

                    ?>
                <div class="form-group">
                    <label for="exampleInputEmail1">Client Id</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="client_id"
                           value="{{ $credentials->configuration->clientId ?? '' }}"
                           placeholder="Enter Client ID">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Client Secret</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="client_secret"
                           value="{{ $credentials->configuration->clientSecret ?? '' }}"
                           placeholder="Enter Client Secret">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Client Redirect Url</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="redirect"
                           value="{{ $credentials->configuration->redirectUri ?? '' }}"
                           placeholder="Enter Client Redirect">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Scopes</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="scopes"
                           value="{{  implode('', $credentials->configuration->scopes) ?? '' }}"
                           placeholder="Enter Client Scopes">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
