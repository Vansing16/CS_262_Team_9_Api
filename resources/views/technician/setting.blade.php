@extends('technician.layout.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <style>
        .profile-image-1 {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        #imageInput {
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Technician Profile</h1>
        </div>

        <div class="p-4">
            <form class="user" method="POST" action="{{ route('technician.update-settings') }}" enctype="multipart/form-data">
                @csrf
                <div class="text-center">
                    <img src="{{ asset('storage/' . $technician->profile_image) }}" id="profileImage" class="profile-image-1" alt="Profile Picture">
                    <input type="file" class="form-control col-3 mx-auto" id="imageInput" name="profile_picture" accept="image/*" onchange="loadImage(event)">
                    @error('profile_picture')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <small class="text-muted">Name</small>
                    <input type="text" class="mb-2 form-control" id="name" name="name" placeholder="Sothea" value="{{ old('name', $technician->name) }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <small class="text-muted">Email</small>
                    <input type="email" class="mb-2 form-control" id="email" name="email" placeholder="example@example.com" value="{{ old('email', $technician->email) }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <small class="text-muted">New Password</small>
                    <input type="password" class="mb-2 form-control" id="newPassword" name="newPassword" placeholder="Enter a new password">
                    @error('newPassword')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <small class="text-muted">Confirm New Password</small>
                    <input type="password" class="mb-2 form-control" id="confirmNewPassword" name="newPassword_confirmation" placeholder="Confirm the new password">
                    @error('newPassword_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>                            
                <div class="form-group row">
                    <div class="col-md-6">
                        <small class="text-muted">Phone Number</small>
                        <input type="text" class="form-control form-control-sm" name="phone" id="phone" value="{{ old('phone', $technician->phone) }}">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @php
                        $nationalities = [
                            'afghan', 'albanian', 'algerian', 'american', 'andorran',
                            'angolan', 'antiguans', 'argentinean', 'armenian', 'australian',
                            'austrian', 'azerbaijani', 'bahamian', 'bahraini', 'bangladeshi',
                            'barbadian', 'barbudans', 'batswana', 'belarusian', 'belgian',
                            'belizean', 'beninese', 'bhutanese', 'bolivian', 'bosnian',
                            'brazilian', 'british', 'bruneian', 'bulgarian', 'burkinabe',
                            'burmese', 'burundian', 'cambodian', 'cameroonian', 'canadian',
                            'cape verdean', 'central african', 'chadian', 'chilean', 'chinese',
                            'colombian', 'comoran', 'congolese', 'costa rican', 'croatian',
                            'cuban', 'cypriot', 'czech', 'danish', 'djibouti', 'dominican',
                            'dutch', 'east timorese', 'ecuadorian', 'egyptian', 'emirian',
                            'equatorial guinean', 'eritrean', 'estonian', 'ethiopian', 'fijian',
                            'filipino', 'finnish', 'french', 'gabonese', 'gambian', 'georgian',
                            'german', 'ghanaian', 'greek', 'grenadian', 'guatemalan', 'guinea-bissauan',
                            'guinean', 'guyanese', 'haitian', 'herzegovinian', 'honduran', 'hungarian',
                            'icelander', 'indian', 'indonesian', 'iranian', 'iraqi', 'irish', 'israeli',
                            'italian', 'ivorian', 'jamaican', 'japanese', 'jordanian', 'kazakhstani',
                            'kenyan', 'kittian and nevisian', 'kuwaiti', 'kyrgyz', 'laotian', 'latvian',
                            'lebanese', 'liberian', 'libyan', 'liechtensteiner', 'lithuanian', 'luxembourger',
                            'macedonian', 'malagasy', 'malawian', 'malaysian', 'maldivan', 'malian', 'maltese',
                            'marshallese', 'mauritanian', 'mauritian', 'mexican', 'micronesian', 'moldovan',
                            'monacan', 'mongolian', 'moroccan', 'mosotho', 'motswana', 'mozambican', 'namibian',
                            'nauruan', 'nepalese', 'new zealander', 'ni-vanuatu', 'nicaraguan', 'nigerien',
                            'north korean', 'northern irish', 'norwegian', 'omani', 'pakistani', 'palauan',
                            'panamanian', 'papua new guinean', 'paraguayan', 'peruvian', 'polish', 'portuguese',
                            'qatari', 'romanian', 'russian', 'rwandan', 'saint lucian', 'salvadoran', 'samoan',
                            'san marinese', 'sao tomean', 'saudi', 'scottish', 'senegalese', 'serbian', 'seychellois',
                            'sierra leonean', 'singaporean', 'slovakian', 'slovenian', 'solomon islander', 'somali',
                            'south african', 'south korean', 'spanish', 'sri lankan', 'sudanese', 'surinamer', 'swazi',
                            'swedish', 'swiss', 'syrian', 'taiwanese', 'tajik', 'tanzanian', 'thai', 'togolese', 'tongan',
                            'trinidadian or tobagonian', 'tunisian', 'turkish', 'tuvaluan', 'ugandan', 'ukrainian', 'uruguayan',
                            'uzbekistani', 'venezuelan', 'vietnamese', 'welsh', 'yemenite', 'zambian', 'zimbabwean'
                        ];
                    @endphp
                    <div class="mt-3 form-group">
                        <small class="text-muted">Nationality</small>
                        <select id="nationality" name="nationality" class="form-control">
                            <option value="">Select Nationality</option>
                            @foreach($nationalities as $nationality)
                                <option value="{{ $nationality }}" {{ (old('nationality', $technician->nationality) == $nationality) ? 'selected' : '' }}>{{ ucfirst($nationality) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn save-btn" style="background-color: black; color: white">Save</button>
            </form>
            <br>
            <a href="{{ route('technician.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/profile.js') }}"></script>
    <script src="{{ asset('js/password.js') }}"></script>
    <script>
        // Function to load selected image into profile picture preview
        function loadImage(event) {
            var output = document.getElementById('profileImage');
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
