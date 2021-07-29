<aside class="left-sidebar bg-sidebar">
  
          <div id="sidebar" class="sidebar sidebar-with-footer">

            <!-- Aplication Brand -->
            <div class="app-brand">
              <a href="{{route('dashboard.index')}}" title="{{$lang == 'ar' ? $setting['site_title'] : $setting['site_title_en'] }}">
                <img src="{{asset('storage/'.get_setting('site_icon'))}}" alt="icon" class="brand-icon" style="height:60px;width:50px">
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
                  {{-- Start Apppintment --}}
                  @if(has_permission('appointment' , 'view') )
                  <li  class="has-sub {{(isset($title) and $title[0] == 'appointment') ? 'active expand' : ''}}" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#appointment-list"
                      aria-expanded="false" aria-controls="appointment-list">
                      <i class="mdi mdi-doctor"></i>
                      <span class="nav-text">@lang('app.appointments')</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse {{(isset($title) and $title[0] == 'appointment') ? 'show' : ''}}"  id="appointment-list"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">
                        @if( has_permission('appointment' , 'create')  )
                            <li class="{{(isset($title) and $title[0] == 'appointment' and $title[1] == 'create') ? 'active' : ''}}">
                              <a class="sidenav-item-link " href="{{route('appointment.create')}}">
                                <span class="nav-text">@lang('appointment.create_appointment')</span>
                                
                              </a>
                            </li>
                            @endif

                        @if( has_permission('appointment' , 'view') or has_permission('appointment' , 'create') )
                            <li class="{{(isset($title) and $title[0] == 'appointment' and $title[1] == 'all') ? 'active' : ''}}">
                              <a class="sidenav-item-link " href="{{route('appointment.index')}}?status=all">
                                <span class="nav-text">@lang('appointment.all')</span>
                                
                              </a>
                            </li>
                            @endif
                            
                            @if(has_permission('appointment' , 'view') )
                              <li class="{{(isset($title) and $title[0] == 'appointment' and $title[1] == 'pending') ? 'active' : ''}}">
                                <a class="sidenav-item-link " href="{{route('appointment.index')}}?status=pending">
                                  <span class="nav-text">@lang('appointment.pending')</span>
                                </a>
                              </li>
                              @endif
                              @if(has_permission('appointment' , 'view') )
                              <li class="{{(isset($title) and $title[0] == 'appointment' and $title[1] == 'finished') ? 'active' : ''}}">
                                <a class="sidenav-item-link " href="{{route('appointment.index')}}?status=finished">
                                  <span class="nav-text">@lang('appointment.finished')</span>
                                </a>
                              </li>
                              @endif
                              @if(has_permission('appointment' , 'view') )
                              <li class="{{(isset($title) and $title[0] == 'appointment' and $title[1] == 'canceled') ? 'active' : ''}}">
                                <a class="sidenav-item-link " href="{{route('appointment.index')}}?status=canceled">
                                  <span class="nav-text">@lang('appointment.canceled')</span>
                                </a>
                              </li>
                              @endif
                              @if(has_permission('appointment' , 'view') )
                              <li class="{{(isset($title) and $title[0] == 'appointment' and $title[1] == 'appointment_request') ? 'active' : ''}}">
                                <a class="sidenav-item-link " href="{{route('appointment.index')}}?status=appointment_request">
                                  <span class="nav-text">@lang('appointment.appointment_request')</span>
                                </a>
                              </li>
                              @endif
                      </div>
                    </ul>
                  </li>
                  @endif
                  {{-- End Appointment --}}
                  
                  {{-- Patient --}}
                  @if(has_permission('patient' , 'view'))
                  <li  class="{{(isset($title) and $title[0] == 'patient' ) ? 'active' : ''}}" >
                    <a class="sidenav-item-link" href="{{route('patient.index')}}" 
                      aria-expanded="false" aria-controls="patient">
                      <i class="mdi mdi-medical-bag"></i>
                      <span class="nav-text">@lang('app.patient')</span> 
                    </a>
                  </li>
                  @endif

                  {{-- Employee --}}
                  @if(has_permission('employee' , 'view'))
                  <li  class="{{(isset($title) and $title[0] == 'employee' ) ? 'active' : ''}}" >
                    <a class="sidenav-item-link" href="{{route('employee.index')}}" 
                      aria-expanded="false" aria-controls="employee">
                      <i class="mdi mdi-account-star"></i>
                      <span class="nav-text">@lang('app.employee')</span> 
                    </a>
                  </li>
                  @endif
     

                  {{-- Branch --}}
                  @if(has_permission('employee' , 'view'))
                  <li  class="{{(isset($title) and $title[0] == 'branch' ) ? 'active' : ''}}" >
                    <a class="sidenav-item-link" href="{{route('branch.index')}}" 
                      aria-expanded="false" aria-controls="branch">
                      <i class="mdi mdi-source-branch"></i>
                      <span class="nav-text">@lang('app.branches')</span> 
                    </a>
                  </li>
                  @endif
                   <!-- Setting Start -->
                   @if(has_permission('setting' , 'view'))
                   <li  class="has-sub {{(isset($title) and $title[0] == 'setting') ? 'active expand' : ''}}" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#setting-list"
                      aria-expanded="false" aria-controls="setting-list">
                      <i class="mdi mdi-settings"></i>
                      <span class="nav-text">@lang('app.settings')</span> <b class="caret"></b>
                    </a>
                    
                    <ul  class="collapse {{(isset($title) and $title[0] == 'setting') ? 'show' : ''}}"  id="setting-list"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">
                        {{-- General --}}
                            <li class="{{(isset($title) and $title[0] == 'setting' and $title[1] == 'setting') ? 'active' : ''}}">
                              <a class="sidenav-item-link " href="{{route('setting.index')}}">
                                <span class="nav-text">@lang('app.general_setting')</span>
                              </a>
                            </li>
                            {{-- Appliaciton --}}
                            <li class="{{(isset($title) and $title[0] == 'setting' and $title[1] == 'application') ? 'active' : ''}}">
                              <a class="sidenav-item-link " href="{{route('setting.application.index')}}">
                                <span class="nav-text">@lang('app.application')</span>
                              </a>
                            </li>
                          
                      </div>
                    </ul>
                    
                  </li>
                  @endif
                  <!-- Setting End -->
                </ul>
              </div>

            </div>

            
          </div>
  
  
  
        </aside>