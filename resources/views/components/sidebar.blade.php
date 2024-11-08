<aside id="sidebar">
    <div class="d-flex">
        <button class="toggle-btn" type="button">
            <i class="lni lni-grid-alt"></i>
        </button>
        <div class="sidebar-logo">
            <a href="#">Application</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#workspaces" aria-expanded="false" aria-controls="workspaces">
                <i class="lni lni lni-folder"></i>
                <span>Workspace</span>
            </a>
            <ul id="workspaces" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                @foreach($workspaces as $workspace)
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link" onclick="showContent('workspace{{ $workspace->id }}Content'); return false;">{{ $workspace->name }}</a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link" onclick="showContent('createContent'); return false;">
                <i class="lni lni-write"></i>
                <span>Create Workspace</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link" onclick="showContent('manageContent'); return false;">
                <i class="lni lni-notepad"></i>
                <span>Manage Workspace</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link" onclick="showContent('joinContent'); return false;">
                <i class="lni lni-paperclip"></i>
                <span>Join Workspace</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link" onclick="showContent('requestsContent'); return false;">
                <i class="lni lni-handshake"></i>
                <span>Requests</span>
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="submit" class="sidebar-link logout-button">
                <i class="lni lni-exit"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>