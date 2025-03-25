 @extends('marketing::layouts.app')

@section('title', __('Social Sharing'))

@section('heading')
    {{ __('Social Sharing') }} {{ $account->account }}
@endsection

@section('content')
    <!-- Create !-->
    <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
        <div>
            <a class="btn btn-primary btn-md btn-flat" href="{{ route('social.credentials.create', ['account' => $account->id]) }}">
                <i class="fa fa-plus mr-1"></i> Create Connection
            </a>
        </div>
    </div>
    <!-- Cards !-->
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
                    <th>{{ __('Information') }}</th>
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
                        <td>
                           @todo get the access token validation or date when expires for each social account <br>
                           @todo get the number of posts for each social account
                        </td>
                        <td class="text-right">
                            <a class="btn btn-info"
                               href="{{ route('social.login', ['account' => $config->social_account_id, 'provider' => $config->type]) }}">
                                {{ __('Login') }} {{ $config->type }}
                            </a>
                            <a class="btn btn-success"
                               href="{{ route('social.credentials.edit', ['account' => $config->social_account_id, 'provider' => $config->type]) }}">
                                {{ __('Edit') }} {{ $config->type }}
                            </a>
                            <a class="btn btn-danger"
                               href="{{ route('social.credentials.destroy', ['account' => $config->social_account_id, 'provider' => $config->type]) }}">
                                {{ __('Delete') }} {{ $config->type }}
                            </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
