<section class="content-wrapper">
    <x-loading readonly disabled />

    <div class="shadow-xl rounded-xl relative overflow-hidden bg-white">
        <div class="min-h-[20vh] bg-purple-100 relative">
            <img src="{{ asset($user->profile_image) }}" alt=""
                class="shadow-xl absolute left-5 -bottom-10 ring ring-4 ring-white rounded-full h-[70px] md:h-[120px] w-[70px] md:w-[120px] object-cover"
                readonly disabled />
        </div>

        <section class="mt-10 p-5">
            <h2 class="font-bold">{{ $user->first_name }}</h2>
            <ul class="list-disc list-inside font-light text-sm flex flex-col md:flex-row md:items-center md:space-x-5">
                <li>{{ $user->username }}</li>
                <li>{{ $user->email }}</li>
            </ul>

            {{-- <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="absolute top-5 right-5 text-xl">
                <i class="las la-edit"></i>
            </a> --}}
        </section>
    </div>

    <section class="py-5">
        <h2>Transactions</h2>

        @livewire('admin.transaction.tables.home', ['user_id' => $user->id, 'status' => 'all'], key($key))
    </section>


    <form class="space-y-5" wire:submit.prevent='submit'>

        <section class="space-y-3">
            <h2 class="font-medium">Personal Details</h2>
            <section class="space-y-5 p-5 border rounded-lg">
                <section class="grid grid-cols-2 gap-5">
                    <section class="flex items-center justify-center p-5">

                        <label x-data="{ imagePreview: null }" class="d-block relative" for="profile-image">
                            <input type="file" id="profile-image" hidden wire:model.defer="profile_image"
                                id="image" accept="image/*"
                                x-on:change="imagePreview = URL.createObjectURL($event.target.files[0])">

                            <img :src="imagePreview ? imagePreview : '{{ asset($user->profile_image) }}'"
                                alt="Image Preview" class="rounded-full w-[300px] h-[300px]" />

                            {{-- <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                <i class="las la-edit text-white text-xl"></i>
                            </div> --}}
                        </label>


                    </section>

                    <section class="space-y-5">
                        <div class="form-flex-group ">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter your First Name"
                                wire:model.defer="first_name" />
                            @error('first_name')
                                <span class="error"> {{ $message }}</span>
                            @endError
                        </div>

                        <div class="form-flex-group ">
                            <label>Middle Name (Other Name):</label>
                            <input type="text" class="form-control" placeholder="Enter your Middle Name"
                                wire:model.defer="other_name" />
                            @error('other_name')
                                <span class="error"> {{ $message }}</span>
                            @endError
                        </div>

                        <div class="form-flex-group ">
                            <label>Surname <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter your Surname"
                                wire:model.defer="last_name" />
                            @error('last_name')
                                <span class="error"> {{ $message }}</span>
                            @endError
                        </div>

                        <div class="form-flex-group ">
                            <label>Mother's Maiden Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Mother's Maiden Name"
                                wire:model.defer="mother_maiden_name" />
                            @error('mother_maiden_name')
                                <span class="error"> {{ $message }}</span>
                            @endError
                        </div>

                        <div class="form-flex-group ">
                            <label>Mobile Number 1 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter your Mobile Number 1"
                                wire:model.defer="mobile_number1" />
                            @error('mobile_number1')
                                <span class="error"> {{ $message }}</span>
                            @endError
                        </div>

                        <div class="form-flex-group ">
                            <label>Mobile Number 2:</label>
                            <input type="text" class="form-control" placeholder="Enter your Mobile Number 2"
                                wire:model.defer="mobile_number2" />
                            @error('mobile_number2')
                                <span class="error"> {{ $message }}</span>
                            @endError
                        </div>
                    </section>

                </section>



                <section class="grid grid-cols-3 gap-5">
                    <div class="form-group">
                        <label>Blood Group</label>
                        <input type="text" class="form-control" placeholder="Blood Group"
                            wire:model.defer="blood_group" readonly disabled />
                        @error('blood_group')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Genotype</label>
                        <input type="text" class="form-control" placeholder="Genotype" wire:model.defer="genotype"
                            readonly disabled />
                        @error('genotype')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Nationality</label>
                        <input type="text" class="form-control" placeholder="Nationality"
                            wire:model.defer="nationality" readonly disabled />
                        @error('nationality')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>State of Origin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="State of Origin"
                            wire:model.defer="state_of_origin" readonly disabled />
                        @error('state_of_origin')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>LGA of Origin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="LGA of Origin" wire:model.defer="lga"
                            readonly disabled />
                        @error('lga')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>National Identity Number (NIN)</label>
                        <input type="text" class="form-control" placeholder="National Identity Number (NIN)"
                            wire:model.defer="national_identification_number" readonly disabled />
                        @error('national_identification_number')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>
                </section>
            </section>
        </section>


        <section class="space-y-3">
            <h2 class="font-medium">Residential Address Details</h2>
            <section class="space-y-5 p-5 border rounded-lg">
                <section class="grid grid-cols-4 gap-5">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" placeholder="Enter your Address"
                            wire:model.defer="residential_address" readonly disabled />
                        @error('residential_address')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" placeholder="Enter your country"
                            wire:model.defer="residential_country" readonly disabled />
                        @error('residential_country')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>State</label>
                        <input type="text" class="form-control" placeholder="Enter your State"
                            wire:model.defer="residential_state" readonly disabled />
                        @error('residential_state')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>LGA/County</label>
                        <input type="text" class="form-control" placeholder="Enter your LGA/County"
                            wire:model.defer="residential_lga" readonly disabled />
                        @error('residential_lga')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Postal/Zip Code</label>
                        <input type="text" class="form-control" placeholder="Enter your Postal/Zip Code"
                            wire:model.defer="residential_zipcode" readonly disabled />
                        @error('residential_zipcode')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                </section>
            </section>
        </section>



        <section class="space-y-3">
            <h2 class="font-medium">Next of Kin’s/ Emergency Contact Details</h2>
            <section class="space-y-5 p-5 border rounded-lg">
                <section class="grid grid-cols-3 gap-5">
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter Kin's/Emergency Name"
                            wire:model.defer="emergency_name" readonly disabled />
                        @error('emergency_name')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Phone Number 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"
                            placeholder="Enter Kin's/Emergency Mobile Number 1"
                            wire:model.defer="emergency_mobile_number1" readonly disabled />
                        @error('emergency_mobile_number1')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Phone Number 2 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"
                            placeholder="Enter Kin's/Emergency  Mobile Number 2"
                            wire:model.defer="emergency_mobile_number2" readonly disabled />
                        @error('emergency_mobile_number2')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>


                    <div class="form-group md:col-span-3">
                        <label>Address</label>
                        <input type="text" class="form-control" placeholder="Enter Kin's/Emergency Address"
                            wire:model.defer="emergency_address" readonly disabled />
                        @error('emergency_address')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>


                </section>
            </section>
        </section>


        {{-- <div class="form-group md:col-span-3 flex justify-end">
            <x-atoms.loading-button text="Next" target="submit" class="btn btn-lg btn-primary" readonly disabled />
        </div> --}}
    </form>

</section>
