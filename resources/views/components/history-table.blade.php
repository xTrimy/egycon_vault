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
<table>
    <thead>
        <tr>
            <th>User</th>
            <th>Action</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($historyEntries as $entry)
        <tr>
            <td>{{ $entry->user->name }}</td>
            <td>{{ $entry->action_type }}</td>
            <td>{{ $entry->action_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</table>
