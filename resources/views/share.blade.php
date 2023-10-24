@extends('marketing::layouts.app')

@section('title', __('Social Sharing'))

@section('heading')
    {{ __('Social Twitter') }}
@endsection

@section('content')

    <!-- Share Card !-->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Social Share') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-12">
                    <form action="{{ route('social.share.send') }}" method="post">
                        @csrf
                        <input type="hidden" name="account" value="{{$account}}" id="">

                        <div class="form-group">
                            <label for="title">{{ __('Url') }}</label>
                            <small class="form-text text-muted">
                                {{ __('The url you want to share') }}
                            </small>
                            <input type="text" name="url" id="url" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="message">{{ __('Message') }}</label>
                            <small class="form-text text-muted">
                                {{ __('The message you want to share - You can add even #tags') }}
                            </small>
                            <textarea name="message" id="message" class="form-control" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Share</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection
