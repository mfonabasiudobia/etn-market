<section>


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

                            <img :src="imagePreview ? imagePreview : '{{ asset(auth()->user()->profile_image) }}'"
                                alt="Image Preview" class="rounded-full w-[300px] h-[300px]" />

                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                <i class="las la-edit text-white text-xl"></i>
                            </div>
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
                        <select wire:model.defer="blood_group" class="form-control">
                            <option>Select Blood Group</option>
                            @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('blood_group')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Genotype</label>
                        <select wire:model.defer="genotype" class="form-control">
                            <option>Select Genotype</option>
                            @foreach (['AA', 'AS', 'SS', 'AC', 'SC', 'Others'] as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>

                        @error('genotype')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Nationality</label>
                        <select wire:model="nationality" class="form-control">
                            <option>Select Nationality</option>
                            @foreach (\App\Models\Country::all() as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('nationality')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>
                    <div class="form-group">
                        <label>State of Origin <span class="text-danger">*</span></label>
                        <select wire:model="state_of_origin" class="form-control">
                            <option>Select State of origin</option>
                            @foreach ($states1 as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('state_of_origin')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>LGA of Origin <span class="text-danger">*</span></label>
                        <select wire:model.defer="lga" class="form-control">
                            <option>Select LGA of Origin</option>
                            @foreach ($lgas1 as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                        @error('lga')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>National Identity Number (NIN)</label>
                        <input type="text" class="form-control" placeholder="National Identity Number (NIN)"
                            wire:model.defer="national_identification_number" />
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
                            wire:model.defer="residential_address" />
                        @error('residential_address')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Country</label>
                        <select wire:model="residential_country" class="form-control">
                            <option>Select country</option>
                            @foreach (\App\Models\Country::all() as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                        @error('residential_country')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>State</label>
                        <select wire:model="residential_state" class="form-control">
                            <option>Select State</option>
                            @foreach ($states2 as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('residential_state')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>LGA/County</label>
                        <select wire:model="residential_lga" class="form-control">
                            <option>Select LGA/County</option>
                            @foreach ($lgas2 as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                        @error('residential_lga')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Postal/Zip Code</label>
                        <input type="text" class="form-control" placeholder="Enter your Postal/Zip Code"
                            wire:model.defer="residential_zipcode" />
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
                            wire:model.defer="emergency_name" />
                        @error('emergency_name')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Phone Number 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"
                            placeholder="Enter Kin's/Emergency Mobile Number 1"
                            wire:model.defer="emergency_mobile_number1" />
                        @error('emergency_mobile_number1')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>

                    <div class="form-group">
                        <label>Phone Number 2</label>
                        <input type="text" class="form-control"
                            placeholder="Enter Kin's/Emergency  Mobile Number 2"
                            wire:model.defer="emergency_mobile_number2" />
                        @error('emergency_mobile_number2')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>


                    <div class="form-group md:col-span-3">
                        <label>Address</label>
                        <input type="text" class="form-control" placeholder="Enter Kin's/Emergency Address"
                            wire:model.defer="emergency_address" />
                        @error('emergency_address')
                            <span class="error"> {{ $message }}</span>
                        @endError
                    </div>


                </section>
            </section>
        </section>


        <div class="form-group md:col-span-3 flex justify-end">
            <x-atoms.loading-button text="Next" target="submit" class="btn btn-lg btn-primary" />
        </div>
    </form>


</section>
</section>
