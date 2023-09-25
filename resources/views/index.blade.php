@extends('marketing::layouts.app')

@section('title', __('Social Sharing'))

@section('heading')
    {{ __('Social Sharing') }}
@endsection

@section('content')
    <!-- Create !-->
    <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
        <div>

        </div>
        <div>
            <a class="btn btn-primary btn-md btn-flat" href="{{ route('social.create') }}">
                <i class="fa fa-plus mr-1"></i> New Account
            </a>
        </div>
    </div>
    <!-- Cards !-->
    <div class="card">
        <div class="card-table table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>
                        {{ __('ID') }}
                    </th>
                    <th>{{ __('Account') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts as $account)
                    <tr>
                        <td>
                           {{ $account->account }}
                        </td>
                        <td>
                            1
                        </td>
                        <td class="align-content-end">
                            <a href="{{ route('social.edit', $account->id) }}" class="btn btn-primary btn-sm">{{ __('Edit') }}</a>
                            <a href="{{ route('social.destroy', $account->id) }}" class="btn btn-danger btn-sm">{{ __('Delete') }}</a>
                            <a href="{{ route('social.view', $account->id) }}" class="btn btn-success btn-sm">{{ __('View') }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
