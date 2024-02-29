<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BelongingHistory;


class HistoryController extends Controller
{
  public function view()
  {
    $historyEntries = BelongingHistory::orderBy('id', 'DESC')->get();

    return view('history', ['historyEntries' => $historyEntries]);
  }
}
