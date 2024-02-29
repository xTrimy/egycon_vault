@if (Session::has('success'))
<div class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-purple">
  <div class="flex items-center">
    <i class="fas fa-check mr-2"></i>
    <span>{{ Session::get('success') }}</span>
  </div>
</div>
@endif
<table class="w-full whitespace-no-wrap">
  <thead>
    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
      <th class="px-4 py-3">Belonging Info</th>
      <th class="px-4 py-3">User</th>
      <th class="px-4 py-3">Action</th>
      <th class="px-4 py-3">Date</th>
    </tr>
  </thead>
  <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
    @foreach($historyEntries as $entry)
    <tr class="text-gray-700 dark:text-gray-400">
      <td class="px-4 py-3">
        <div class="flex items-center text-sm">
          <!-- Avatar with inset shadow -->
          <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
            <img class="object-cover w-full h-full rounded-full" src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ" alt="" loading="lazy" />
            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
          </div>
          <div>
            <p class="font-semibold"> {{ \App\Models\Belonging::find($entry->item_id)->name ?? 'N/A' }}
            </p>
            <p class="text-xs text-gray-600 dark:text-gray-400">
              {{ \App\Models\Belonging::find($entry->item_id)->type->name ?? 'N/A' }}
              {{ \App\Models\Belonging::find($entry->item_id)->size->name ?? 'N/A' }}
            </p>
          </div>
        </div>
      </td>
      <td class="px-4 py-3 ">{{ $entry->user->name }}</td>
      <td class="px-4 py-3 ">{{ $entry->action_type }}</td>
      <td class="px-4 py-3 ">{{ $entry->action_date }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
