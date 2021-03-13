<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale())}}" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!--  Social tags      -->
  <meta name="keywords" content="{{$setting['meta_keywords'] }},@yield('title')">
  <meta name="description" content="{{ $setting['meta_description']}}">
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="{{$setting['meta_name'] }}">
  <meta itemprop="description" content="{{ $setting['meta_description']}}">
<meta itemprop="image" content="{{$setting['meta_image']}}">
  <meta name="csrf-token" content="{{ csrf_token() }}"> 

<title>{{  $setting['site_title']}} | @yield('title')</title> 

  <!-- GOOGLE FONTS -->
  

  <link rel="stylesheet" href="{{asset('editor/trumbowyg/dist/ui/trumbowyg.min.css')}}">

  <!-- PLUGINS CSS STYLE -->
  <link href="{{asset('assets/plugins/nprogress/nprogress.css')}}" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
  <!-- Flatpicker for date time -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> -->
  
  <!-- No Extra plugin used -->
  
  {{-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet" /> --}}
  <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

  
  <link href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css')}}" rel="stylesheet" />
  
  
  
  <link href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
  
  
  
  <link href="{{asset('assets/plugins/toastr/toastr.min.css')}}" rel="stylesheet" />

  <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
  
  

  <!-- SLEEK CSS -->
  @if('rtl' == 'rtl')
  <link id="sleek-css" rel="stylesheet" href="{{asset('assets/css/sleek.rtl.css')}}" />
@else
  <link id="sleek-css" rel="stylesheet" href="{{asset('assets/css/sleek.css')}}" />
@endif
  

  <!-- FAVICON -->
  <link href="{{asset('storage/'.$setting['site_icon'])}}" rel="shortcut icon" />
  <link href="{{asset('assets/plugins/data-tables/datatables.bootstrap4.min.css')}}" rel="stylesheet">


  <link href="{{asset('assets/plugins/data-tables/responsive.datatables.min.css')}}" rel="stylesheet">

  <!-- Custom Style -->
  
  <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('css/new_style.css')}}">
  @if('rtl' == 'ltr')
    <link rel="stylesheet" type="text/css" href="{{asset('css/ltr.css')}}">
  @else 
  <link rel="stylesheet" type="text/css" href="{{asset('css/rtl.css')}}">
  @endif
  
  

  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js')}}"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>
  <![endif]-->
  <script src="{{asset('assets/plugins/nprogress/nprogress.js')}}"></script>


</head>


