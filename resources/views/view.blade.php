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
                    <th class="text-right">{{ __('Actions') }}</th>
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
                        <td class="text-right">
                            <a class="btn btn-info"
                               href="{{ route('social.login', ['account' => $config->social_account_id, 'provider' => $config->type]) }}">
                                {{ __('Login') }} {{ $config->type }}
                            </a>
                            <a class="btn btn-danger"
                               href="{{ route('social.credentials.edit', ['configurationID' => $config->id]) }}">
                                {{ __('Edit') }} {{ $config->type }}
                            </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
