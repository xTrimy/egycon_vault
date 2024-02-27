@extends('layouts.app')
@section('page')
  users
@endsection
@section('title')
  Add user
@endsection
@section('content')
  <main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Add User</h2>
      <!-- Display validation errors if any -->
      @if ($errors->any())
        <div class="mb-4">
          @foreach ($errors->all() as $error)
            <div class="text-red-500">{{ $error }}</div>
          @endforeach
        </div>
      @endif

      <!-- Display success message if any -->
      @if (Session::has('success'))
        <div class="mb-4 text-green-500">{{ Session::get('success') }}</div>
      @endif

      <form action="{{ route('add-user') }}" method="post"
        class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        @csrf
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400"><i class="las la-font text-xl"></i> Name</span>
          <input type="text" name="name" value="{{ old('name') }}" required
            class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Name">
        </label>
        <label class="block text-sm mt-2">
          <span class="text-gray-700 dark:text-gray-400"><i class="las la-envelope text-xl"></i> Email</span>
          <input type="email" name="email" value="{{ old('email') }}" required
            class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Email">
        </label>
        <label class="block text-sm mt-2">
          <span class="text-gray-700 dark:text-gray-400"><i class="las la-lock text-xl"></i> Password</span>
          <input type="password" name="password" required
            class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Password">
        </label>
        <label class="block text-sm mt-2">
          <span class="text-gray-700 dark:text-gray-400"><i class="las la-lock text-xl"></i> Confirm
            Password</span>
          <input type="password" name="password_confirmation" required
            class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Confirm Password">
        </label>
        <button type="submit"
          class="mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Add
          User</button>
      </form>
    </div>
  </main>
@endsection