<body class="header-fixed sidebar-fixed sidebar-dark header-light" id="body">
  
  <script>
    NProgress.configure({ showSpinner: false });
    NProgress.start();
  </script>

  
  <!-- <div id="toaster"></div> -->
  

  <div class="wrapper">
    
    

            <!--
          ====================================
          ——— LEFT SIDEBAR WITH FOOTER
          =====================================
        -->
        @if(isset($noMenu))
          @extends('admin/layouts/menu')
        @endif


    <div class="page-wrapper">
                <!-- Header -->
          <header class="main-header " id="header">
            <nav class="navbar navbar-static-top navbar-expand-lg">
              <!-- Sidebar toggle button -->
              <button id="sidebar-toggler" class="sidebar-toggle">
                <span class="sr-only">Toggle navigation</span>
              </button>
              <!-- search form -->
              <div class="search-form d-none d-lg-inline-block">
                <div class="input-group">
                  <button type="button" name="search" id="search-btn" class="btn btn-flat">
                    <i class="mdi mdi-magnify"></i>
                  </button>
                  <input type="text" name="query" id="search-input" class="form-control" placeholder="search .."
                    autofocus autocomplete="off" />
                </div>
                <div id="search-results-container">
                  <ul id="search-results"></ul>
                </div>
              </div>

              <div class="navbar-right ">
                <ul class="nav navbar-nav">
                  <li class="dropdown notifications-menu">
                    <button class="dropdown-toggle" data-toggle="dropdown">
                      <i class="mdi mdi-bell-outline"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      {{-- <li class="dropdown-header">@lang('app.header_notification' , ['count' => count($activities)])</li>
                      @foreach($activities as $activity)
                      @if(strlen($lang == 'en' ? $activity->description_en : $activity->description) > 0)
                        <li>
                          
                          <a href="{{$activity->link}}">
                            
                          <div>
                            <span class=" font-size-12 d-inline-block float-right "><i class="mdi mdi-clock-outline"></i> {{$activity->humen_date}}</span>
                            <span class=" font-size-12 d-inline-block float-left text-primary"> {{$activity->user->name}}</span>
                          </div>
                            <div >
                              {{$lang == 'en' ? $activity->description_en : $activity->description}}
                            </div>
                          </a>
                          
                        </li>
                        @endif
                      @endforeach
                       --}}
                    
                      <li class="dropdown-footer">
                        <a class="text-center" href="#"> </a>
                      </li>
                    </ul>
                  </li>
                  <li class="right-sidebar-in right-sidebar-2-menu">
                    <i class="mdi mdi-settings mdi-spin"></i>
                  </li>
                  <!-- User Account -->
                  <li class="dropdown user-menu">
                    <button href="{{route('dashboard.index')}}" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    
                      <img src="{{$auth_user->image != null ? asset('storage/'.$auth_user->image) : asset('image/default_image.png')}}" class="user-image" alt="User Image" />
                      <span class="d-none d-lg-inline-block">{{$auth_user->name}}</span>
                    
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <!-- User image -->
                      <li class="dropdown-header">
                      <a href="#">
                        <img src="{{asset('image/default_image.png')}}" class="img-circle" alt="User Image" />
                        <div class="d-inline-block">
                          {{$auth_user->name}}<small class="pt-1">{{$auth_user->email}}</small>
                        </div>
                        </a>
                      </li>

                      <li>
                        <a href="{{route('dashboard.index')}}">
                          <i class="mdi mdi-account"></i> @lang('app.admins')
                        </a>
                      </li>
                      <!-- <li>
                        <a href="#">
                          <i class="mdi mdi-email"></i> Message
                        </a>
                      </li>
                      <li>
                        <a href="#"> <i class="mdi mdi-diamond-stone"></i> Projects </a>
                      </li> -->
                      <li class="">
                        <a href="{{route('dashboard.index')}}"> <i class="mdi mdi-settings"></i> @lang('app.settings') </a>
                      </li>

                      <li class="dropdown-footer">
                        <a href="{{route('dashboard.logout')}}"> <i class="mdi mdi-logout"></i> @lang('app.logout') </a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>


          </header>


      <div class="content-wrapper">
        <div class="content">						 
          @yield('content')
        </div>

        <footer class="footer mt-auto">
            <div class="copyright bg-white">
              <p>
                {{$lang == 'en' ? $setting['site_footer_en'] : $setting['site_footer'] ?? 'footer'}}
              </p>
            </div>
            <script>
                var d = new Date();
                var year = d.getFullYear();
                document.getElementById("copy-year").innerHTML = year;
            </script>
          </footer>

<div class="right-sidebar-2">
    <div class="right-sidebar-container-2">
      <div class="slim-scroll-right-sidebar-2">

      <div class="right-sidebar-2-header">
        <h2>@lang('app.layout_setting')</h2>
        <p>@lang('app.user_interface')</p>
        <div class="btn-close-right-sidebar-2">
          <i class="mdi mdi-window-close"></i>
        </div>
      </div>

      <div class="right-sidebar-2-body">
        <span class="right-sidebar-2-subtitle">@lang('app.header_layout')</span>
        <div class="no-col-space">
          <a href="javascript:void(0);" class="btn-right-sidebar-2 header-fixed-to btn-right-sidebar-2-active">@lang('app.fixed')</a>
          <a href="javascript:void(0);" class="btn-right-sidebar-2 header-static-to">@lang('app.static')</a>
        </div>

        <span class="right-sidebar-2-subtitle">@lang('app.sidebar_layout')</span>
        <div class="no-col-space">
          <select class="right-sidebar-2-select" id="sidebar-option-select">
            <option value="sidebar-fixed">Fixed Default</option>
            <option value="sidebar-fixed-minified">Fixed Minified</option>
            <option value="sidebar-fixed-offcanvas">Fixed Offcanvas</option>
            <option value="sidebar-static">Static Default</option>
            <option value="sidebar-static-minified">Static Minified</option>
            <option value="sidebar-static-offcanvas">Static Offcanvas</option>
          </select>
        </div>

        <span class="right-sidebar-2-subtitle">@lang('app.header_background')</span>
        <div class="no-col-space">
          <a href="javascript:void(0);" class="btn-right-sidebar-2 btn-right-sidebar-2-active header-light-to">@lang('app.light')</a>
          <a href="javascript:void(0);" class="btn-right-sidebar-2 header-dark-to">@lang('app.dark')</a>
        </div>

        <span class="right-sidebar-2-subtitle">@lang('app.notfication_background')</span>
        <div class="no-col-space">
          <a href="javascript:void(0);" class="btn-right-sidebar-2 btn-right-sidebar-2-active sidebar-dark-to">@lang('app.dark')</a>
          <a href="javascript:void(0);" class="btn-right-sidebar-2 sidebar-light-to">@lang('app.light')</a>
        </div>
        {{-- <span class="right-sidebar-2-subtitle">@lang('app.languages')</span>
        <div class="no-col-space">
          <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="btn-right-sidebar-2 btn-right-sidebar-2{{app()->getLocale() == 'ar' ? '' : '-active'}} ">@lang('app.english')</a>
          <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}" class="btn-right-sidebar-2 {{app()->getLocale() == 'en' ? '' : 'btn-right-sidebar-2-active'}}">@lang('app.arabic')</a>
        </div> --}}

        
      </div>

    </div>
  </div>

