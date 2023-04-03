@php
    use App\Libs\Icons;
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
                            <form method="get" action="{{ route('wallet.list.index') }}">
                                <legend>{{ __('Фильтрация') }}</legend>

                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label for="balance_from" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('С балансов выше') }}</label>
                                        <input type="text" class="form-control" id="balance_from" name="balance_from" placeholder="1000" value="{{ old('balance_from') ?? request()->balance_from }}" aria-describedby="balance_fromHelp">
                                        <div id="balance_fromHelp" class="form-text">{{ __('Не показывать кошельки с балансом ниже указанного') }}</div>
                                        @error('balance_from')
                                            <p class="text-danger mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-6">
                                        <label for="balance_to" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('С балансов ниже') }}</label>
                                        <input type="text" class="form-control" id="balance_to" name="balance_to" placeholder="100000" value="{{ old('balance_to') ?? request()->balance_to}}" aria-describedby="balance_toHelp">
                                        <div id="balance_toHelp" class="form-text">{{ __('Не показывать кошельки с балансом выше указанного') }}</div>
                                        @error('balance_to')
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <button type="submit" class="btn btn-primary">{{ __('Показать') }}</button>
                                    <a href="{{ route('wallet.list.index') }}" class="btn btn-secondary">{{ __('Сброс') }}</a>
                                </div>
                            </form>
                        </div>

                        {{-- Список кошельков --}}
                        <table class="table table-striped admin-table__adapt admin-table__instrument">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                <th class="text-end">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Первая сумма') }}</th>
                                <th class="text-end">{!! Icons::get(Icons::BALANCE) !!} {{ __('Баланс') }}</th>
                                <th class="text-end">{!! Icons::get(Icons::TOOLS) !!} {{ __('Действия') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($wallets as $wallet)
                                <tr>
                                    <td data-label="#"><b>{{ ($wallets->currentpage() - 1) * $wallets->perpage() + $loop->index + 1 }}</b></td>
                                    <td data-label="{{ __('Название') }}"><a class="text-decoration-none text-primary" href="{{ route('manage.wallet.show', $wallet->wallet_id) }}">{{ $wallet->title ?? '' }}</a></td>
                                    <td class="text-end" data-label="{{ __('Первая сумма') }}">{{ number_format($wallet->amount ?? 0, 2, '.', ' ') }} {{ __('р.') }}</td>
                                    <td class="text-end" data-label="{{ __('Баланс') }}">{{ number_format($wallet->balance ?? 0, 2, '.', ' ') }} {{ __('р.') }}</td>
                                    <td class="text-end" data-label="{{ __('Действия') }}">
                                        <form method="post" action="{{ route('wallet.list.destroy', $wallet->wallet_id) }}">
                                            @csrf
                                            @method('DELETE')

                                            <a title="{{ __('Открыть') }}" href="{{ route('manage.wallet.show', $wallet->wallet_id) }}" class="btn btn-primary"><i class="bi bi-text-center" style="font-size: 1rem"></i></a>
                                            <a title="{{ __('Изменить') }}" href="{{ route('manage.wallet.edit', $wallet->wallet_id) }}" class="btn btn-warning"><i class="bi bi-pencil-square" style="font-size: 1rem"></i></a>
                                            <button type="submit" title="{{ __('Удалить') }}" onclick="return confirm('{{ __('Вы уверены, что хотите удалить кошелек?') }}')" class="btn btn-danger"><i class="bi bi-trash" style="font-size: 1rem"></i></button>
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
                            <a href="{{ route('wallet.list.create') }}" class="btn btn-primary">{{ __('Добавить кошелек') }}</a>
                        </div>

                        {{-- Сальдо по кошелькам --}}
                        <table class="table table-striped mt-3 admin-table__adapt admin-table__instrument">
                            <thead>
                            <tr>
                                <th class="text-center">{!! Icons::get(Icons::WALLET) !!} {{ __('Всего кошельков') }}</th>
                                <th class="text-center">{!! Icons::get(Icons::TRANSACTIONS) !!} {{ __('Транзакций по кошелькам') }}</th>
                                <th class="text-center">{!! Icons::get(Icons::BALANCE) !!} {{ __('Общий баланс кошельков') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td data-label="{{ __('Кол-во кошельков') }}" class="text-center">{{ count($balance ?: []) }}</td>
                                <td data-label="{{ __('Транзакций') }}" class="text-center">{{ number_format(array_sum(array_map(function($e) {return $e['transactions'];}, $balance)), 0, '.', ' ') }}</td>
                                <td data-label="{{ __('Общий баланс') }}" class="text-center">{{ number_format(array_sum(array_map(function($e) {return $e['balance'];}, $balance)), 0, '.', ' ') }} {{ __('р.') }}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
