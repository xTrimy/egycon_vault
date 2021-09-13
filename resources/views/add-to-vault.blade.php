@extends('layouts.app')
@section('page')
add
@endsection
@section('title')
Add To Vault
@endsection
@section('content')

<main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Add To Vault
            </h2>
            
            @if(Session::has('success'))
            <div
              class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-purple"
            >
              <div class="flex items-center">
                <i class="fas fa-check mr-2"></i>
                <span>{{ Session::get('success') }}</span>
              </div>
            </div>
            @endif
            <!-- General elements -->
            <form method="POST"
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
            @csrf
            @if($errors->any())
                {!! implode('', $errors->all('<div class="text-red-500">:message</div>')) !!}
            @endif
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-user text-xl"></i>
                Person Name
                </span>
                <input
                value="{{ old('name') }}"
                type="text"
                name="name"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Jane Doe"
                />
              </label>
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-envelope text-xl"></i>
                Email Address
                </span>
                <input
                value="{{ old('email') }}"
                    type="email"
                    name="email"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Jane@Doe.com"
                />
              </label>
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-phone text-xl"></i>
                Phone Number
                </span>
                <input
                value="{{ old('phone') }}"
                    type="tel"
                    name="phone"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="01123456789"
                />
              </label>
              <div class="mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-briefcase text-xl"></i>
                Belonging Type
                </span>
                <div class="mt-2">
                    @foreach ($types as $type)
                    <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                    @if(old('type') == $type->id)
                    checked
                    @endif
                      type="radio"
                      class="text-purple-600 border-2 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="type"
                      value="{{ $type->id }}"
                    />
                    <span class="ml-2">{{ $type->name }}</span>
                  </label>
                    @endforeach
                </div>
              </div>
              <div class="mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-ruler-combined text-xl"></i>
                Belonging Size
                </span>
                <div class="mt-2">
                    @foreach ($sizes as $size)
                    <label
                    class="inline-flex items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                    @if(old('size') == $size->id)
                    checked
                    @endif
                      type="radio"
                      class="text-purple-600 border-2 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="size"
                      value="{{ $size->id }}"
                    />
                    <span class="ml-2">{{ $size->name }}</span>
                  </label>
                    @endforeach
                </div>
              </div>
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-brush text-xl"></i>
                Belonging Color
                </span>
                <input 
                value="{{ old('color_name') }}"
                type="hidden" required name="color_name" id="color_name">
                <input
                value="{{ old('color') }}"
                  id="color"
                  type="color"
                  name="color"
                  class="block w-full mt-1 text-sm border dark:focus:shadow-outline-gray "
                  placeholder="#ff0000"
                />
                <p id="color_name_p"
                style="color:{{ old('color') }}">
                {{ old('color_name') }}
                </p>
              </label>
              <script>
                  var color_api_url = "https://www.thecolorapi.com/id?hex=";
                  var color_input = document.getElementById('color');
                  var color_name_input = document.getElementById('color_name');
                  var color_name_p = document.getElementById('color_name_p');
                  color_input.addEventListener('change',function(){
                    var color = this.value.replace('#','');
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var color_n = JSON.parse(xhttp.responseText).name.value;
                            if(JSON.parse(xhttp.responseText).hsl.l > 50){
                                color_name_p.style.backgroundColor = "#000000";
                            }else{
                                color_name_p.style.backgroundColor = "#ffffff";
                            }
                            color_name_p.innerHTML = color_n;
                            color_name_p.style.color = "#"+color;
                            color_name_input.value = color_n;
                        }
                    };
                    xhttp.open("GET", color_api_url+color, true);
                    xhttp.send();
                  });
              </script>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Notes</span>
                <textarea
                name="notes"
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="3"
                  placeholder="(Optional)"
                >{{ old('notes') }}</textarea>
              </label>
              <div class="mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-lock text-xl"></i>
                Add to Slot
                </span>
                <div class="mt-2">
                    @foreach ($slots as $slot)
                    <label
                    class="
                    @if($slot->max - $slot_counts[$slot->name] <= 0 )
                        opacity-50
                    @endif
                    inline-flex relative rounded-full bg-gray-300 items-center text-gray-600 dark:text-gray-400"
                  >
                    <input
                    @if(old('slot_id') == $slot->id)
                    checked
                    @endif
                    @if($slot->max - $slot_counts[$slot->name] <= 0 )
                        disabled
                    @endif
                      type="radio"
                      class="text-purple-600 border-2 transform absolute top-1/2 -translate-y-1/2 left-0 checked:left-full checked:-translate-x-full transition-all form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      name="slot_id"
                      value="{{ $slot->id }}"
                    />
                    <span class="pl-8 ml-2 mr-8">{{ $slot->name }} ({{ $slot->max - $slot_counts[$slot->name] }})</span>
                  </label>
                    @endforeach
                </div>
              </div>
              <button type="submit" class="table items-center mt-4 justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
              Add To Vault
              <span class="ml-2" aria-hidden="true">
                  <i class='las la-arrow-right'></i>
              </span>
            </button>
        </form>

          </div>
        </main>
@endsection
