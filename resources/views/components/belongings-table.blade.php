@if (Session::has('success'))
    <div
        class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-purple">
        <div class="flex items-center">
            <i class="fas fa-check mr-2"></i>
            <span>{{ Session::get('success') }}</span>
        </div>
    </div>
@endif
<table class="w-full whitespace-no-wrap">
    <thead>
        <tr
            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <th class="px-4 py-3">Belonging Info</th>
            <th class="px-4 py-3">Visitor Type</th>
            <th class="px-4 py-3">Color</th>
            <th class="px-4 py-3">Email</th>
            <th class="px-4 py-3">Slot</th>

            <th class="px-4 py-3">Phone</th>
            <th class="px-4 py-3">Added by</th>

            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">WA message status</th>
            <th class="px-4 py-3">Date</th>
            <th class="px-4 py-3">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
        @foreach ($belongings as $belonging)
            <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                        <!-- Avatar with inset shadow -->
                        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                            <img class="object-cover w-full h-full rounded-full"
                                src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
                                alt="" loading="lazy" />
                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                        </div>
                        <div>
                            <p class="font-semibold"> {{ $belonging->name ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ $belonging->type->name ?? 'N/A' }}
                                {{ $belonging->size->name ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 text-sm font-bold" style="color:{{ $belonging->visitor }}">
                    {{ $belonging->visitor->name ?? 'N/A' }}
                </td>
                <td class="px-4 py-3 text-sm font-bold" style="color:{{ $belonging->color }}">
                    {{ $belonging->color_name }}
                </td>
                <td class="px-4 py-3 ">
                    {{ $belonging->email }}
                </td>
                <td class="px-4 py-3 ">
                    {{ $belonging->code }}
                </td>
                <td class="px-4 py-3 ">
                    {{ $belonging->phone }}
                </td>
                <td class="px-4 py-3 ">
                    {{ \App\Models\User::find($belonging->added_by_id)->name ?? 'N/A' }}
                </td>
                <td class="px-4 py-3 text-xs">
                    @if ($belonging->status == 1)
                        <span
                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                            INSIDE
                        </span>
                    @else
                        <span
                            class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                            OUTSIDE
                        </span>
                    @endif
                </td>
                <td class="px-4 py-3 text-xs">
                    @if (!$belonging->whatsappMessage)
                        <span
                            class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                            N/A
                        </span>
                    @elseif ($belonging->whatsappMessage->isSentSuccessfully())
                        <span
                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                            Sent
                        </span>
                    @elseif ($belonging->whatsappMessage->isFailed())
                        <span
                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                            Failed
                        </span>
                    @else
                        <span
                            class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                            N/A
                        </span>
                    @endif
                </td>
                <td title="{{ $belonging->created_at }}" class="px-4 py-3 text-sm">
                    {{ $belonging->created_at->diffForHumans() }}
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                        <button
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Edit"
                            onclick="window.location='{{ route('edit', ['id' => $belonging->id]) }}'">
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                </path>
                            </svg>
                        </button>
                        <button
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            onclick="display_popup(this)" data-title="Are you sure you want to Delete this belonging?"
                            data-content="By Pressing Continue. This belonging will be deleted and cannot be undone."
                            aria-label="Delete" data-action="{{ route('delete', ['id' => $belonging->id]) }}">
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <a href="{{ route('belonging', $belonging->id) }}" style="display: block;">
                            <button
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="View">
                                <i class="fas fa-eye text-xl"></i>
                            </button>
                        </a>
                    </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
