 <div 
class="modal-wrapper" 
x-data="{ status : false, currentTab : 0 }"
@trigger-file-modal.window="status = !status;"
@trigger-close-modal.window="status = false"
x-show="status" 
x-transition
x-cloak
>  
<x-loading />
    <section class="modal-inner-wrapper p-7">
          <section 
            class="modal-body rounded-lg shadow w-full  px-5 space-y-3 bg-white" 
            @click.outside="status = false"
            >
             
             <header class="flex justify-between items-center p-2 md:p-5 bg-gray-100">
               <div>
                    <button type="button" x-on:click="currentTab = 0" :class="currentTab === 0 ? 'bg-white' : ''" class="px-5 py-3">
                       Select File 
                    </button>
                    <button type="button" x-on:click="currentTab = 1" :class="currentTab === 1 ? 'bg-white' : ''" class="px-5 py-3" >
                       Upload New
                    </button>
               </div>
                <button x-on:click.prevent="status = !status">
                   <i class="las la-times"></i>
                </button>
            </header>
            <div class="py-2 md:p-6 h-[70vh] overflow-y-auto">
                

                <section x-show="currentTab === 0" class="space-y-3">
               
                    <x-filter :showItems="['sortByLatest','sortByDate']" />

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">

                    @if($show)
                        @foreach ($files as $file)

                            <button 
                                :class="images.some(e => e.id == {{$file->id}}) ? 'border-brown-100' : ''"
                                class="block p-2 border cursor-pointer overflow-hidden" 
                                x-on:click.prevent="() => {
                                    status = !status;

                                    $dispatch('set-push-file', { id : '{{$file->id}}', path: '{{$file->file_path}}', unique_key : '{{ $uniqueid }}' });
                                }">
                              <img src="{{asset($file->file_path)}}" class="h-28 w-full object-cover">
                            </button>

                        @endforeach
                    @endIf
                    </div>

                    {{-- @if($files->count() == 0)
                        <x-empty-list />
                    @endIf --}}
                    
                </section>


                {{-- File Upload Section --}}
                <form  
                    class="md:p-5 space-y-3" 
                    wire:submit.prevent="uploadImage" 
                    x-show="currentTab === 1">

                    <div 
                    class="border border-dashed min-h-[40vh] bg-gray-50 border-gray-200 outline-gray-200 rounded-lg overflow-hidden outline-1  p-2 outline-dashed outline-offset-4 flex items-center justify-center relative">
                                   @if($image)
                                      <img src="{{$image->temporaryUrl()}}" class="max-h-[40vh] object-cover">
                                    @else
                                        <h3 class="text-xl text-center">Drop files here, paste or <a href="#" class="text-brown-100">Browse</a></h3>
                                        <input type="file" class="absolute top-0 left-0  block w-full h-full pt-[50vh] cursor-pointer" wire:model.debounce="image" >
                                    @endIf

                                    @error('image') <span class="text-red-500">{{$message}}</span> @endError
                    </div>
                 
                    <div class="flex justify-end space-x-2">

                            @if($image)

                             <button class="text-white bg-red-500 hover:bg-red-600 rounded-lg px-5 py-2.5 text-center" type="button" wire:click="removeFile">
                                Cancel  <i class="las la-times"></i>
                             </button>

                            @endIf

                            <button type="save" class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg px-5 py-2.5 text-center">
                             Upload <i class="las la-cloud-upload-alt"></i>
                            </button>
                    </div>
                  

                </form>


            </div>
           
            <footer class="flex flex-col space-y-3 md:flex-row md:items-center justify-between p-6  border-t  text-sm ">

                <div>
                    <div  x-show="currentTab === 0">
                        {{$files->links()}}
                    </div>
                </div>

                <div class="flex justify-end space-x-2 ">

                    {{-- <button  
                    x-show="images.length > 0"
                    class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg px-5 py-2.5 text-center">
                            Upload
                    </button> --}}

                    <button 
                        type="button" 
                        class="text-gray-500 bg-white hover:bg-gray-100 rounded-lg border font-medium px-5 py-2.5" 
                        x-on:click="status = !status">
                        Cancel
                   </button>
                </div>
            </footer>

          </section>

    </section>

    
</div>