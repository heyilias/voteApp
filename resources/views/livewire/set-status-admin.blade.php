{{-- SET STATUS --}}
<div class="relative"
    x-data="{ isOpen: false }"
    x-init ="
        window.livewire.on('statusWasUpdated', ()=>{
            isOpen = false
        })
    "
    >

<button type="button" 
      @click="isOpen = !isOpen"
      class="flex items-center justify-center w-36 h-11 text-sm font-semibold rounded-xl border 
      border-gray-200 hover:bg-gray-400 bg-gray-200 transition duration-150 ease-in px-4 py-3 mt-2 md:mt-0">
   <span>Set Status</span>
   <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
   </svg>
</button>

<div 
   @keydown.escape.window="isOpen = false"
   x-cloak  {{-- addresses this scenario by hiding the element it's attached to until Alpine is fully loaded on the page. --}}
   x-show.transition.origin.top.left="isOpen" 
   @click.away = "isOpen=false"
   class="absolute z-20 w-64 md:w-76 text-left font-semibold text-sm bg-white shadow-dialog rounded-xl mt-2">
   <form wire:submit.prevent="setStatus" action="#" class="space-y-4 px-4 py-6">
      <div class="space-y-2">
         <div>
         <label class="inline-flex items-center">
            <input class="form-radio" wire:model="status" type="radio" checked="" class="bg-gray-200 text-gray-600 border-none" name="radio-direct" value="1">
            <span class="ml-2">Open</span>
         </label>
         </div>
         <div>
         <label class="inline-flex items-center">
            <input class="form-radio" wire:model="status" type="radio" checked="" class="bg-gray-200 text-purple border-none" name="radio-direct" value="2">
            <span class="ml-2">Considering</span>
         </label>
         </div>
         <div>
         <label class="inline-flex items-center">
            <input class="form-radio" wire:model="status" type="radio" checked="" class="bg-gray-200 text-yellow border-none" name="radio-direct" value="3">
            <span class="ml-2">In Progress</span>
         </label>
         </div>
         <div>
         <label class="inline-flex items-center">
            <input class="form-radio" wire:model="status" type="radio" checked="" class="bg-gray-200 text-green border-none" name="radio-direct" value="4">
            <span class="ml-2">Implement</span>
         </label>
         </div>
         <div>
         <label class="inline-flex items-center">
            <input class="form-radio" wire:model="status" type="radio" checked="" class="bg-gray-200 text-red border-none" name="radio-direct" value="5">
            <span class="ml-2">Closed</span>
         </label>
         </div>
      </div>
      <div>
         <textarea name="update_comment" id="update_comment" cols="30" rows="3"
            class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 border-none
            px-4 py-2" placeholder="Add an update comment (optional)"></textarea>
      </div>
      <div class="flex items-center justify-between space-x-10">
         <button type="button" 
               class="flex items-center justify-center w-1/2 h-11 text-xs font-semibold rounded-xl border 
               border-gray-200 hover:bg-gray-400 bg-gray-200 transition duration-150 ease-in px-6 py-3">
            <svg class="text-gray-600 w-4 transform -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
            </svg>   
            <span class="ml-1">Attach</span>
         </button>
         <button type="submit" class="flex items-center text-white justify-center w-1/2 h-11 text-xs font-semibold rounded-xl border 
         border-blue hover:bg-blue-hover bg-blue transition duration-150 ease-in px-6 py-3">
            <span class="ml-1">Update</span>
         </button>
   </div>

   <div>
      <label class="font-normal inline-flex items-center">
      <input class="form-checkbox" name="notify-voters" class="rounded bg-gray-200" type="checkbox" checked="">
      <span class="ml-2">Notify all voters</span>
      </label>
   </div>

   </form>
</div>
</div> {{-- END SET STATUS --}}