@extends('layouts.tenant')

@section('title', 'Reports')
@section('page-title', 'Sales Reports')
@section('page-subtitle', 'Business analytics aur sales ki performance')

@section('content')
@php
    $tenant = auth()->user()->tenant;

    $todayRevenue = $todayRevenue ?? 0;
    $weekRevenue = $weekRevenue ?? 0;
    $monthRevenue = $monthRevenue ?? 0;
    $totalRevenue = $totalRevenue ?? 0;

    $chartLabels = collect($chartLabels ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'])
        ->values()
        ->all();

    $chartData = collect($chartData ?? [0, 0, 0, 0, 0, 0, 0])
        ->map(fn ($value) => (float) $value)
        ->values()
        ->all();

    $topProductsCollection = collect($topProducts ?? []);

    $hasChartData = collect($chartData)->contains(
        fn ($value) => (float) $value > 0
    );

    $lastSevenDaysTotal = collect($chartData)->sum();
    $dailyAverage = count($chartData) > 0
        ? $lastSevenDaysTotal / count($chartData)
        : 0;

    $highestRevenue = count($chartData) > 0
        ? max($chartData)
        : 0;

    $highestRevenueIndex = array_search($highestRevenue, $chartData, true);
    $bestDay = $chartLabels[$highestRevenueIndex] ?? '—';

    $maxUnitsSold = max(
        1,
        (int) ($topProductsCollection->max('total_sold') ?? 1)
    );
@endphp

<div class="space-y-6">

    {{-- Page Intro --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-till-400">
                Sales Analytics
            </p>

            <h2 class="mt-1 text-xl font-bold tracking-tight text-white sm:text-2xl">
                Aamdani Ki Performance
            </h2>

            <p class="mt-2 max-w-2xl text-sm text-gray-500">
                Apni aamdani ka trend dekhein aur sabse zyada bikne wale saamaan pehchanein.
            </p>
        </div>

        <div class="inline-flex w-fit items-center gap-2 rounded-xl border border-white/[0.08] bg-white/[0.03] px-3 py-2 text-xs text-gray-400">
            <svg class="h-4 w-4 text-till-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>

            Update: {{ now()->format('d M Y, h:i A') }}
        </div>
    </div>

    {{-- Revenue Stats --}}
    <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">

        {{-- Today --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15 text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <span class="rounded-full bg-emerald-500/10 px-2 py-1 text-[10px] font-bold text-emerald-400">
                    TODAY
                </span>
            </div>

            <p class="truncate text-xl font-black tracking-tight text-emerald-400 sm:text-2xl">
                {{ $tenant->formatMoney($todayRevenue, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Aaj ki aamdani
            </p>
        </article>

        {{-- Week --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-till-500/15 text-till-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M4 19V5m0 14h16M8 16v-4m4 4V8m4 8v-6"/>
                    </svg>
                </div>

                <span class="rounded-full bg-till-500/10 px-2 py-1 text-[10px] font-bold text-till-400">
                    THIS WEEK
                </span>
            </div>

            <p class="truncate text-xl font-black tracking-tight text-till-400 sm:text-2xl">
                {{ $tenant->formatMoney($weekRevenue, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Is hafte ki sales
            </p>
        </article>

        {{-- Month --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-500/15 text-violet-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 3v18h18M7 16v-4m4 4V8m4 8v-6"/>
                    </svg>
                </div>

                <span class="rounded-full bg-violet-500/10 px-2 py-1 text-[10px] font-bold text-violet-400">
                    THIS MONTH
                </span>
            </div>

            <p class="truncate text-xl font-black tracking-tight text-violet-400 sm:text-2xl">
                {{ $tenant->formatMoney($monthRevenue, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Is mahine ki aamdani
            </p>
        </article>

        {{-- Total --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/15 text-amber-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <span class="rounded-full bg-amber-500/10 px-2 py-1 text-[10px] font-bold text-amber-400">
                    ALL TIME
                </span>
            </div>

            <p class="truncate text-xl font-black tracking-tight text-amber-400 sm:text-2xl">
                {{ $tenant->formatMoney($totalRevenue, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Total aamdani
            </p>
        </article>
    </div>

    {{-- Revenue Chart + Quick Insights --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Chart --}}
        <section class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827] xl:col-span-2">
            <div class="flex flex-col gap-3 border-b border-white/[0.07] px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-bold text-white">Aamdani Ka Trend</h3>

                        <span class="rounded-full bg-till-500/10 px-2 py-1 text-[10px] font-bold text-till-400">
                            LAST 7 DAYS
                        </span>
                    </div>

                    <p class="mt-1 text-xs text-gray-500">
                        Mukammal sales se roz ki aamdani.
                    </p>
                </div>

                <div class="text-left sm:text-right">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-600">
                        7 Din Ki Aamdani
                    </p>

                    <p class="mt-1 text-sm font-bold text-till-300">
                        {{ $tenant->formatMoney($lastSevenDaysTotal, 0) }}
                    </p>
                </div>
            </div>

            <div class="p-5">
                @if($hasChartData)
                    <div class="h-[280px] sm:h-[330px]">
                        <canvas id="revenueChart"></canvas>
                    </div>
                @else
                    <div class="flex h-[280px] flex-col items-center justify-center text-center sm:h-[330px]">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4 19V5m0 14h16M8 16v-4m4 4V8m4 8v-6"/>
                            </svg>
                        </div>

                        <p class="text-sm font-bold text-white">Koi aamdani ka data mojood nahi</p>

                        <p class="mt-2 max-w-sm text-xs leading-relaxed text-gray-500">
                            Apni aamdani ka trend dekhne ke liye POS counter se sales complete karein.
                        </p>

                        <a
                            href="{{ route('tenant.pos') }}"
                            class="mt-5 rounded-xl bg-till-600 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-till-500"
                        >
                            POS Counter Kholein
                        </a>
                    </div>
                @endif
            </div>
        </section>

        {{-- Quick Insights --}}
        <section class="rounded-2xl border border-white/[0.08] bg-[#111827]">
            <div class="border-b border-white/[0.07] px-5 py-5">
                <h3 class="text-base font-bold text-white">Foran Ki Malumaat</h3>
                <p class="mt-1 text-xs text-gray-500">
                    Pichle 7 dinon ki khaas baatein.
                </p>
            </div>

            <div class="space-y-4 p-5">

                {{-- 7 day total --}}
                <div class="rounded-xl border border-white/[0.07] bg-white/[0.025] p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-gray-400">
                            Pichle 7 dinon ki aamdani
                        </p>

                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-till-500/15 text-till-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 19V5m0 14h16M8 16v-4m4 4V8m4 8v-6"/>
                            </svg>
                        </div>
                    </div>

                    <p class="mt-3 text-lg font-black text-white">
                        {{ $tenant->formatMoney($lastSevenDaysTotal, 0) }}
                    </p>
                </div>

                {{-- Average --}}
                <div class="rounded-xl border border-white/[0.07] bg-white/[0.025] p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-gray-400">
                            Roz ki average aamdani
                        </p>

                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500/15 text-emerald-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>

                    <p class="mt-3 text-lg font-black text-emerald-400">
                        {{ $tenant->formatMoney($dailyAverage, 0) }}
                    </p>
                </div>

                {{-- Best day --}}
                <div class="rounded-xl border border-white/[0.07] bg-white/[0.025] p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-gray-400">
                            Sabse behtareen din
                        </p>

                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/15 text-amber-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>

                    <p class="mt-3 text-lg font-black text-amber-400">
                        {{ $hasChartData ? $bestDay : '—' }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        {{ $hasChartData ? $tenant->formatMoney($highestRevenue, 0) . ' ki aamdani' : 'Abhi tak koi sale nahi' }}
                    </p>
                </div>
            </div>
        </section>
    </div>

    {{-- Top Products --}}
    <section class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827]">

        <div class="flex flex-col gap-3 border-b border-white/[0.07] px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-base font-bold text-white">Sabse Zyada Bikne Wala Saamaan</h3>

                    <span class="rounded-full bg-white/[0.05] px-2 py-1 text-[10px] font-bold text-gray-400">
                        {{ $topProductsCollection->count() }} products
                    </span>
                </div>

                <p class="mt-1 text-xs text-gray-500">
                    Saamaan total bikri ke hisab se rank kiya gaya hai.
                </p>
            </div>

            <a
                href="{{ route('tenant.products.index') }}"
                class="inline-flex w-fit items-center gap-1.5 text-xs font-semibold text-till-400 transition hover:text-till-300"
            >
                Saamaan Manage Karein
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @forelse($topProductsCollection as $product)
            @php
                $unitsSold = (int) ($product->total_sold ?? 0);

                $percentage = $maxUnitsSold > 0
                    ? min(100, round(($unitsSold / $maxUnitsSold) * 100))
                    : 0;
            @endphp

            <div class="border-b border-white/[0.05] px-5 py-4 last:border-b-0 transition hover:bg-white/[0.02]">
                <div class="flex items-center gap-4">

                    {{-- Rank --}}
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl
                        {{ $loop->iteration === 1
                            ? 'bg-amber-500/15 text-amber-400'
                            : ($loop->iteration === 2
                                ? 'bg-slate-400/10 text-slate-300'
                                : ($loop->iteration === 3
                                    ? 'bg-orange-500/15 text-orange-400'
                                    : 'bg-till-500/10 text-till-400')) }}">
                        <span class="text-xs font-black">#{{ $loop->iteration }}</span>
                    </div>

                    {{-- Name + Progress --}}
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-white">
                                    {{ $product->name }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Abhi ki price:
                                    <span class="font-semibold text-gray-400">
                                        {{ $tenant->formatMoney($product->price ?? 0, 0) }}
                                    </span>
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-sm font-bold text-till-300">
                                    {{ number_format($unitsSold) }} bike
                                </p>

                                <p class="mt-1 text-[10px] text-gray-600">
                                    Bikay hue
                                </p>
                            </div>
                        </div>

                        <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-white/[0.06]">
                            <div
                                class="h-full rounded-full bg-till-500"
                                style="width: {{ $percentage }}%;"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center px-5 py-16 text-center">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>

                <p class="text-sm font-bold text-white">Abhi tak saamaan ki koi sale ka data nahi</p>

                <p class="mt-2 text-xs text-gray-500">
                    Sales mukammal hone ke baad saamaan ki performance nazar aayegi.
                </p>
            </div>
        @endforelse
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if($hasChartData)
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('revenueChart');

    if (!canvas || typeof Chart === 'undefined') {
        return;
    }

    const currencySymbol = @json($tenant->currencySymbol());
    const labels = @json($chartLabels);
    const revenueData = @json($chartData);

    const context = canvas.getContext('2d');

    const chartGradient = context.createLinearGradient(0, 0, 0, 320);
    chartGradient.addColorStop(0, 'rgba(14, 122, 92, 0.30)');
    chartGradient.addColorStop(1, 'rgba(14, 122, 92, 0.01)');

    new Chart(context, {
        type: 'line',

        data: {
            labels: labels,

            datasets: [{
                label: 'Revenue',
                data: revenueData,

                borderColor: '#4fb894',
                backgroundColor: chartGradient,

                borderWidth: 2.5,
                fill: true,
                tension: 0.35,

                pointBackgroundColor: '#4fb894',
                pointBorderColor: '#111827',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            interaction: {
                mode: 'index',
                intersect: false,
            },

            plugins: {
                legend: {
                    display: false,
                },

                tooltip: {
                    backgroundColor: '#111827',
                    titleColor: '#f8fafc',
                    bodyColor: '#cbd5e1',
                    borderColor: 'rgba(148, 163, 184, 0.20)',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,

                    callbacks: {
                        label: function(context) {
                            const value = Number(context.raw || 0);

                            return `${currencySymbol} ${value.toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })}`;
                        }
                    }
                }
            },

            scales: {
                x: {
                    border: {
                        display: false,
                    },

                    grid: {
                        display: false,
                    },

                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 11,
                            weight: '600',
                        }
                    }
                },

                y: {
                    beginAtZero: true,

                    border: {
                        display: false,
                    },

                    grid: {
                        color: 'rgba(148, 163, 184, 0.10)',
                        drawTicks: false,
                    },

                    ticks: {
                        color: '#64748b',
                        padding: 10,

                        font: {
                            size: 11,
                            weight: '600',
                        },

                        callback: function(value) {
                            return `${currencySymbol} ${Number(value).toLocaleString()}`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endif
@endpush