<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt blue"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/quickupdates" class="nav-link">
          <i class="nav-icon fas fa-edit orange"></i>
          <p>
            Quick Update
          </p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/practices" class="nav-link">
          <i class="nav-icon fas fa-list orange"></i>
          <p>
            Practice Management
          </p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/providers" class="nav-link">
          <i class="nav-icon fas fa-medkit orange"></i>
          <p>
            Provider Management
          </p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/documents" class="nav-link">
          <i class="nav-icon fas fa-file orange"></i>
          <p>
            Documents
          </p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/payers" class="nav-link">
          <i class="nav-icon fas fa-clipboard orange"></i>
          <p>
            Payer Management
          </p>
        </router-link>
      </li>
      <li class="nav-item">
          <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list orange"></i>
              <p>
                  Reports
                  <i class="fas fa-angle-left right"></i>
              </p>
          </a>
          <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
              <router-link to="/report/appstatus" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>App Status Report</p>
              </router-link>
              </li>
              <li class="nav-item">
                  <router-link to="/report/productivity" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Activity Report</p>
                  </router-link>
              </li>
              <li class="nav-item">
<!--                  <a href="https://providerscredentialing.com/quickupdate" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Quick Update</p>
                  </a>-->
                  <router-link to="/report/export" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Export Status Report</p>
                  </router-link>
              </li>
          </ul>
      </li>
<!--      <li class="nav-item">
        <router-link to="#" class="nav-link">
          <i class="nav-icon fas fa-clipboard orange"></i>
          <p>
            Audit Log
          </p>
        </router-link>
      </li>-->
      <li class="nav-item">
        <router-link to="/activity" class="nav-link">
          <i class="nav-icon fas fa-clipboard orange"></i>
          <p>
            Log Activity
          </p>
        </router-link>
      </li>

      @can('isAdmin')
        <li class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-users nav-icon blue"></i>
            <p>Users</p>
          </router-link>
        </li>
      @endcan

      

      @can('isAdmin')
<!--      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/product/category" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Category
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/tag" class="nav-link">
              <i class="nav-icon fas fa-tags green"></i>
              <p>
                Tags
              </p>
            </router-link>
          </li>
          
            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                  <i class="nav-icon fas fa-cogs white"></i>
                  <p>
                      Developer
                  </p>
              </router-link>
            </li>
        </ul>
      </li>-->

      @endcan
      
      

      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>