</div>

      </div>

          

    </div>
    
  </div>

  <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/plugins/slimscrollbar/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('assets/plugins/jekyll-search.min.js')}}"></script>



<script src="{{asset('assets/plugins/charts/Chart.min.js')}}"></script>
  

<script src="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js')}}"></script>
<script src="{{asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill.js')}}"></script>
  


<script src="{{asset('assets/plugins/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script>
  jQuery(document).ready(function() {
    jQuery('input[name="dateRange"]').daterangepicker({
    autoUpdateInput: false,
    singleDatePicker: true,
    locale: {
      cancelLabel: 'Clear'
    }
  });
    jQuery('input[name="dateRange"]').on('apply.daterangepicker', function (ev, picker) {
      jQuery(this).val(picker.startDate.format('MM/DD/YYYY'));
    });
    jQuery('input[name="dateRange"]').on('cancel.daterangepicker', function (ev, picker) {
      jQuery(this).val('');
    });
  });
</script>
  


<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>

<script type="text/javascript" src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

<script src="{{asset('editor/trumbowyg/dist/trumbowyg.min.js')}}"></script>
<script type="text/javascript" src="{{asset('editor/trumbowyg/dist/langs/ar.min.js')}}"></script>
<script type="text/javascript" src="{{asset('editor/trumbowyg/dist/plugins/allowtagsfrompaste/trumbowyg.allowtagsfrompaste.min.js')}}"></script>
<script src="{{asset('assets/js/sleek.bundle.js')}}"></script>
<script type="text/javascript">
  toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: "{{$lang == 'ar' ? 'toast-top-left' : 'toast-top-right'}}",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "10000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "slideDown",
    hideMethod: "slideUp"
};
var datatableLanguage = {
	    	"lengthMenu": "@lang('app.show') _MENU_",
            "zeroRecords": "@lang('app.no_result')",
            "info": "@lang('app.show') @lang('app.page') _PAGE_ @lang('app.of') _PAGES_",
            "infoEmpty": "@lang('app.no_result')",
            "infoFiltered": "(@lang('app.search') @lang('app.from') _MAX_ @lang('app.total_record'))",
            'search'	: '@lang("app.search")',
			"paginate": {
				"next": "@lang('pagination.next')",
        'previous' : "@lang('pagination.previous')"
				},
	    };
  var header = {'Accept' : 'application/json','Authorization' : 'Bearer {{session("auth")["access_token"] ?? ''}}' ,
    };
  var lang = "";
  function handlingAjaxError(xhr){
        var errorJson = xhr.responseJSON;
                var message = '';
                if(typeof errorJson == 'object' && typeof errorJson.success != 'undefined'){
                    if(typeof errorJson.error == 'object'){
                        message += '<ul>';
                            $.each(errorJson.error , function(index, value){
                                if(typeof value == 'object'){
                                    $.each(value , function(k , v){
                                        message += '<li>'+v+'</li>';
                                    });
                                }else{
                                    message += '<li>'+value+'</li>';
                                }
                            });
                        message += '</ul>';
                    }else{
                        message += '<li>'+errorJson.error+'</li>';
                    }
                    toastr.warning(message , "@lang('app.error')");
                }
                else if(typeof errorJson == 'object' && typeof errorJson.errors != 'undefined'){
                  message += '<ul>';
                            $.each(errorJson.errors , function(index, value){
                                if(typeof value == 'object'){
                                    $.each(value , function(k , v){
                                        message += '<li>'+v+'</li>';
                                    });
                                }else{
                                    message += '<li>'+value+'</li>';
                                }
                            });
                        message += '</ul>';
                        toastr.warning(message , "@lang('app.error')");
                  
                }
                else if(xhr.status == 404){
                  toastr.warning('@lang("app.error_not_found")' , "@lang('app.error')"); 
                }
                else{
                    toastr.error("@lang('app.error_general')" , "@lang('app.error')");
                }
    }
    function getFormData(inputclasses = '.form-submit .form-control'){
      var inputs = $(inputclasses);
      var data = {} ;
      $.each(inputs , function(index , value){
        var input = $(this);
        if(input.prop('type') == 'checkbox'){
          if(input.prop('checked') == true)
            data[input.prop('name')] = 1;
          else
            data[input.prop('name')] = 0;
        }

        else if(input.prop('type') != 'checkbox' && input.prop('value').length > 0 && input.prop('name').length > 0){
          data[input.prop('name')] = input.val();
        }
        // input.prop('name');
      });

      return data;
    }
    function handlingAjaxSuccess(json){
      if(typeof json.success != 'undefined' && json.success){
        toastr.success(json.message, "@lang('app.success')");
      }else if(!json.success){
        toastr.info(json.message, "@lang('app.error')");
      }
      return true;
    }
    function deleteItem(url , id , urlBack = ''){
      url = url + '/'+id;
        $.ajax({
            url: url,
            method: 'post' ,
            headers: header,
            data : {'_method': 'DELETE'},
            success: function(json){
              console.log(json);
                if(typeof json.success != 'undefined' && json.success){
                    toastr.success(json.message , "@lang('app.success')");
                    $('.card-body #'+id).parent().parent().fadeOut(500);
                    if(urlBack != ''){
                      window.location.replace(urlBack);
                    }

                }else{
                    var message = (typeof json.message != 'undefined') ? json.message : "@lang('app.error_data')";
                    toastr.warning(json.message , "@lang('app.error')");
                }
            },
            error: function(xhr){
                console.log(xhr);
                handlingAjaxError(xhr);
            }
        });
        return true;
    }
    $(function(){
      // $(".selector").flatpickr();
      $('.trumbowyg-en').trumbowyg({
        semantic: false,
         plugins: {
            allowTagsFromPaste: {
                allowedTags: ['h4', 'p', 'br' , 'div' , 'span' , 'button' , 'a' ,'h1' , 'body'],
                  removableTags:[]
            },
            removeformatPasted :false
        },        
      
      });
      $('.trumbowyg-ar').trumbowyg({
        'lang' : 'ar',
        semantic: false,
        plugins: {
            allowTagsFromPaste: {
                allowedTags:  ['h4', 'p', 'br' , 'div' , 'span' , 'button' , 'a' ,'h1' , 'body'],
                  removableTags:[]
            }
        },
      });
      $.ajax({
        url: '{{url("api/".$lang."/search")}}',
        method: 'get',
        headers: header,
        success: function(json){
          console.log(json);
           SimpleJekyllSearch.init({
            searchInput: document.getElementById('search-input'),
            resultsContainer: document.getElementById('search-results'),
            dataSource: json,
            searchResultTemplate: '<li><div class="link"><a href="{link}">{label}</a></div><div class="location">{location}</div><\/li>',
            noResultsText: '<li>No results found</li>',
            limit: 10,
            fuzzy: true,
          });
        },
        error: function(xhr){
          console.log(xhr);
        }
      });

      $('form#form-submit').submit(function(){
        return false;
      });
    });
    function generatePassword(length = 8) {
    
    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
    retVal = "";
for (var i = 0, n = charset.length; i < length; ++i) {
    retVal += charset.charAt(Math.floor(Math.random() * n));
}
return retVal;
}
function randomString(length  = 8){
		var password = generatePassword();
		console.log(password);
		$('input[name=password]').prop('value' , password);
	}
</script>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>

@yield('js')
</body>

</html>
