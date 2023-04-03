@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Просмотр кошелька : ') . $wallet->title ?? '')

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
                                    <th>{{ $wallet->title ?? '' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>{!! Icons::get(Icons::NOTE) !!} {{ __('Описание') }}</th>
                                    <td>{{ $wallet->note ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::AMOUNT) !!} {{ __('Стартовая сумма') }}</th>
                                    <td>{{ $wallet->amount ?? '' }} {{ __('р.') }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::CHECK_LIST) !!} {{ __('Пополнения (кол-во)') }}</th>
                                    <td>{{ $details->count_deposits ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::PROFIT) !!} {{ __('Пополнения (сумма)') }}</th>
                                    <td>{{ number_format($details->total_deposits ?? 0, 2, '.', ' ') }} {{ __('р.') }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::CHECK_LIST) !!} {{ __('Снятия (кол-во)') }}</th>
                                    <td>{{ $details->count_withdrawals ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::LOSS) !!} {{ __('Снятия (сумма)') }}</th>
                                    <td>{{ number_format($details->total_withdrawals ?? 0, 2, '.', ' ') }} {{ __('р.') }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::BALANCE) !!} {{ __('Баланс') }}</th>
                                    <td>{{ number_format($details->balance ?? 0, 2, '.', ' ') }} {{ __('р.') }}</td>
                                </tr>

                            </tbody>
                        </table>

                        {{-- Действия с кошельком --}}
                        <form method="post" action="{{ route('wallet.destroy', $wallet->wallet_id) }}">
                            @csrf
                            @method('DELETE')

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('wallet.index') }}" class="btn btn-secondary me-md-2">{{ __('Назад') }}</a>
                                <a href="{{ route('wallet.payment.create', $wallet->wallet_id) }}" class="btn btn-primary me-md-2">{{ __('Транзакция') }}</a>
                                <a href="{{ route('wallet.edit', $wallet->wallet_id) }}" class="btn btn-warning me-md-2">{{ __('Изменить') }}</a>
                                <button type="submit" onclick="return confirm('{{ __('Вы уверены, что хотите удалить кошелек?') }}')" class="btn btn-danger">{{ __('Удалить') }}</button>
                            </div>
                        </form>

                        {{-- История транзакций кошелька --}}
                        <div class="accordion-item mt-3">
                            <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    {{ __('История транзакций') }}
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <table class="table table-striped admin-table__adapt admin-table__instrument">
                                        <thead>
                                            <tr>
                                                <th class="text-center" scope="row">#</th>
                                                <th class="text-center">{{ __('Дата') }}</th>
                                                <th class="text-end">{{ __('Входящий баланс') }}</th>
                                                <th class="text-end">{{ __('Транзакция') }}</th>
                                                <th  class="text-center">{{ __('Комментарий') }}</th>
                                                <th class="text-end">{{ __('Исходящий баланс') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($details->details as $row)
                                                <tr>
                                                    <td data-label="#" class="text-center">{{ $loop->iteration }}</td>
                                                    <td data-label="{{ __('Дата') }}" class="text-center">{{ date('d-m-Y', $row['date_time']) }}</td>
                                                    <td data-label="{{ __('Баланс') }}" class="text-end">{{ number_format($row['inset_balance'], 0, '.', ' ') }} {{ __('р.') }}</td>
                                                    <td data-label="{{ __('Прирост') }}" class="text-end {{ $row['transaction_amount'] > 0 ? 'text-success': 'text-danger' }}">
                                                        {{ number_format($row['transaction_amount'], 0, '.', ' ') }} {{ __('р.') }}
                                                    </td>
                                                    <td data-label="{{ __('Комментарий') }}">{{ $row['note'] }}</td>
                                                    <td data-label="{{ __('Остаток') }}" class="text-end">{{ number_format($row['outset_balance'], 0, '.', ' ') }} {{ __('р.') }} <i class="{{ $row['transaction_amount'] > 0 ? 'text-success ' . Icons::PROFIT : 'text-danger ' . Icons::LOSS }}"></i></td>
                                                </tr>
                                            @empty
                                                <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Транзакций не совершалось') }}</div>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
