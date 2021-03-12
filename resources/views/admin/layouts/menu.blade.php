<aside class="left-sidebar bg-sidebar">
  
          <div id="sidebar" class="sidebar sidebar-with-footer">

            <!-- Aplication Brand -->
            <div class="app-brand">
              <a href="{{route('dashboard.index')}}" title="{{$lang == 'ar' ? $setting['site_title'] : $setting['site_title_en'] }}">
                <img src="{{asset('image/logo.png')}}" alt="icon" class="brand-icon" style="height:60px;width:50px">
                <span class="brand-name text-truncate">{{$lang == 'ar' ? $setting['site_title'] : $setting['site_title_en'] }}</span>
              </a>
            </div>
            <!-- begin sidebar scrollbar -->
            <div class="sidebar-scrollbar">
              <div class="layout-c">
              <!-- sidebar menu -->
              <ul class="nav sidebar-inner" id="sidebar-menu">
                
                  <li  class="{{(isset($title) and $title[0] == 'dashboard' ) ? 'active' : ''}}" >
                    <a class="sidenav-item-link" href="{{route('dashboard.index')}}" 
                      aria-expanded="false" aria-controls="dashboard">
                      <i class="mdi mdi-view-dashboard-outline"></i>
                      <span class="nav-text">@lang('app.dashboard')</span> 
                    </a>
                  </li>
                  
                </ul>
              </div>

            </div>

            
          </div>
  
  
  
        </aside>