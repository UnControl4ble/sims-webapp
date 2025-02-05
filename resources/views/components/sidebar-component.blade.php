<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <div class="navbar-header">
            <h2>
                <i class="fa fa-bag-shopping"></i> SIMS Web App
            </h2>
            <a href="#" class="navbar-brand" id="sidebar-toggle">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>
    <ul class="sidebar-nav mt-4">
        <li class="{{ request()->is('product') ? 'active' : '' }}">
            <a href="{{ route('product.index') }}"><i class="fa fa-box"></i>Produk</a>
        </li>
        <li class="{{ request()->is('profile') ? 'active' : '' }}">
            <a href="{{ route('profile') }}"><i class="fa fa-user"></i>Profil</a>
        </li>
        <li>
            <a href="#"
                onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin logout?')) document.getElementById('logout-form').submit();">
                <i class="fa fa-right-from-bracket"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>

</aside>
