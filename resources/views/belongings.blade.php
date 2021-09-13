@extends('layouts.app')
@section('page')
belongings
@endsection
@section('title')
Belongings
@endsection
@section('content')
        <main class="h-full pb-16 overflow-y-auto">
          <div class="container grid px-6 mx-auto">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Belongings
            </h2>
            
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <x-belongings-table :belongings=$belongings ></x-belongings-table>
              </div>
              <div
                class="mt-4"
              >
                <!-- Pagination -->
                  {{ $belongings->links() }}
              </div>
            </div>
          </div>
        </main>

@endsection