@extends('layouts.app')
@section('page')
  slots
@endsection
@section('title')
  Slots
@endsection
@section('content')
  <main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Slots
      </h2>
      @if (Session::has('error'))
        <div
          class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-red-600 bg-red-100 rounded-lg focus:outline-none focus:shadow-outline-purple">
          <div class="flex items-center">
            <i class="fas fa-check mr-2"></i>
            <span>{{ Session::get('error') }}</span>
          </div>
        </div>
      @endif
      @if (Session::has('success'))
        <div
          class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-purple">
          <div class="flex items-center">
            <i class="fas fa-check mr-2"></i>
            <span>{{ Session::get('success') }}</span>
          </div>
        </div>
      @endif
      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Max Storage</th>
                <th class="px-4 py-3">Current Belongings</th>
                <th class="px-4 py-3">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              @foreach ($slots as $slot)
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                      <div>
                        <p class="font-semibold">{{ $slot->name }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-3 text-sm font-bold">
                    {{ $slot->max }}
                  </td>
                  <td class="px-4 py-3 ">
                    {{ $counts[$slot->name] }}
                  </td>
                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <button
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Edit" onclick="window.location='{{ route('edit_slot', ['id' => $slot->id]) }}'">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                          <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                          </path>
                        </svg>
                      </button>
                      <button
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        onclick="display_popup(this)" data-title="Are you sure you want to Delete this Slot?"
                        data-content="By Pressing Continue. This Slot will be deleted and cannot be undone."
                        aria-label="Delete" data-action="{{ route('delete_slot', ['id' => $slot->id]) }}">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
        <div class="mt-4">
          <!-- Pagination -->
          {{ $slots->links() }}
        </div>
      </div>
    </div>
  </main>
@endsection
