@extends('layouts.app')
@section('page')
dashboard
@endsection
@section('title')
Dashboard
@endsection
@section('content')
        <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Dashboard
            </h2>
            <!-- Cards -->
            <div class="grid gap-6 mb-8 md:grid-cols-1 xl:grid-cols-3">
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 justify-center items-center w-12 h-12  text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500"
                >
                  <i class="las la-suitcase text-xl"></i>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Total Belongings
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $belongings->count }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 flex justify-center items-center w-12 h-12 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <i class="las la-arrow-down text-xl"></i>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Belongings INSIDE Vault
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $belongings->count_in }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 w-12 h-12 flex items-center justify-center text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-100 dark:bg-yellow-500"
                >
                  <i class="las la-arrow-up text-xl"></i>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Belongings OUTSIDE Vault
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $belongings->count_out }}
                  </p>
                </div>
              </div>
              
            </div>

            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <x-belongings-table :belongings=$belongings ></x-belongings-table>
              </div>
              <div
              class="mt-4"
              >
                  {{ $belongings->links() }}
                
            </div>

          </div>
        </main>
 @endsection