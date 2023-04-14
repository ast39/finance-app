@php
    use App\Libs\Icons;
    use App\Libs\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Вклад ' . $credit->credit->title))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">{{ __('Информация по кредиту') }}</div>

                    <div class="card-body">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                    <th>{{ $credit->credit->title ?? '' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>{!! Icons::get(Icons::BANK) !!} {{ __('Кредитор') }}</th>
                                    <td>{{ $credit->credit->creditor ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('Дата взятия кредита') }}</th>
                                    <td>{{ date('d.m.Y', $credit->credit->start_date ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::CALENDAR) !!} {{ __('Дата первого платежа') }}</th>
                                    <td>{{ date('d.m.Y', $credit->credit->payment_date ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</th>
                                    <td>{{ number_format($credit->credit->amount ?? '', 2, '.', ' ') }} {{ $credit->credit->currency }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</th>
                                    <td>{{ number_format($credit->credit->percent ?? '', 2, '.', ' ') }}%</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</th>
                                    <td>{{ Helper::creditPeriod($credit->credit->period ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::PAYMENT) !!} {{ __('Платеж') }}</th>
                                    <td>{{ number_format($credit->credit->payment ?? '', 2, '.', ' ') }} {{ $credit->credit->currency }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::SMILE_SAD) !!} {{ __('Переплата') }}</th>
                                    <td>{{ number_format($credit->overpay ?? '', 2, '.', ' ') }} {{ $credit->credit->currency }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::SMILE_NEUTRAL) !!} {{ __('Сумма выплат') }}</th>
                                    <td>{{ number_format($credit->total_amount ?? '', 2, '.', ' ') }} {{ $credit->credit->currency }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <form method="post" action="{{ route('credit.destroy', $credit->credit->credit_id) }}">
                            @csrf
                            @method('DELETE')

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('credit.index') }}" class="btn btn-secondary me-md-2">{!! Icons::get(Icons::RETURN) !!} {{ __('Назад') }}</a>
                                <a href="{{ route('credit.payment.create', $credit->credit->credit_id) }}" class="btn btn-primary me-md-2">{!! Icons::get(Icons::TRANSACTIONS) !!} {{ __('Внести платеж') }}</a>
                                <a href="{{ route('credit.edit', $credit->credit->credit_id) }}" class="btn btn-warning me-md-2">{!! Icons::get(Icons::EDIT) !!} {{ __('Изменить') }}</a>
                                <button type="submit" onclick="return confirm('{{ __('Вы уверены, что хотите удалить кредит?') }}')" class="btn btn-danger">{!! Icons::get(Icons::DELETE) !!} {{ __('Удалить') }}</button>
                            </div>

                        </form>

                        <div class="accordion">
                            <div class="accordion-item mt-3">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                        {{ __('График платежей') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body">

                                        <table class="table table-striped admin-table__adapt admin-table__instrument">
                                            <thead>
                                            <tr>
                                                <th class="text-center" scope="row">#</th>
                                                <th class="text-center">{!! Icons::get(Icons::CALENDAR) !!} {{ __('Месяц') }}</th>
                                                <th class="text-end">{!! Icons::get(Icons::INSET_LR) !!} {{ __('Баланс') }}</th>
                                                <th class="text-end">{!! Icons::get(Icons::BALANCE_START) !!} {{ __('Платеж') }}</th>
                                                <th class="text-end">{!! Icons::get(Icons::PERCENT) !!} {{ __('Проценты') }}</th>
                                                <th class="text-end">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Тело') }}</th>
                                                <th class="text-end">{!! Icons::get(Icons::OUTSET_LR) !!} {{ __('Остаток') }}</th>
                                                <th class="text-center">{!! Icons::get(Icons::CHECK) !!} {{ __('Оплата') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @php
                                                $payed_percent = $payed_body = $payed_payments = 0;
                                            @endphp

                                            @forelse($credit->details as $row)
                                                <tr class="{{ date('Y', $row['date_time']) == date('Y', time()) && date('m', $row['date_time']) == date('m', time()) ? 'bg-like-a-accordion' : '' }}">
                                                    <td data-label="#" class="text-center">{{ $loop->iteration }}</td>
                                                    <td data-label="{{ __('Месяц') }}" class="text-center">{{ date('d.m.Y', $row['date_time']) }}</td>
                                                    <td data-label="{{ __('Баланс') }}" class="text-end">{{ number_format($row['inset_balance'], 2, '.', ' ') }}</td>
                                                    <td data-label="{{ __('Платеж') }}" class="text-end">{{ number_format($row['credit_payment'], 2, '.', ' ') }}</td>
                                                    <td data-label="{{ __('Проценты') }}" class="text-end">{{ number_format($row['payment_percent'], 2, '.', ' ') }}</td>
                                                    <td data-label="{{ __('Тело') }}" class="text-end">{{ number_format($row['payment_body'], 2, '.', ' ') }}</td>
                                                    <td data-label="{{ __('Остаток') }}" class="text-end">{{ number_format($row['outset_balance'], 2, '.', ' ') }}</td>
                                                    <td title="{{ $row['note'] ?? '' }}" data-label="{{ __('Оплата') }}" class="text-center {{ Helper::getPaymentTextColor($row['date_time'], $row['status']) }}"><i class="{{ Helper::getPaymentIcon($row['date_time'], $row['status']) }}"></i></td>
                                                </tr>

                                                @php
                                                    if (count($credit->credit->payments) >= $loop->iteration) {

                                                        $payed_percent += $row['payment_percent'];
                                                        $payed_body    += $row['payment_body'];
                                                        $payed_payments++;
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
                                    <th>{!! Icons::get(Icons::WAS_PAYED) !!} {{ __('Выплачено долга (План)') }}</th>
                                    <td>{{ number_format($credit->balance_payed ?? '', 2, '.', ' ') }} {{ $credit->credit->currency }}</td>
                                </tr>
                                <tr>
                                    <th>{!! Icons::get(Icons::WILL_PAY) !!} {{ __('Остаток долга (План)') }}</th>
                                    <td>{{ number_format($credit->balance_owed ?? '', 2, '.', ' ') }} {{ $credit->credit->currency }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{!! Icons::get(Icons::CHECK) !!} {{ __('Сделано платежей') }}</th>
                                    <td>{{ $payed_payments }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{!! Icons::get(Icons::CHECK_LIST) !!} {{ __('Осталось платежей') }}</th>
                                    <td>{{ count($credit->details) - $payed_payments }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{!! Icons::get(Icons::SMILE_NEUTRAL) !!} {{ __('Выплачено всего') }}</th>
                                    <td>{{ number_format($payed_percent + $payed_body, 2, '.', ' ') }} {{ __('руб.') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{!! Icons::get(Icons::SMILE_SAD) !!} {{ __('Выплачено процентов') }}</th>
                                    <td>{{ number_format($payed_percent, 2, '.', ' ') }} {{ $credit->credit->currency }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{!! Icons::get(Icons::SMILE_HAPPY) !!} {{ __('Выплачено долга') }}</th>
                                    <td>{{ number_format($payed_body, 2, '.', ' ') }} {{ __('руб.') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{!! Icons::get(Icons::BALANCE_CASH) !!} {{ __('Остаток долга') }}</th>
                                    <td>{{ number_format($credit->credit->amount - $payed_body, 2, '.', ' ') }} {{ __('руб.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
