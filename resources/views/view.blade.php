@extends('marketing::layouts.app')

@section('title', __('Social Sharing'))

@section('heading')
    {{ __('Social Sharing') }}
@endsection

@section('content')

    <!-- Cards !-->
    <div class="card">
        <div class="card-table table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>
                        {{ __('ID') }}
                    </th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($account->configuration as $config)
                    <tr>
                        <td>
                           {{  $config->id }}
                        </td>
                        <td>
                            {{  $config->type }}
                        </td>
                        <td>
                            <a class="btn btn-info {{ request()->routeIs('social.linkedin') ? 'active'  : '' }}"
                               href="{{ route('social.linkedin.login', ['account' => $account->id]) }}">
                                {{ __('Login LinkedIn') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
