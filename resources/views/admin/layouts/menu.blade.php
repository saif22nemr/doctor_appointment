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
                  <!-- Users Start -->
                  <li  class="has-sub {{(isset($title) and $title[0] == 'user') ? 'active expand' : ''}}" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#user-list"
                      aria-expanded="false" aria-controls="user-list">
                      <i class="mdi mdi-account-group"></i>
                      <span class="nav-text">@lang('app.users')</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse {{(isset($title) and $title[0] == 'user') ? 'show' : ''}}"  id="user-list"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">
                        
                        @if($auth_user->group != 2 or isset($employeePermissions['admin'])  )
                            <li class="{{(isset($title) and $title[0] == 'user' and $title[1] == 'admin') ? 'active' : ''}}">
                              <a class="sidenav-item-link " href="{{route('admin.index')}}">
                                <span class="nav-text">@lang('app.employees')</span>
                                
                              </a>
                            </li>
                            @endif
                            @if($auth_user->group != 2 or isset($employeePermissions['patient'])  )
                              <li class="{{(isset($title) and $title[0] == 'user' and $title[1] == 'patient') ? 'active' : ''}}">
                                <a class="sidenav-item-link " href="{{route('patient.index')}}">
                                  <span class="nav-text">@lang('app.patients')</span>
                                </a>
                              </li>
                              @endif
                      </div>
                    </ul>
                  </li>
                  <!-- User End -->

                   <!-- Setting Start -->
                   <li  class="has-sub {{(isset($title) and $title[0] == 'setting') ? 'active expand' : ''}}" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#setting-list"
                      aria-expanded="false" aria-controls="setting-list">
                      <i class="mdi mdi-settings"></i>
                      <span class="nav-text">@lang('app.settings')</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse {{(isset($title) and $title[0] == 'setting') ? 'show' : ''}}"  id="setting-list"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">
                        
                            <li class="{{(isset($title) and $title[0] == 'setting' and $title[1] == 'setting') ? 'active' : ''}}">
                              <a class="sidenav-item-link " href="{{route('setting.index')}}">
                                <span class="nav-text">@lang('app.general_setting')</span>
                                
                              </a>
                            </li>
                          
                      </div>
                    </ul>
                  </li>
                  <!-- User End -->
                </ul>
              </div>

            </div>

            
          </div>
  
  
  
        </aside>