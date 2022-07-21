<div class="left-main-content width-fifteen">
    <div class="left-side">
        <div class="left-side-top">
            
            <div class="profileImage" >
                <div class="profileImage-img">
                    <img src="{{ url('/public/images/logo.png')}}" alt="wbldcl-logo-v2" width="100%">
                </div>
            </div>
        </div>
        <div class="left-side-menu">
            <div class="tab">
                <a href="{{ url('admin/dashboard')}}" style="text-decoration-line:none;"><button class="tablinks" onclick="" id="defaultOpen"><i
                        class="fa-solid fa-house"></i><span class="left-side-menu-name">Dashboard</span></button></a>
                
                <a href="{{ url('admin/user-management')}}" style="text-decoration-line:none;">
                    <button class="tablinks" id="defaultOpen">
                        <i class="fa-solid fa-user"></i><span class="left-side-menu-name">Admin User Management</span>
                    </button>
                </a>

                <a href="{{ url('admin/member-management')}}" style="text-decoration-line:none;">
                    <button class="tablinks" id="defaultOpen">
                        <i class="fa-solid fa-user"></i><span class="left-side-menu-name">User Management</span>
                    </button>
                </a>

                {{-- <a href="#" style="text-decoration-line:none;">
                    <button class="tablinks"><i class="fa-solid fa-inbox"></i><span class="left-side-menu-name">Inbox</span></button>
                </a> --}}

                

                
                <button class="tablinks fileManagementSystem"><i class="fa fa-cogs" aria-hidden="true"></i><span class="left-side-menu-name">Settings</span></button>
                <ul class="fileManagementSystemMenu">
                    <li>
                        <a href="{{ url('/admin/roles')}}" style="text-decoration-line:none;">
                            <button class="tablinks"><i class="fa-solid fa-file"></i><span class="left-side-menu-name">Roles</span></button>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/admin/tribe-list')}}" style="text-decoration-line:none;">
                            <button class="tablinks"><i class="fa-solid fa-file"></i><span class="left-side-menu-name">Tribe</span></button>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/admin/prayer')}}" style="text-decoration-line:none;">
                            <button class="tablinks"><i class="fa-solid fa-file"></i><span class="left-side-menu-name">Prayer</span></button>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/admin/events')}}" style="text-decoration-line:none;">
                            <button class="tablinks"><i class="fa-solid fa-file"></i><span class="left-side-menu-name">Events</span></button>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ url('admin/new-file-upload')}}" style="text-decoration-line:none;">
                            <button class="tablinks"><i class="fa-solid fa-folder-plus"></i><span class="left-side-menu-name">Create New File</span></button>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/forward-files')}}" style="text-decoration-line:none;">
                            <button class="tablinks"><i class="fa-solid fa-forward"></i><span class="left-side-menu-name">Forword Files</span></button>
                        </a>
                    </li>
                </ul>

                
                        
                
                

                

                

               

                {{-- <a href="{{ url('/admin/workflow-configuration')}}" style="text-decoration-line:none;">
                    <button class="tablinks">
                        <i class="fa-solid fa-id-badge"></i><span class="left-side-menu-name">WorkFlow Configuration</span>
                    </button>
                </a> --}}

                

                {{-- <a href="{{ url('/admin/file-upload')}}" style="text-decoration-line:none;">
                    <button class="tablinks">
                        <i class="fa-solid fa-file"></i><span class="left-side-menu-name">a</span>
                    </button>
                </a> --}}

                {{-- <button class="tablinks"><i class="fa-solid fa-key"></i><span class="left-side-menu-name">Change Password</span></button> --}}
              
            </div>
        </div>
    </div>
</div>