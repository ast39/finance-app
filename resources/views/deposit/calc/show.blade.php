@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Информация по расчету вклада') }}</div>

                    <div class="card-body">

                        <div class="accordion" id="accordionPanelsStayOpenExample">

                            <div class="accordion-item">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        {{ __('Параметры вклада') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                                    <th scope="col">{{ $info->deposit->title ?? '' }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">{!! Icons::get(Icons::BALANCE) !!} {{ __('Сумма') }}</th>
                                                    <td>{{ number_format($info->deposit->amount ?? '', 2, '.', ' ') }} {{ $info->deposit->currency }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</th>
                                                    <td>{{ number_format($info->deposit->percent ?? '', 2, '.', ' ') }}%</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</th>
                                                    <td>{{ $info->deposit->period ?? '' }} {{ __('(в месяцах)') }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{!! Icons::get(Icons::BALANCE_START) !!} {{ __('Пополнения') }}</th>
                                                    <td>{{ number_format($info->deposit->refill ?? '', 2, '.', ' ') }} {{ $info->deposit->currency }}</td>
                                                </tr>
                                                <tr><td colspan="2">&nbsp;</td></tr>
                                                <tr>
                                                    <th scope="row">{!! Icons::get(Icons::SMILE_NEUTRAL) !!} {{ __('Сумма пополнений') }}</th>
                                                    <td><span class="text-danger">{{ number_format($info->refills ?? '', 2, '.', ' ') }} {{ $info->deposit->currency }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{!! Icons::get(Icons::SMILE_HAPPY) !!} {{ __('Заработок на процентах') }}</th>
                                                    <td><span class="text-success">{{ number_format($info->profit ?? '', 2, '.', ' ') }} {{ $info->deposit->currency }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{!! Icons::get(Icons::SMILE_SAD) !!} {{ __('Снятые проценты') }}</th>
                                                    <td><span class="text-success">{{ number_format($info->was_withdrawn ?? '', 2, '.', ' ') }} {{ $info->deposit->currency }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{!! Icons::get(Icons::BALANCE_CASH) !!} {{ __('Итого к выплате') }}</th>
                                                    <td><span class="text-primary">{{ number_format($info->to_withdraw ?? '', 2, '.', ' ') }} {{ $info->deposit->currency }}</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
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
                                                <th class="text-end">{!! Icons::get(Icons::INSET_LR) !!} {{ __('Входящий баланс') }}</th>
                                                <th class="text-end">{!! Icons::get(Icons::PERCENT) !!} {{ __('Проценты') }}</th>
                                                <th class="text-end">{!! Icons::get(Icons::INSET_UD) !!} {{ __('Пополнение') }}</th>
                                                <th class="text-end">{!! Icons::get(Icons::PROFIT_UP) !!} {{ __('Сумма прироста') }}</th>
                                                <th class="text-end">{!! Icons::get(Icons::BALANCE_CASH) !!} {{ __('Текущий заработок') }}</th>
                                                <th class="text-end">{!! Icons::get(Icons::OUTSET_UD) !!} {{ __('Снятые проценты') }}</th>
                                                <th class="text-end">{!! Icons::get(Icons::OUTSET_LR) !!} {{ __('Исходящий баланс') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($info->details as $row)
                                                <tr>
                                                    <td data-label="#" class="text-center">{{ $loop->iteration }}</td>
                                                    <td data-label="Баланс" class="text-end">{{ number_format($row['inset_balance'], 0, '.', ' ') }} {{ $info->deposit->currency }}</td>
                                                    <td data-label="Проценты" class="text-end">{{ number_format($row['monthly_profit'], 0, '.', ' ') }} {{ $info->deposit->currency }}</td>
                                                    <td data-label="Пополнение" class="text-end">{{ number_format($row['monthly_refill'], 0, '.', ' ') }} {{ $info->deposit->currency }}</td>
                                                    <td data-label="Прирост" class="text-end">{{ number_format($row['monthly_deposit'], 0, '.', ' ') }} {{ $info->deposit->currency }}</td>
                                                    <td data-label="Заработок" class="text-end">{{ number_format($row['total_profit'], 0, '.', ' ') }} {{ $info->deposit->currency }}</td>
                                                    <td data-label="Снято" class="text-end">{{ number_format($row['was_withdrawn'], 0, '.', ' ') }} {{ $info->deposit->currency }}</td>
                                                    <td data-label="Остаток" class="text-end">{{ number_format($row['withdrawal_now'], 0, '.', ' ') }} {{ $info->deposit->currency }}</td>
                                                </tr>
                                            @empty
                                                <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Расчет не удался') }}</div>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="d-grid gap-2 d-md-flex mt-3 justify-content-md-center">
                            @auth()
                                <a href="{{ route('deposit.calc.index') }}" class="btn btn-secondary">{!! Icons::get(Icons::RETURN) !!}  {{ __('Назад') }}</a>
                            @endauth
                            <a href="{{ route('deposit.calc.create') }}" class="btn btn-primary me-md-2">{!! Icons::get(Icons::CALCULATE) !!} {{ __('Рассчитать новый вклад') }}</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
