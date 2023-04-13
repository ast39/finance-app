@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Просмотр кошелька : ') . $wallet['title'] ?? '')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">

                    <div class="card-header">{{ __('Информация по кошельку') }}</div>

                    <div class="card-body">

                        {{-- Данные о кошельке --}}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                    <th>{{ $wallet['title'] ?? '' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>{!! Icons::get(Icons::NOTE) !!} {{ __('Описание') }}</th>
                                    <td>{{ $wallet['note'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::BALANCE_START) !!} {{ __('Стартовая сумма') }}</th>
                                    <td>{{ number_format($wallet['amount'] ?? 0, 2, '.', ' ') }} {{ $wallet['currency']['abbr'] }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::INSET_COUNT) !!} {{ __('Пополнения (кол-во)') }}</th>
                                    <td>{{ $wallet['count_deposits'] ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::INSET_UD) !!} {{ __('Пополнения (сумма)') }}</th>
                                    <td>{{ number_format($wallet['total_deposits'] ?? 0, 2, '.', ' ') }} {{ $wallet['currency']['abbr'] }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::OUTSET_COUNT) !!} {{ __('Снятия (кол-во)') }}</th>
                                    <td>{{ $wallet['count_withdrawals'] ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::OUTSET_UD) !!} {{ __('Снятия (сумма)') }}</th>
                                    <td>{{ number_format($wallet['total_withdrawals'] ?? 0, 2, '.', ' ') }} {{ $wallet['currency']['abbr'] }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::BALANCE) !!} {{ __('Баланс') }}</th>
                                    <td>{{ number_format($wallet['balance'] ?? 0, 2, '.', ' ') }} {{ $wallet['currency']['abbr'] }}</td>
                                </tr>

                            </tbody>
                        </table>

                        {{-- Действия с кошельком --}}
                        <form method="post" action="{{ route('wallet.destroy', $wallet['wallet_id']) }}">
                            @csrf
                            @method('DELETE')

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('wallet.index') }}" class="btn btn-secondary me-md-2">{!! Icons::get(Icons::RETURN) !!} {{ __('Назад') }}</a>
                                <a href="{{ route('wallet.payment.create', $wallet['wallet_id']) }}" class="btn btn-primary me-md-2">{!! Icons::get(Icons::TRANSACTIONS) !!} {{ __('Транзакция') }}</a>
                                <a href="{{ route('wallet.edit', $wallet['wallet_id']) }}" class="btn btn-warning me-md-2">{!! Icons::get(Icons::EDIT) !!} {{ __('Изменить') }}</a>
                                <button type="submit" onclick="return confirm('{{ __('Вы уверены, что хотите удалить кошелек?') }}')" class="btn btn-danger">{!! Icons::get(Icons::DELETE) !!} {{ __('Удалить') }}</button>
                            </div>
                        </form>

                        {{-- История транзакций кошелька --}}
                        <div class="accordion">
                            <div class="accordion-item mt-3">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                                        {{ __('История транзакций') }}
                                    </button>
                                </h2>

                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body">
                                        <table class="table table-striped admin-table__adapt admin-table__instrument">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" scope="row">#</th>
                                                    <th class="text-center">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('Дата') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::INSET_LR) !!} {{ __('Входящий баланс') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::PROFIT_UP) !!} {{ __('Транзакция') }}</th>
                                                    <th  class="text-center">{!! Icons::get(Icons::NOTE) !!} {{ __('Комментарий') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::OUTSET_LR) !!} {{ __('Исходящий баланс') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::TOOLS) !!} {{ __('Действия') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($wallet['payments'] as $payment)
                                                    <tr class="align-middle">
                                                        <td data-label="#" class="text-center">{{ $loop->iteration }}</td>
                                                        <td data-label="{{ __('Дата') }}" class="text-center">{{ date('d.m.Y', $payment['date_time']) }}</td>
                                                        <td data-label="{{ __('Баланс') }}" class="text-end">{{ number_format($payment['inset_balance'], 2, '.', ' ') }} {{ $wallet['currency']['abbr'] }}</td>
                                                        <td data-label="{{ __('Прирост') }}" class="text-end {{ $payment['transaction_amount'] > 0 ? 'text-success': 'text-danger' }}">
                                                           {{ number_format($payment['transaction_amount'], 2, '.', ' ') }} {{ $wallet['currency']['abbr'] }}
                                                        </td>
                                                        <td data-label="{{ __('Комментарий') }}" class="text-center">{{ $payment['note'] }}</td>
                                                        <td data-label="{{ __('Остаток') }}" class="text-end">{{ number_format($payment['outset_balance'], 2, '.', ' ') }} {{ $wallet['currency']['abbr'] }} <i class="{{ $payment['transaction_amount'] > 0 ? 'text-success ' . Icons::PROFIT : 'text-danger ' . Icons::LOSS }}"></i></td>
                                                        <td class="text-end" data-label="{{ __('Действия') }}">
                                                            <form method="post" action="{{ route('wallet.payment.destroy', $payment['payment_id']) }}">
                                                                @csrf
                                                                @method('DELETE')

                                                                <a title="{{ __('Изменить') }}" href="{{ route('wallet.payment.edit', $payment['payment_id']) }}" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square" style="font-size: 1rem"></i></a>
                                                                <button type="submit" title="{{ __('Удалить') }}" onclick="return confirm('{{ __('Вы уверены, что хотите удалить транзакцию?') }}')" class="btn btn-sm btn-danger"><i class="bi bi-trash" style="font-size: 1rem"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Транзакций не совершалось') }}</div>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        {{-- Ошибки если есть --}}
                                        @if(count($errors) > 0)
                                            <div class="alert alert-danger mt-3">
                                                <ul>
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
