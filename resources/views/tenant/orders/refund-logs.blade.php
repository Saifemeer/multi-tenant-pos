@extends('layouts.tenant')

@section('title', 'Refund Logs')
@section('page-title', 'Refund Audit Log')
@section('page-subtitle', 'Apni team ke sare refunds ka jaiza lein')

@section('content')
@php
    $tenant = auth()->user()->tenant;

    $pageLogs = $logs->getCollection();

    $reviewedOnPage = $pageLogs
        ->filter(fn ($log) => (bool) $log->is_reviewed)
        ->count();

    $pendingOnPage = $pageLogs->count() - $reviewedOnPage;

    $refundValueOnPage = $pageLogs->sum(
        fn ($log) => (float) (optional($log->order)->total ?? 0)
    );
@endphp

<div class="space-y-6">

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        <div class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-4 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/15 text-red-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>

                <span class="rounded-full bg-red-500/10 px-2 py-1 text-[10px] font-bold text-red-400">
                    ALL TIME
                </span>
            </div>

            <p class="text-2xl font-black text-red-400">
                {{ number_format($logs->total()) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Total refund records
            </p>
        </div>

        <div class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-4 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/15 text-amber-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <span class="rounded-full bg-amber-500/10 px-2 py-1 text-[10px] font-bold text-amber-400">
                    THIS PAGE
                </span>
            </div>

            <p class="truncate text-xl font-black text-amber-400 sm:text-2xl">
                {{ $tenant->formatMoney($refundValueOnPage, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Is page par dikhayi gayi refund ki qeemat
            </p>
        </div>

        <div class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-4 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15 text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <span class="rounded-full bg-emerald-500/10 px-2 py-1 text-[10px] font-bold text-emerald-400">
                    REVIEWED
                </span>
            </div>

            <p class="text-2xl font-black text-emerald-400">
                {{ $reviewedOnPage }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Is page par review ho chuke refunds
            </p>
        </div>

        <div class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-4 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-till-500/15 text-till-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.94 4h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                    </svg>
                </div>

                <span class="rounded-full bg-till-500/10 px-2 py-1 text-[10px] font-bold text-till-400">
                    PENDING
                </span>
            </div>

            <p class="text-2xl font-black text-till-400">
                {{ $pendingOnPage }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Review ka intezar karne wale refunds
            </p>
        </div>
    </div>

    <section class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827]">

        <div class="flex flex-col gap-4 border-b border-white/[0.07] p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-white">Sare Refunds</h2>

                    <span class="rounded-full bg-white/[0.05] px-2.5 py-1 text-[10px] font-bold text-gray-400">
                        {{ $logs->total() }} total
                    </span>
                </div>

                <p class="mt-1 text-xs text-gray-500">
                    Is page par <span id="visibleRefundCount">{{ $logs->count() }}</span> refund records dikha rahe hain.
                </p>
            </div>

            @if($logs->count() > 0)
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-5.2-5.2m2.2-5.3a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                        </svg>

                        <input
                            id="refundSearch"
                            type="search"
                            placeholder="Order, user ya wajah se search karein..."
                            class="w-full rounded-xl border border-white/[0.09] bg-[#0c1320] py-2.5 pl-10 pr-4 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 sm:w-64"
                        >
                    </div>

                    <select
                        id="reviewFilter"
                        class="rounded-xl border border-white/[0.09] bg-[#0c1320] px-3 py-2.5 text-sm text-gray-300 outline-none focus:border-till-500"
                    >
                        <option value="all">Sare Reviews</option>
                        <option value="reviewed">Review Ho Gaya</option>
                        <option value="pending">Pending</option>
                    </select>

                    <button
                        id="clearRefundFilters"
                        type="button"
                        class="hidden px-2 text-xs font-semibold text-till-400 hover:text-till-300"
                    >
                        Saaf Karein
                    </button>
                </div>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-[1050px] w-full">
                <thead>
                    <tr class="border-b border-white/[0.07] bg-white/[0.015]">
                        <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Order
                        </th>

                        <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Refund Karne Wala
                        </th>

                        <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Wajah
                        </th>

                        <th class="px-4 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Raqam
                        </th>

                        <th class="px-4 py-4 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Review Ka Status
                        </th>

                        <th class="px-4 py-4 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Receipt
                        </th>

                        <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Tareekh
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($logs as $log)
                        @php
                            $orderNumber = optional($log->order)->order_number ?? 'Order mojood nahi';
                            $refundedByName = optional($log->refundedBy)->name ?? 'Nagumnaam user';
                            $refundedByRole = optional($log->refundedBy)->role ?? '';
                            $refundAmount = optional($log->order)->total ?? 0;

                            $searchText = strtolower(
                                $orderNumber . ' ' .
                                $refundedByName . ' ' .
                                ($log->reason ?? '')
                            );
                        @endphp

                        <tr
                            class="refund-row border-b border-white/[0.05] transition hover:bg-white/[0.02]"
                            data-refund-row
                            data-search="{{ $searchText }}"
                            data-review="{{ $log->is_reviewed ? 'reviewed' : 'pending' }}"
                        >
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-till-400">
                                    {{ $orderNumber }}
                                </p>

                                <p class="mt-1 text-[10px] text-gray-600">
                                    Refund ki gayi sale
                                </p>
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-till-500/15 text-[10px] font-bold text-till-300">
                                        {{ strtoupper(substr($refundedByName, 0, 2)) }}
                                    </div>

                                    <div>
                                        <p class="max-w-[150px] truncate text-sm font-semibold text-white">
                                            {{ $refundedByName }}
                                        </p>

                                        <p class="mt-0.5 text-[10px] capitalize text-gray-600">
                                            {{ $refundedByRole }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <p
                                    class="max-w-[260px] truncate text-sm text-gray-400"
                                    title="{{ $log->reason }}"
                                >
                                    {{ $log->reason }}
                                </p>
                            </td>

                            <td class="px-4 py-4 text-right">
                                <p class="text-sm font-bold text-red-400">
                                    {{ $tenant->formatMoney($refundAmount) }}
                                </p>
                            </td>

                            <td class="px-4 py-4 text-center">
                                @if($log->is_reviewed)
                                    <div class="inline-flex flex-col items-center gap-1">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-1 text-[11px] font-semibold text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                            Review Ho Gaya
                                        </span>

                                        @if($log->reviewedBy)
                                            <span class="max-w-[120px] truncate text-[10px] text-gray-600">
                                                {{ $log->reviewedBy->name }} ne
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <form action="{{ route('tenant.refund-logs.mark-reviewed', $log) }}" method="POST">
                                        @csrf

                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-amber-500/20 bg-amber-500/10 px-2.5 py-1.5 text-[11px] font-semibold text-amber-400 transition hover:bg-amber-500/15"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Reviewed Mark Karein
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-center">
                                @if($log->order)
                                    <a
                                        href="{{ route('tenant.receipts.view', $log->order) }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-till-500/10 px-2.5 py-1.5 text-[11px] font-semibold text-till-400 hover:bg-till-500/15 hover:text-till-300"
                                    >
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Dekhein
                                    </a>
                                @else
                                    <span class="text-xs text-gray-700">—</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <p class="text-xs font-medium text-gray-300">
                                    {{ $log->created_at->format('d M Y') }}
                                </p>

                                <p class="mt-1 text-[10px] text-gray-600">
                                    {{ $log->created_at->format('h:i A') }}
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-400">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>

                                    <h3 class="text-sm font-bold text-white">Koi refund record nahi</h3>

                                    <p class="mt-2 text-xs leading-relaxed text-gray-500">
                                        Jab aapki team koi refund karegi, uska record yahan nazar aayega.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="noRefundResults" class="hidden">
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="mx-auto flex max-w-sm flex-col items-center">
                                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M21 21l-5-5m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>

                                <h3 class="text-sm font-bold text-white">Koi milta julta refund nahi mila</h3>

                                <p class="mt-2 text-xs text-gray-500">
                                    Koi aur search try karein ya review filter saaf karein.
                                </p>

                                <button
                                    id="clearRefundFiltersEmpty"
                                    type="button"
                                    class="mt-5 rounded-xl border border-white/[0.10] bg-white/[0.03] px-4 py-2 text-xs font-semibold text-gray-300 hover:bg-white/[0.06]"
                                >
                                    Filters Saaf Karein
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="flex flex-col gap-3 border-t border-white/[0.07] px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-gray-500">
                    <span class="font-semibold text-gray-300">{{ $logs->firstItem() ?? 0 }}</span>
                    –
                    <span class="font-semibold text-gray-300">{{ $logs->lastItem() ?? 0 }}</span>
                    of
                    <span class="font-semibold text-gray-300">{{ $logs->total() }}</span>
                    refunds dikha rahe hain
                </p>

                <div class="flex items-center gap-2">
                    @if($logs->onFirstPage())
                        <span class="rounded-lg border border-white/[0.06] bg-white/[0.02] px-3 py-2 text-xs font-semibold text-gray-600">
                            Pichla
                        </span>
                    @else
                        <a
                            href="{{ $logs->previousPageUrl() }}"
                            class="rounded-lg border border-white/[0.10] bg-white/[0.03] px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/[0.07] hover:text-white"
                        >
                            Pichla
                        </a>
                    @endif

                    <span class="px-2 text-xs text-gray-500">
                        Page {{ $logs->currentPage() }} / {{ $logs->lastPage() }}
                    </span>

                    @if($logs->hasMorePages())
                        <a
                            href="{{ $logs->nextPageUrl() }}"
                            class="rounded-lg border border-white/[0.10] bg-white/[0.03] px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/[0.07] hover:text-white"
                        >
                            Agla
                        </a>
                    @else
                        <span class="rounded-lg border border-white/[0.06] bg-white/[0.02] px-3 py-2 text-xs font-semibold text-gray-600">
                            Agla
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const searchInput = document.getElementById('refundSearch');
    const reviewFilter = document.getElementById('reviewFilter');
    const clearFiltersButton = document.getElementById('clearRefundFilters');
    const clearFiltersEmptyButton = document.getElementById('clearRefundFiltersEmpty');

    const noResultsRow = document.getElementById('noRefundResults');
    const visibleCount = document.getElementById('visibleRefundCount');

    const refundRows = Array.from(document.querySelectorAll('[data-refund-row]'));

    function applyRefundFilters() {
        if (!searchInput || !reviewFilter) {
            return;
        }

        const query = searchInput.value.trim().toLowerCase();
        const selectedReview = reviewFilter.value;

        let visible = 0;

        refundRows.forEach(row => {
            const searchValue = row.dataset.search || '';
            const reviewValue = row.dataset.review || '';

            const searchMatches = !query || searchValue.includes(query);
            const reviewMatches = selectedReview === 'all' || reviewValue === selectedReview;

            const shouldShow = searchMatches && reviewMatches;

            row.hidden = !shouldShow;

            if (shouldShow) {
                visible++;
            }
        });

        if (visibleCount) {
            visibleCount.textContent = visible;
        }

        const filtersActive = query || selectedReview !== 'all';

        clearFiltersButton?.classList.toggle('hidden', !filtersActive);

        if (noResultsRow && refundRows.length > 0) {
            noResultsRow.classList.toggle('hidden', visible > 0);
        }
    }

    function clearRefundFilters() {
        if (searchInput) {
            searchInput.value = '';
        }

        if (reviewFilter) {
            reviewFilter.value = 'all';
        }

        applyRefundFilters();
        searchInput?.focus();
    }

    searchInput?.addEventListener('input', applyRefundFilters);
    reviewFilter?.addEventListener('change', applyRefundFilters);

    clearFiltersButton?.addEventListener('click', clearRefundFilters);
    clearFiltersEmptyButton?.addEventListener('click', clearRefundFilters);
})();
</script>
@endpush