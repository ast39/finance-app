@php
    use App\Libs\Icons;
    use App\Libs\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Календарь событий'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">{{ __('Календарь событий') }}</div>

                    <div class="card-body">

                        {{-- Текущие платежи --}}
                        <table class="table table-striped mt-3 admin-table__adapt admin-table__instrument caption-top">
                            <caption>{{ __('Платежи в этом месяце') }}</caption>
                            <thead>
                                <tr>
                                    <th class="text-start">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('Дата') }}</th>
                                    <th class="text-start">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                    <th class="text-start">{!! Icons::get(Icons::BANK) !!} {{ __('Банк') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::BALANCE_START) !!} {{ __('Платеж') }}</th>
                                    <th class="text-center">{!! Icons::get(Icons::CHECK) !!} {{ __('Статус') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($credits as $credit)
                                    <tr>
                                        <td data-label="{{ __('Дата') }}" class="text-start">{{ $credit['date'] }}</td>
                                        <td data-label="{{ __('Название') }}" class="text-start"><a href="{{ route('credit.show', $credit['credit_id']) }}">{{ $credit['title'] }}</a></td>
                                        <td data-label="{{ __('Банк') }}" class="text-start">{{ $credit['creditor'] }}</td>
                                        <td data-label="{{ __('Платеж') }}" class="text-end">{{ $credit['payment'] }} {{ $credit['currency'] }}</td>
                                        <td data-label="{{ __('Статус') }}" class="text-center {{ Helper::getPaymentTextColor($credit['date_time'], $credit['status']) }}"><i class="{{ Helper::getPaymentIcon($credit['date_time'], $credit['status']) }}"></i></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">У Вас не текущих кредитов</td></tr>
                                @endforelse
                                <tr><td colspan="5">&nbsp;</td></tr>
                                <tr>
                                    <td class="text-secondary" colspan="2">{!! Icons::get(Icons::SMILE_NEUTRAL) !!} Финансовая нагрузка:</td>
                                    <td class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency'] == 'RUB';}))), 2, '.', ' ') }} RUB</td>
                                    <td class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency'] == 'USD';}))), 2, '.', ' ') }} USD</td>
                                    <td class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency'] == 'EUR';}))), 2, '.', ' ') }} EUR</td>
                                </tr>
                                <tr>
                                    <td class="text-success" colspan="2">{!! Icons::get(Icons::SMILE_HAPPY) !!} Выплачено в этом месяце:</td>
                                    <td class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency'] == 'RUB' && $e['status'] == true;}))), 2, '.', ' ') }} RUB</td>
                                    <td class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency'] == 'USD' && $e['status'] == true;}))), 2, '.', ' ') }} USD</td>
                                    <td class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency'] == 'EUR' && $e['status'] == true;}))), 2, '.', ' ') }} EUR</td>
                                </tr>
                                <tr>
                                    <td class="text-danger" colspan="2">{!! Icons::get(Icons::SMILE_SAD) !!} Осталось выплатить в этом месяце:</td>
                                    <td class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency'] == 'RUB' && $e['status'] == false;}))), 2, '.', ' ') }} RUB</td>
                                    <td class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency'] == 'USD' && $e['status'] == false;}))), 2, '.', ' ') }} USD</td>
                                    <td class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency'] == 'EUR' && $e['status'] == false;}))), 2, '.', ' ') }} EUR</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
