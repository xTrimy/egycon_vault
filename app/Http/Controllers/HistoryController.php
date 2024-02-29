<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BelongingHistory;


class HistoryController extends Controller
{
  public function view()
  {
    $historyEntries = BelongingHistory::all(); // Or you can retrieve history entries as needed

    return view('history', ['historyEntries' => $historyEntries]);
  }
}
