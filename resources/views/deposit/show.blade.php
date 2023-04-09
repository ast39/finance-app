@php
    use App\Libs\Icons;
    use App\Libs\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Вклад ' . $deposit->title))

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
                                <th>{{ $deposit->title ?? '' }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>{!! Icons::get(Icons::BANK) !!} {{ __('Банк') }}</th>
                                <td>{{ $deposit->depositor ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::CALENDAR_MONTH) !!} {{ __('Дата открытия') }}</th>
                                <td>{{ date('d-m-Y', $deposit->start_date ?? 0) }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</th>
                                <td>{{ $deposit->amount ?? '' }} {{ __('р.') }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</th>
                                <td>{{ $deposit->percent ?? '' }}%</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</th>
                                <td>{{ $deposit->period ?? '' }} {{ __('(в месяцах)') }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::PAYMENT) !!} {{ __('Пополнение') }}</th>
                                <td>{{ $deposit->refill ?? '' }} {{ __('р.') }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::CAPITALIZATION) !!} {{ __('Капитализация') }}</th>
                                <td>{{ Helper::plowBackText($deposit->capitalization ?? 0) }}</td>
                            </tr>
                            <tr>
                                <th>{!! Icons::get(Icons::WITHDRAWAL) !!} {{ __('Проценты') }}</th>
                                <td>{{ ($deposit->withdrawal ?? 0) == 1 ? __('Снимаются') : __('Капитализируются') }}</td>
                            </tr>
                            </tbody>
                        </table>

                        <form method="post" action="{{ route('deposit.destroy', $deposit->deposit_id) }}">
                            @csrf
                            @method('DELETE')

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('deposit.index') }}" class="btn btn-secondary me-md-2">Назад</a>
                                <a href="{{ route('deposit.edit', $deposit->deposit_id) }}" class="btn btn-warning me-md-2">Изменить</a>
                                <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить вклад?')" class="btn btn-danger">Удалить</button>
                            </div>

                        </form>

{{--                        <div class="accordion-item mt-3">--}}
{{--                            <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingTwo">--}}
{{--                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">--}}
{{--                                    {{ __('График начислений') }}--}}
{{--                                </button>--}}
{{--                            </h2>--}}
{{--                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">--}}
{{--                                <div class="accordion-body">--}}
{{--                                    <table class="table table-striped admin-table__adapt admin-table__instrument">--}}
{{--                                        <thead>--}}
{{--                                        <tr>--}}
{{--                                            <th class="text-center" scope="row">#</th>--}}
{{--                                            <th class="text-center">{{ __('Месяц') }}</th>--}}
{{--                                            <th class="text-end">{{ __('Баланс') }}</th>--}}
{{--                                            <th class="text-end">{{ __('Проценты') }}</th>--}}
{{--                                            <th class="text-end">{{ __('Пополнение') }}</th>--}}
{{--                                            <th class="text-end">{{ __('Прирост') }}</th>--}}
{{--                                            <th class="text-end">{{ __('Заработок') }}</th>--}}
{{--                                            <th class="text-end">{{ __('Снятие') }}</th>--}}
{{--                                            <th class="text-end">{{ __('Остаток') }}</th>--}}
{{--                                        </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tbody>--}}

{{--                                        @php--}}
{{--                                            $profit_percent = $profit_refill = 0;--}}
{{--                                        @endphp--}}

{{--                                        @forelse($details->details as $row)--}}
{{--                                            <tr class="{{ date('Y', $row['date_time']) == date('Y', time()) && date('m', $row['date_time']) == date('m', time()) ? 'bg-active': '' }}">--}}
{{--                                                <td data-label="#" class="text-center">{{ $loop->iteration }}</td>--}}
{{--                                                <td data-label="Месяц" class="text-center">{{ date('d-m-Y', $row['date_time']) }}</td>--}}
{{--                                                <td data-label="Баланс" class="text-end">{{ number_format($row['inset_balance'], 0, '.', ' ') }} {{ __('р.') }}</td>--}}
{{--                                                <td data-label="Проценты" class="text-end">{{ number_format($row['monthly_profit'], 0, '.', ' ') }} {{ __('р.') }}</td>--}}
{{--                                                <td data-label="Пополнение" class="text-end">{{ number_format($row['monthly_refill'], 0, '.', ' ') }} {{ __('р.') }}</td>--}}
{{--                                                <td data-label="Прирост" class="text-end">{{ number_format($row['monthly_deposit'], 0, '.', ' ') }} {{ __('р.') }}</td>--}}
{{--                                                <td data-label="Заработок" class="text-end">{{ number_format($row['total_profit'], 0, '.', ' ') }} {{ __('р.') }}</td>--}}
{{--                                                <td data-label="Снятие" class="text-end">{{ number_format($row['was_withdrawn'], 0, '.', ' ') }} {{ __('р.') }}</td>--}}
{{--                                                <td data-label="Остаток" class="text-end">{{ number_format($row['withdrawal_now'], 0, '.', ' ') }} {{ __('р.') }}</td>--}}
{{--                                            </tr>--}}

{{--                                            @php--}}
{{--                                                if ($row['date_time'] < time()) {--}}

{{--                                                    $profit_percent += $row['monthly_profit'];--}}
{{--                                                    $profit_refill  += $row['monthly_refill'];--}}
{{--                                                }--}}
{{--                                            @endphp--}}
{{--                                        @empty--}}
{{--                                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Рассчет не удался') }}</div>--}}
{{--                                        @endforelse--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <table class="table table-striped mt-3">--}}
{{--                            <tbody>--}}
{{--                            <tr>--}}
{{--                                <th>{!! Icons::get(Icons::PAYMENT) !!} {{ __('Сумма пополнений') }}</th>--}}
{{--                                <td><span class="text-danger">{{ number_format($details->refills ?? '', 2, '.', ' ') }} {{ __('р.') }}</span></td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th>{!! Icons::get(Icons::PROFIT) !!} {{ __('Заработок на процентах') }}</th>--}}
{{--                                <td><span class="text-success">{{ number_format($details->profit ?? '', 2, '.', ' ') }} {{ __('р.') }}</span></td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th>{!! Icons::get(Icons::WITHDRAWAL) !!} {{ __('Снятые проценты') }}</th>--}}
{{--                                <td><span class="text-success">{{ number_format($details->was_withdrawn ?? '', 2, '.', ' ') }} {{ __('р.') }}</span></td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th>{!! Icons::get(Icons::BALANCE) !!} {{ __('Итого к выплате') }}</th>--}}
{{--                                <td><span class="text-primary">{{ number_format($details->to_withdraw ?? '', 2, '.', ' ') }} {{ __('р.') }}</span></td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
