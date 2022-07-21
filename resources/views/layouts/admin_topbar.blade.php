<div class="right-side-top">
    <div class="brandFullName">
        <button class="bar-button"><i class="fa-solid fa-bars"></i></button>
        
        {{-- <img src="{{ url('/public/images/wbldcl-logo-v2.png')}}" alt="logo" width="100%"> --}}
    </div>

    <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            {{-- <span><?= Auth::user()->full_name.' '.Auth::user()->last_name;?></span> --}}
            
            <img src="{{ url('/public/images/user-image.png')}}" alt="user-image" style="width: 40px; height: 40px; border-radius: 100%;">
            <span><?= Auth::user()->full_name;?></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="#">Edit Profile</a></li>

            <li><a class="dropdown-item" href="{{ url('admin/change-password') }}">Change Password</a></li>
            
            <li><a class="dropdown-item" href="<?= url('/logout')?>">Logout</a></li>

            {{-- <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
        </ul>
    </div>
</div>