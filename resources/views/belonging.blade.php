@extends('layouts.app')
@section('page')
    belongings
@endsection
@section('title')
    {{ $belonging->name }}
@endsection
@section('content')
    {{-- <x-belonging-image-selector /> --}}
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Belonging
            </h2>
            @if (Session::has('success'))
                <div
                    class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-purple">
                    <div class="flex items-center">
                        <i class="fas fa-check mr-2"></i>
                        <span>{{ Session::get('success') }}</span>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                {!! implode('', $errors->all('<div class="text-red-500">:message</div>')) !!}
            @endif
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto bg-white dark:bg-gray-800 px-4 py-8">
                    <div id="belonging-image-editor-overlay"></div>
                    <div id="belonging-image-editor-container">
                        <div id="belonging-image-container" class="w-48 h-48 bg-black rounded-lg relative overflow-hidden">
                            @if ($belonging->image)
                                <div class=" bg-black absolute w-full h-full top-0 left-0 flex justify-center items-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-5.2-5.2M11 15.5a4.5 4.5 0 100-9 4.5 4.5 0 000 9z"></path>
                                    </svg>
                                </div>
                                <img id="viewer-image"
                                    class="object-cover cursor-pointer transition-opacity absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 hover:opacity-40 w-full h-full"
                                    src="{{ asset('images/belongings/' . $belonging->image) }}" alt=""
                                    loading="lazy" />
                                <canvas id="draw-canvas" class="absolute top-0 left-0 cursor-crosshair" width="192"
                                    height="192"></canvas>
                            @else
                                <form id="belonging-image-form" class="w-full h-full"
                                    action="{{ route('belonging-image', ['id' => $belonging->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <label class="w-full h-full cursor-pointer" title="Add belonging image">
                                        <input name="image" id="belonging-image-input" type="file" class="hidden" />
                                        <div
                                            class="flex items-center justify-center w-full h-full bg-gray-200 hover:bg-gray-400 text-gray-400 hover:text-gray-200 transition-colors">
                                            <i class="las la-camera text-4xl "></i>
                                        </div>
                                        <div id="belonging-image"
                                            class="absolute inset-0 flex items-center justify-center opacity-50 hover:opacity-40 transition-opacity hidden">
                                        </div>
                                    </label>
                                </form>
                                <div id="image-loader"
                                    class="w-full h-full absolute flex items-center justify-center top-0 left-0 z-10 bg-black bg-opacity-50 hidden">
                                    <span class="loader"></span>
                                </div>
                            @endif
                        </div>
                        @if ($belonging->image)
                            <button id="draw-on-image" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Draw on
                                Image</button>
                            <button id="save-drawing" class="mt-4 bg-green-500 text-white px-4 py-2 rounded"
                                data-route="{{ route('belonging-drawing-save', ['id' => $belonging->id]) }}">Save
                                Drawing</button>
                            <button id="cancel-drawing" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
                            <p class=" text-black dark:text-white">
                                Replace Image?
                            </p>
                            <div class="w-48 h-12 bg-black rounded-lg relative overflow-hidden">
                                <form id="belonging-image-form" class="w-full h-full"
                                    action="{{ route('belonging-image', ['id' => $belonging->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <label class="w-full h-full cursor-pointer" title="Add belonging image">
                                        <input name="image" id="belonging-image-input" type="file" class="hidden" />
                                        <div
                                            class="flex items-center justify-center w-full h-full bg-gray-200 hover:bg-gray-400 text-gray-400 hover:text-gray-200 transition-colors">
                                            <i class="las la-camera text-4xl "></i>
                                        </div>
                                        <div id="belonging-image"
                                            class="absolute inset-0 flex items-center justify-center opacity-50 hover:opacity-40 transition-opacity hidden">
                                        </div>
                                    </label>
                                </form>
                                <div id="image-loader"
                                    class="w-full h-full absolute flex items-center justify-center top-0 left-0 z-10 bg-black bg-opacity-50 hidden">
                                    <span class="loader"></span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <table class="w-full dark:text-white">
                        <tr>
                            <th class="w-24 text-right pr-4">Name: </th>
                            <td>{{ $belonging->name }}</td>
                        </tr>
                        <tr>
                            <th class="w-24 text-right pr-4">Type: </th>
                            <td>{{ $belonging->visitor->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="w-24 text-right pr-4">Email: </th>
                            <td>{{ $belonging->email }}</td>
                        </tr>
                        <tr>
                            <th class="w-24 text-right pr-4">Phone: </th>
                            <td>{{ $belonging->phone }}</td>
                        </tr>
                        <tr>
                            <th class="w-24 text-right pr-4">Code: </th>
                            <td class="font-bold">{{ $belonging->code }}</td>
                        </tr>
                        <tr>
                            <th class="w-24 text-right pr-4">Size: </th>
                            <td class="font-bold">{{ $belonging->size->name }}</td>
                        </tr>
                        <tr>
                            <th class="w-24 text-right pr-4">Type: </th>
                            <td class="font-bold">{{ $belonging->type->name }}</td>
                        </tr>
                        <tr>
                            <th class="w-24 text-right pr-4">Slot: </th>
                            <td class="font-bold">{{ $belonging->slot->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="w-24 text-right pr-4">Color: </th>
                            <td class="font-bold" style="color:{{ $belonging->color }}">{{ $belonging->color_name }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-24 text-right pr-4">Notes: </th>
                            <td>{{ $belonging->notes ? $belonging->notes : 'None' }}</td>
                        </tr>
                        <tr>
                            <th class="w-24 text-right pr-4">Status: </th>
                            <td class="font-bold">
                                @if ($belonging->status == 1)
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        INSIDE
                                    </span>
                                    <a href="{{ route('status', ['id' => $belonging->id]) }}"><span
                                            class="ml-2 text-purple-500 underline">
                                            Change to outside</span></a>
                                @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                        OUTSIDE
                                    </span>
                                    <a href="{{ route('status', ['id' => $belonging->id]) }}"><span
                                            class="ml-2 text-purple-500 underline">
                                            Change to inside</span></a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-24 text-right pr-4">WA Message Status: </th>

                            <td class="font-bold">
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
                                    <span class="ml-2">
                                        {{ $belonging->whatsappMessage->failure_reason }}
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                                        N/A
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/imageViewer.js') }}"></script>
    <script src="{{ asset('js/belongingImage.js') }}"></script>
    <script src="{{ asset('js/imageDrawing.js') }}"></script>
@endsection
