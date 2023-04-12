@php
    use App\Libs\Icons;
    use App\Libs\Helper;
    use Illuminate\Support\Arr;
@endphp

@extends('layouts.app')

@section('title', __('Список кошельков'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Мои кошельки') }}</div>

                    <div class="card-body">

                        {{-- Фильтрация кошельков --}}
                        <div class="card-title">
                            <form method="get" action="{{ route('wallet.index') }}">
                                <legend>{{ __('Фильтрация') }}</legend>

                                <div class="row">
                                    <div class="mb-3 col-12">
                                        <label for="currency" class="form-label">{!! Icons::get(Icons::CURRENCY) !!} {{ __('В валюте') }}</label>
                                        <select name="currency" id="currency" class="form-select form-control">
                                            <option title="{{ __('Все') }}" {{ (request()->currency ?? 0) == 0 ? 'selected' : '' }} value="0">{{ __('Все') }}</option>
                                            @forelse($currencies as $currency)
                                                <option title="{{ $currency->title }}" {{ (request()->currency ?? 0) == $currency->currency_id ? 'selected' : '' }} value="{{ $currency->currency_id }}">{{ $currency->abbr }}</option>
                                            @empty
                                                <option value="1">{{ __('RUB') }}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <button type="submit" class="btn btn-primary">{!! Icons::get(Icons::SEARCH) !!} {{ __('Показать') }}</button>
                                    <a href="{{ route('wallet.index') }}" class="btn btn-secondary">{!! Icons::get(Icons::RESET) !!} {{ __('Сброс') }}</a>
                                </div>
                            </form>
                        </div>

                        {{-- Список кошельков --}}
                        <table class="table table-striped admin-table__adapt admin-table__instrument caption-top">
                            <caption>{{ __('Найденные кошельки') }}</caption>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::BALANCE_START) !!} {{ __('Стартовый баланс') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::BALANCE) !!} {{ __('Текущий баланс') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::TOOLS) !!} {{ __('Действия') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($wallets as $wallet)
                                    <tr class="align-middle">
                                        <td data-label="#"><b>{{ ($wallets->currentpage() - 1) * $wallets->perpage() + $loop->index + 1 }}</b></td>
                                        <td data-label="{{ __('Название') }}"><a class="text-decoration-none text-primary" href="{{ route('wallet.show', $wallet->wallet_id) }}">{{ $wallet->title ?? '' }}</a></td>
                                        <td class="text-end" data-label="{{ __('Первая сумма') }}">{{ number_format($wallet->amount ?? 0, 2, '.', ' ') }} {{ $wallet->currency['abbr'] }}</td>
                                        <td class="text-end" data-label="{{ __('Баланс') }}">{{ number_format($wallet->amount + array_sum(Arr::map($wallet->payments->toArray(), function($e) {return $e['amount'];})), 2, '.', ' ') }} {{ $wallet->currency['abbr'] }}</td>
                                        <td class="text-end" data-label="{{ __('Действия') }}">
                                            <form method="post" action="{{ route('wallet.destroy', $wallet->wallet_id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <a title="{{ __('Открыть') }}" href="{{ route('wallet.show', $wallet->wallet_id) }}" class="btn btn-sm btn-primary me-1"><i class="bi bi-text-center" style="font-size: 1rem"></i></a>
                                                <a title="{{ __('Изменить') }}" href="{{ route('wallet.edit', $wallet->wallet_id) }}" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square" style="font-size: 1rem"></i></a>
                                                <button type="submit" title="{{ __('Удалить') }}" onclick="return confirm('{{ __('Вы уверены, что хотите удалить кошелек?') }}')" class="btn btn-sm btn-danger"><i class="bi bi-trash" style="font-size: 1rem"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('У вас нет активных кошельков') }}</div>
                                @endforelse

                                <div>
                                    {{ $wallets->links() }}
                                </div>
                            </tbody>
                        </table>

                        {{-- Кнопка добавления кошелька --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('wallet.create') }}" class="btn btn-primary">{!! Icons::get(Icons::WALLET) !!} {{ __('Добавить кошелек') }}</a>
                        </div>

                        {{-- Сальдо по кошелькам --}}
                        <table class="table table-striped mt-3 admin-table__adapt admin-table__instrument caption-top">
                            <caption>{{ __('Сальдо по всем кошелькам') }}</caption>
                            <thead>
                                <tr>
                                    <th class="text-start">{!! Icons::get(Icons::CURRENCY) !!} {{ __('Валюта') }}</th>
                                    <th class="text-center">{!! Icons::get(Icons::WALLET) !!} {{ __('Всего кошельков') }}</th>
                                    <th class="text-center">{!! Icons::get(Icons::TRANSACTIONS) !!} {{ __('Транзакций по кошелькам') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::BALANCE) !!} {{ __('Общий баланс кошельков') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($wallet_list as $currency => $wallet)
                                    <tr class="align-middle">
                                        <td data-label="{{ __('Валюта') }}" class="text-start">{{ $currency }}</td>
                                        <td data-label="{{ __('Кол-во кошельков') }}" class="text-center">{{ count($wallet ?: []) }}</td>
                                        <td data-label="{{ __('Транзакций') }}" class="text-center">{{ Helper::total($wallet, 'count_transactions') }}</td>
                                        <td data-label="{{ __('Общий баланс') }}" class="text-end">{{ Helper::total($wallet, 'balance', 2) }} {{ $currency }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Кошельков не найдено') }}</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
