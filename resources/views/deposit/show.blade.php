@php
    use App\Libs\Icons;
    use App\Libs\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Вклад ' . $deposit->deposit->title))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">{{ __('Информация по вкладу') }}</div>

                    <div class="card-body">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                <th>{{ $deposit->deposit->title ?? '' }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>{!! Icons::get(Icons::BANK) !!} {{ __('Банк') }}</th>
                                <td>{{ $deposit->deposit->depositor ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('Дата открытия') }}</th>
                                <td>{{ date('d.m.Y', $deposit->deposit->start_date ?? 0) }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::BALANCE) !!} {{ __('Сумма') }}</th>
                                <td>{{ $deposit->deposit->amount ?? '' }} {{ $deposit->deposit->currency }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</th>
                                <td>{{ $deposit->deposit->percent ?? '' }}%</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</th>
                                <td>{{ $deposit->deposit->period ?? '' }} {{ __('(в месяцах)') }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::BALANCE_START) !!} {{ __('Пополнение') }}</th>
                                <td>{{ $deposit->deposit->refill ?? '' }} {{ $deposit->deposit->currency }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::BALANCE_CASH) !!} {{ __('Капитализация') }}</th>
                                <td>{{ Helper::plowBackText($deposit->deposit->capitalization ?? 0) }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::RESET) !!} {{ __('Проценты') }}</th>
                                <td>{{ ($deposit->deposit->withdrawal ?? 0) == 1 ? __('Снимаются') : __('Капитализируются') }}</td>
                            </tr>
                            </tbody>
                        </table>

                        <form method="post" action="{{ route('deposit.destroy', $deposit->deposit->deposit_id) }}">
                            @csrf
                            @method('DELETE')

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('deposit.index') }}" class="btn btn-secondary me-md-2">{!! Icons::get(Icons::RETURN) !!} Назад</a>
                                <a href="{{ route('deposit.edit', $deposit->deposit->deposit_id) }}" class="btn btn-warning me-md-2">{!! Icons::get(Icons::EDIT) !!} Изменить</a>
                                <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить вклад?')" class="btn btn-danger">{!! Icons::get(Icons::DELETE) !!} Удалить</button>
                            </div>

                        </form>

                        <div class="accordion">
                            <div class="accordion-item mt-3">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                        {{ __('График начислений') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body">
                                        <table class="table table-striped admin-table__adapt admin-table__instrument">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" scope="row">#</th>
                                                    <th class="text-center">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('Месяц') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Баланс') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::PERCENT) !!} {{ __('Проценты') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::BALANCE_UP) !!} {{ __('Пополнение') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::PROFIT_UP) !!} {{ __('Прирост') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::PROFIT) !!} {{ __('Заработок') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::BALANCE_DOWN) !!} {{ __('Снятие') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::BALANCE) !!} {{ __('Остаток') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $profit_percent = $profit_refill = 0;
                                                @endphp

                                                @forelse($deposit->details as $row)
                                                    <tr class="{{ date('Y', $row['date_time']) == date('Y', time()) && date('m', $row['date_time']) == date('m', time()) ? 'bg-like-a-accordion' : '' }}">
                                                        <td data-label="#" class="text-center">{{ $loop->iteration }}</td>
                                                        <td data-label="Месяц" class="text-center">{{ date('d.m.Y', $row['date_time']) }}</td>
                                                        <td data-label="Баланс" class="text-end">{{ number_format($row['inset_balance'], 0, '.', ' ') }} {{ $deposit->deposit->currency }}</td>
                                                        <td data-label="Проценты" class="text-end">{{ number_format($row['monthly_profit'], 0, '.', ' ') }} {{ $deposit->deposit->currency }}</td>
                                                        <td data-label="Пополнение" class="text-end">{{ number_format($row['monthly_refill'], 0, '.', ' ') }} {{ $deposit->deposit->currency }}</td>
                                                        <td data-label="Прирост" class="text-end">{{ number_format($row['monthly_deposit'], 0, '.', ' ') }} {{ $deposit->deposit->currency }}</td>
                                                        <td data-label="Заработок" class="text-end">{{ number_format($row['total_profit'], 0, '.', ' ') }} {{ $deposit->deposit->currency }}</td>
                                                        <td data-label="Снятие" class="text-end">{{ number_format($row['was_withdrawn'], 0, '.', ' ') }} {{ $deposit->deposit->currency }}</td>
                                                        <td data-label="Остаток" class="text-end">{{ number_format($row['withdrawal_now'], 0, '.', ' ') }} {{ $deposit->deposit->currency }}</td>
                                                    </tr>

                                                    @php
                                                        if ($row['date_time'] < time()) {

                                                            $profit_percent += $row['monthly_profit'];
                                                            $profit_refill  += $row['monthly_refill'];
                                                        }
                                                    @endphp
                                                @empty
                                                    <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Расчет не удался') }}</div>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <table class="table table-striped mt-3">
                            <tbody>
                            <tr>
                                <th>{!! Icons::get(Icons::BALANCE_UP) !!} {{ __('Сумма пополнений') }}</th>
                                <td><span class="text-danger">{{ number_format($deposit->refills ?? '', 2, '.', ' ') }} {{ $deposit->deposit->currency }}</span></td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::PROFIT_UP) !!} {{ __('Заработок на процентах') }}</th>
                                <td><span class="text-success">{{ number_format($deposit->profit ?? '', 2, '.', ' ') }} {{ $deposit->deposit->currency }}</span></td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::BALANCE_DOWN) !!} {{ __('Снятые проценты') }}</th>
                                <td><span class="text-success">{{ number_format($deposit->was_withdrawn ?? '', 2, '.', ' ') }} {{ $deposit->deposit->currency }}</span></td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::AMOUNT) !!} {{ __('Итого к выплате') }}</th>
                                <td><span class="text-primary">{{ number_format($deposit->to_withdraw ?? '', 2, '.', ' ') }} {{ $deposit->deposit->currency }}</span></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
