     <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="{{route('dashboard')}}" class="logo">
              <img
                src="{{asset('/')}}assets/img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">             
              <li class="nav-item active">
                <a href="{{route('dashboard')}}">
                  <i class="fas fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('user.index')}}">
                  <i class="fas fas fa-users"></i>
                  <p>User</p>
                </a>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#Additional">
                  <i class="fas fa-layer-group"></i>
                  <p>Additional Info</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="Additional">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{route('religion.index')}}">
                        <span class="sub-item">Religions</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('caste.index')}}">
                        <span class="sub-item">Castes</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('profiletype.index')}}">
                        <span class="sub-item">Profile Type</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('education.index')}}">
                        <span class="sub-item">Education</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('occupation.index')}}">
                        <span class="sub-item">Occupation</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('annualincome.index')}}">
                        <span class="sub-item">Annual Income</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('jobtype.index')}}">
                        <span class="sub-item">Job Type</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('companytype.index')}}">
                        <span class="sub-item">Company Type</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a href="{{route('notification.index')}}">
                  <i class="fas fas fa-users"></i>
                  <p>Notification</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link"
                  onclick="event.preventDefault(); confirmLogout();">
                    <i class="fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </li>

              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="{{route('dashboard')}}" class="logo">
                <img
                  src="{{asset('/')}}assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
                <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                      <i class="fa fa-search search-icon"></i>
                    </button>
                  </div>
                  <input
                    type="text"
                    placeholder="Search ..."
                    class="form-control"
                  />
                </div>
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="{{asset('/')}}assets/img/profile.jpg"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold">{{auth()->user()->name}}</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="{{asset('/')}}assets/img/profile.jpg"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                            <h4>{{auth()->user()->name}}</h4>
                            <p class="text-muted">{{auth()->user()->email}}</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); confirmLogout();">Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>