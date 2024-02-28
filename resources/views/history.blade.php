@extends('layouts.app')
@section('page')
  history
@endsection
@section('title')
  Actions History
@endsection
@section('content')
  <main class="h-full pb-16 overflow-y-auto">
  <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
          History
        </h2>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
          <div class="w-full overflow-x-auto">
          </div>
          <div class="mt-4">
            <!-- Pagination -->
          </div>
        </div>
      </div>
  </main>
@endsection
