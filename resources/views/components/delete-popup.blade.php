<div class="fixed top-0 left-0 w-screen h-screen z-50 hidden" id="popup">
  <div class="w-full h-full px-2 sm:px-4 lg:px-32 xl:px-72 py-8 relative z-50 flex items-center justify-center">
    <div class="w-full px-8 py-12 bg-white dark:bg-gray-800 rounded-md">
      <h1 class="dark:text-white text-2xl font-bold my-2" id="popup_title">
        Are you sure?
      </h1>
      <hr class="dark:border-gray-700">
      <p class="my-2 dark:text-white text-lg" id="popup_content">
        This action cannot be undone.
      </p>
      <div class="mt-4 flex">
        <a href="#"><button id="popup_action"
            class="py-2 px-4 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Continue</button></a>
        <button id="popup_cancel"
          class="py-2 px-4 bg-gray-400 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 mx-2 border border-transparent rounded-lg rounded-sm dark:text-white">Cancel</button>
      </div>
    </div>
  </div>
  <div class="absolute top-0 left-0 w-full h-full bg-black opacity-50 z-40">
  </div>
  <div class="absolute top-0 left-0 w-full h-full  backdrop-blur-sm z-40">
  </div>
</div>
<script>
  var popup = document.getElementById('popup');
  var popup_title = popup.querySelector('#popup_title');
  var popup_content = popup.querySelector('#popup_content');
  var popup_action = popup.querySelector('#popup_action');
  var popup_cancel = popup.querySelector('#popup_cancel');
  popup_cancel.onclick = function() {
    this.closest('#popup').style.display = "none";
  }

  function display_popup(element) {
    var content = element.getAttribute('data-content');
    var title = element.getAttribute('data-title');
    var action_url = element.getAttribute('data-action');
    popup_title.innerHTML = title;
    popup_content.innerHTML = content;
    popup_action.parentElement.href = action_url;
    popup.style.display = "block";
  }
</script>
