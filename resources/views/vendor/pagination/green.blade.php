@if ($paginator->hasPages())
    <div class="flex justify-between items-center sm:px-2">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $paginator->firstItem() }}</span> hingga <span class="font-medium">{{ $paginator->lastItem() }}</span> dari <span class="font-medium">{{ $paginator->total() }}</span> laporan
                </p>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    @if ($paginator->onFirstPage())
                        <span class="px-4 py-2 border border-gray-100 rounded-md text-gray-200 text-sm cursor-not-allowed">Prev</span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 border border-gray-200 rounded-md text-gray-500 text-sm hover:bg-gray-50 transition">Prev</a>
                    @endif

                    <span class="px-4 py-2 bg-[#5a8d6e] text-white rounded-md font-bold text-sm shadow-sm">{{ $paginator->currentPage() }}</span>

                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 border border-gray-200 rounded-md text-gray-500 text-sm hover:bg-gray-50 transition">Next</a>
                    @else
                        <span class="px-4 py-2 border border-gray-100 rounded-md text-gray-200 text-sm cursor-not-allowed">Next</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
