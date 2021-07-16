
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

<title>{{  $setting['site_title']}} |  @lang('login.login')</title> 

  <!-- GOOGLE FONTS -->
  

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet" />
  <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />


  <!-- PLUGINS CSS STYLE -->
  <link href="{{asset('assets/plugins/nprogress/nprogress.css')}}" rel="stylesheet" />

  

  <!-- SLEEK CSS -->
  @if(true)
  <link id="sleek-css" rel="stylesheet" href="{{asset('assets/css/sleek.rtl.css')}}" />
@else
  <link id="sleek-css" rel="stylesheet" href="{{asset('assets/css/sleek.css')}}" />
@endif

  <!-- FAVICON -->
  <link href="{{asset('storage/'.$setting['site_icon'])}}" rel="shortcut icon" />

  <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
  @if(false)
    <link rel="stylesheet" type="text/css" href="{{asset('css/ltr.css')}}">
  @endif
  <link rel="stylesheet" type="text/css" href="{{asset('css/login.css')}}">

  <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
  -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="{{asset('assets/plugins/nprogress/nprogress.js')}}"></script>
</head>

</head>
  <body class="" id="body">
      <div class="container d-flex flex-column justify-content-between vh-100">
      <div class="row justify-content-center mt-5">
        <div class="col-xl-5 col-lg-6 col-md-10">
          <div class="card">
            <div class="card-header bg-primary">
              <div class="app-brand">
                <a href="{{route('dashboard.index')}}">
				<img class="brand-icon" src="{{asset('storage/'.get_setting('site_icon'))}}">
				<span class="brand-name">{{ $setting['site_title'] }}</span>
                </a>
              </div>
            </div>
            <div class="card-body p-5">

              <h4 class="text-dark mb-5">@lang('login.login')</h4>
			<form action="{{route('dashboard.login')}}" method="POST">
			    	@csrf
                <div class="row">
                  <div class="form-group col-md-12 mb-4">
				            <input type="text" class="form-control input-lg" id="username"  placeholder="@lang('app.entry_username')" name="username" value="{{old('username')}}">
                    @error('username')
                        <p class="error-message">{{$message}}</p>
                    @enderror
                            </div>
                            <div class="form-group col-md-12 ">
                    <input type="password" class="form-control input-lg" name="password"
                    id="password" placeholder="@lang('app.entry_password')">
                    @error('password')
                        <p class="error-message">{{$message}}</p>
                    @enderror
                  </div>
                  <div class="col-md-12">
                    <div class="d-flex my-2 justify-content-between">
                      {{-- <div class="d-inline-block mr-3">
                        <label class="control control-checkbox">Remember me
                          <input type="checkbox" />
                          <div class="control-indicator"></div>
                        </label>

                      </div> --}}
                   
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary btn-block mb-4">@lang('login.login')</button>
                    {{-- <p>Don't have an account yet ?
                      <a class="text-blue" href="sign-up.html">Sign Up</a>
                    </p> --}}
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="copyright pl-0">
        <p class="text-center">{{$lang == 'ar' ? $setting['site_footer'] : $setting['site_footer_en']}}
        </p>
      </div>
    </div>

</body>
</html>