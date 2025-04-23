<!DOCTYPE html>
<html lang="en">
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Google Font "Open Sans" -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
      rel="stylesheet"/>
<style>
.nav-user {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-left: 15px;
}

.username {
    font-size: 16px;
    font-weight: bold;
    color: white;
    margin-bottom: 5px; /* Space between username and logout */
}

.logout {
    cursor: pointer;
}
    .rtl {
            direction: rtl;
            text-align: right;
            
        }

        /* LTR layout */
        .ltr {
            direction: ltr;
            text-align: left;
            
        }
     .lang-button {
            padding: 10px;
            margin: 5px;
            cursor: pointer;
            background-color: #023b6d;
            color: white;
            border: none;
            border-radius: 5px;
        }

       
</style>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('css/styleRTL.css') }}" />
        
    @endif
   
    <title>@yield('title', 'Your Website Title')</title>
    <!-- Add additional styles or scripts if needed -->
    @yield('head')
  </head>

  <body >
    <!-- Navbar -->
    <nav class="navbar {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }} default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo text-light" href="#">
            <img src="{{ asset('images/logo.png') }}" height="50" width="50" alt="logo" />
            Container WebApp
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center">
        
        <!-- Language Toggle -->
        <form id="language-form" action="{{ url()->current() }}" method="GET" style="display: inline;">
            @csrf
            <button type="button" id="language-toggle" class="lang-button" onclick="toggleLanguage()">
                {{ app()->getLocale() == 'en' ? 'AR' : 'EN' }}
            </button>
        </form>

        <!-- User Info Section -->
        <div class="nav-user d-flex flex-column align-items-center">
            <span class="username">{{ Auth::user()->username ?? 'Guest' }}</span>
            
            <!-- Logout Button -->
            <a class="logout" href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4m-5-4l5-5l-5-5m5 5H3"/>
                </svg>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

    </div>
</nav>

    <!-- Sidebar -->
    <div class="sidebar {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
      <div class="sidebar-container">
        <div class="sidenav">
          <div class="accordion">
            <!-- Start Home -->
            <div class="accordion-item show">
              <h2 class="accordion-header">
                <a
                  href="{{ url('/home') }}"
                  data-target="{{ url('/home') }}"
                  class="menu-item accordion-button homeBtn"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="200"
                    height="200"
                    viewBox="0 0 20 20"
                  >
                    <g
                      fill="currentColor"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                    >
                      <path
                        d="M1 10h1.389v7a.5.5 0 0 0 .5.5H16.11a.5.5 0 0 0 .5-.5v-7H18a.5.5 0 0 0 .33-.875l-8.5-7.5a.5.5 0 0 0-.66 0l-8.5 7.5A.5.5 0 0 0 1 10Zm1.889-1h-.567L9.5 2.667L16.678 9h-.567a.5.5 0 0 0-.5.5v7H3.39v-7a.5.5 0 0 0-.5-.5Z"
                      />
                      <path
                        d="M10.708 11.5h-2.5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h2.5a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1Zm-2.5 5v-4h2.5v4h-2.5Z"
                      />
                    </g>
                  </svg>
                  {{ __('contreq.pagename49') }}
                </a>
              </h2>
            </div>
            <!-- End Home -->
            @if(Auth::user()->role_id == 1)
            <!-- Start Container Request -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapseOne"
                  aria-expanded="true"
                  aria-controls="collapseOne"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="200"
                    height="200"
                    viewBox="0 0 32 32"
                  >
                    <path
                      fill="currentColor"
                      d="M1 4v21h3.156c.446 1.719 1.992 3 3.844 3c1.852 0 3.398-1.281 3.844-3h8.312c.446 1.719 1.992 3 3.844 3c1.852 0 3.398-1.281 3.844-3H31V14.594l-.281-.313l-6-6L24.406 8H19V4zm2 2h14v17h-5.156c-.446-1.719-1.992-3-3.844-3c-1.852 0-3.398 1.281-3.844 3H3zm16 4h4.563L29 15.438V23h-1.156c-.446-1.719-1.992-3-3.844-3c-1.852 0-3.398 1.281-3.844 3H19zM8 22c1.117 0 2 .883 2 2s-.883 2-2 2s-2-.883-2-2s.883-2 2-2zm16 0c1.117 0 2 .883 2 2s-.883 2-2 2s-2-.883-2-2s.883-2 2-2z"
                    />
                  </svg>
                  {{ __('contreq.master1') }}
                 
                </button>
              </h2>
              <div
                id="collapseOne"
                class="accordion-collapse collapse"
                aria-labelledby="headingOne"
                data-bs-parent="#accordionExample"
              >
                <div class="acc-bd">
                  <!-- New Order -->
                  <a
                    href="{{ url('/containerrequests/create') }}"
                    data-target="{{ url('/containerrequests/create') }}"
                    class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M1664 1664h256v128h-256v256h-128v-256h-256v-128h256v-256h128v256zM384 128v1536h768v128H256V0h859l549 549v731h-128V640h-512V128H384zm768 91v293h293l-293-293z"
                      />
                    </svg>
                    <span>{{ __('contreq.master2') }}</span></a
                  >
                  <!-- Receive Order from Driver -->
                  <a href="{{ route('containerrequests.index') }}" data-target="{{ route('containerrequests.index') }}" class="menu-item ps-4">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M256 1920h1024v128H128V0h1115l549 549v731h-128V640h-512V128H256v1792zM1280 512h293l-293-293v293zm659 1517l-403-402v293h-128v-512h512v128h-293l402 403l-90 90z"
                      />
                    </svg>
                    {{ __('contreq.master3') }}
                    </a
                  >
                  <!--  Follow Up -->
                  <a href="{{url('/reqdel')}}" data-target="{{url('/reqdel')}}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M2048 384v128H768V384h1280zM768 768h1280v128H768V768zm0 384h1280v128H768v-128zm0 384h1280v128H768v-128zM478 990l68 68l-354 354l-178-178l68-68l110 110l286-286zm0-768l68 68l-354 354L14 466l68-68l110 110l286-286z"
                      />
                    </svg>
                    {{ __('contreq.master4') }}</a
                  >
                  <!-- Complete Request -->
                  <a href="{{ url('/comind') }}" data-target="{{ url('/comind') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 24 24"
                    >
                      <g
                        fill="none"
                        stroke="currentColor"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                      >
                        <path
                          stroke-linecap="round"
                          d="M7 21a2 2 0 0 1-2-2V3h9l5 5v11a2 2 0 0 1-2 2H7Z"
                        />
                        <path d="M13 3v6h6" />
                        <path stroke-linecap="round" d="m15 13l-4 4l-2-2" />
                      </g>
                    </svg>
                    {{ __('contreq.master5') }}</a
                  >
                </div>
              </div>
            </div>
            <!-- End Container Request -->

            <!-- Start Lift Container -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapseTwo"
                  aria-expanded="true"
                  aria-controls="collapseTwo"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="200"
                    height="200"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="currentColor"
                      d="M13.152.682a2.251 2.251 0 0 1 2.269 0l.007.004l6.957 4.276a2.277 2.277 0 0 1 1.126 1.964v7.516c0 .81-.432 1.56-1.133 1.968l-.002.001l-11.964 7.037l-.004.003c-.706.41-1.578.41-2.284 0l-.026-.015l-6.503-4.502a2.268 2.268 0 0 1-1.096-1.943V9.438c0-.392.1-.77.284-1.1l.003-.006l.014-.026c.197-.342.48-.627.82-.827h.002L13.152.681Zm.757 1.295h-.001L2.648 8.616l6.248 4.247a.775.775 0 0 0 .758-.01h.001l11.633-6.804l-6.629-4.074a.75.75 0 0 0-.75.003ZM8.517 14.33a2.286 2.286 0 0 1-.393-.18l-.023-.014l-6.102-4.147v7.003c0 .275.145.528.379.664l.025.014l6.114 4.232V14.33ZM18 9.709l-3.25 1.9v7.548L18 17.245Zm-7.59 4.438l-.002.002a2.296 2.296 0 0 1-.391.18v7.612l3.233-1.902v-7.552Zm9.09-5.316v7.532l2.124-1.25a.776.776 0 0 0 .387-.671V7.363Z"
                    />
                  </svg>
                  {{ __('contreq.master6') }}
                  
                </button>
              </h2>
              <div
                id="collapseTwo"
                class="accordion-collapse collapse"
                aria-labelledby="headingOne"
                data-bs-parent="#accordionExample"
              >
                <div class="acc-bd">
                <a href="{{ url('/newfillrequest') }}" data-target="{{ url('/newfillrequest') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M1664 1664h256v128h-256v256h-128v-256h-256v-128h256v-256h128v256zM384 128v1536h768v128H256V0h859l549 549v731h-128V640h-512V128H384zm768 91v293h293l-293-293z"
                      />
                    </svg>
                    {{ __('contreq.master2') }}</a
                  >
                  <a href="{{ url('/showRequests') }}" data-target="{{ url('/showRequests') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M1664 1664h256v128h-256v256h-128v-256h-256v-128h256v-256h128v256zM384 128v1536h768v128H256V0h859l549 549v731h-128V640h-512V128H384zm768 91v293h293l-293-293z"
                      />
                    </svg>
                    {{ __('contreq.master7') }}
                    </a
                  >
                  
                  <a href="{{ url('/managefillreq') }}" data-target="{{ url('/managefillreq') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M2048 384v128H768V384h1280zM768 768h1280v128H768V768zm0 384h1280v128H768v-128zm0 384h1280v128H768v-128zM478 990l68 68l-354 354l-178-178l68-68l110 110l286-286zm0-768l68 68l-354 354L14 466l68-68l110 110l286-286z"
                      />
                    </svg>
                    {{ __('contreq.master8') }}
                    </a
                  >
                  <a href="{{ url('/comfillind') }}" data-target="{{ url('/comfillind') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 24 24"
                    >
                      <g
                        fill="none"
                        stroke="currentColor"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                      >
                        <path
                          stroke-linecap="round"
                          d="M7 21a2 2 0 0 1-2-2V3h9l5 5v11a2 2 0 0 1-2 2H7Z"
                        />
                        <path d="M13 3v6h6" />
                        <path stroke-linecap="round" d="m15 13l-4 4l-2-2" />
                      </g>
                    </svg>
                    {{ __('contreq.master5') }}</a
                  >
                  <a href="{{ url('/uncomfillind') }}" data-target="{{ url('/uncomfillind') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 512 512"
                    >
                      <path
                        fill="currentColor"
                        d="M271.514 95.5h-32v178.111l115.613 54.948l13.737-28.902l-97.35-46.268V95.5z"
                      />
                      <path
                        fill="currentColor"
                        d="M256 16C123.452 16 16 123.452 16 256s107.452 240 240 240s240-107.452 240-240S388.548 16 256 16Zm0 448c-114.875 0-208-93.125-208-208S141.125 48 256 48s208 93.125 208 208s-93.125 208-208 208Z"
                      />
                    </svg>
                    {{ __('contreq.master9') }}
                    </a
                  >
                  <a href="{{ url('/emptyind') }}" data-target="{{ url('/emptyind') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 24 24"
                    >
                      <g
                        fill="none"
                        stroke="currentColor"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                      >
                        <path
                          stroke-linecap="round"
                          d="M7 21a2 2 0 0 1-2-2V3h9l5 5v11a2 2 0 0 1-2 2H7Z"
                        />
                        <path d="M13 3v6h6" />
                        <path stroke-linecap="round" d="m15 13l-4 4l-2-2" />
                      </g>
                    </svg>
                    {{ __('contreq.master10') }}
                    </a
                  >
                  <a href="{{ url('/unemptyind') }}" data-target="{{ url('/unemptyind') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 512 512"
                    >
                      <path
                        fill="currentColor"
                        d="M271.514 95.5h-32v178.111l115.613 54.948l13.737-28.902l-97.35-46.268V95.5z"
                      />
                      <path
                        fill="currentColor"
                        d="M256 16C123.452 16 16 123.452 16 256s107.452 240 240 240s240-107.452 240-240S388.548 16 256 16Zm0 448c-114.875 0-208-93.125-208-208S141.125 48 256 48s208 93.125 208 208s-93.125 208-208 208Z"
                      />
                    </svg>
                    {{ __('contreq.master11') }}
                    </a
                  >
                </div>
              </div>
            </div>
            <!-- End Lift Container Request -->
            @endif
            @if(Auth::user()->role_id == 2)
            <!-- Start contract -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapseSix"
                  aria-expanded="true"
                  aria-controls="collapseSix"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="200"
                    height="200"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="currentColor"
                      d="M13.152.682a2.251 2.251 0 0 1 2.269 0l.007.004l6.957 4.276a2.277 2.277 0 0 1 1.126 1.964v7.516c0 .81-.432 1.56-1.133 1.968l-.002.001l-11.964 7.037l-.004.003c-.706.41-1.578.41-2.284 0l-.026-.015l-6.503-4.502a2.268 2.268 0 0 1-1.096-1.943V9.438c0-.392.1-.77.284-1.1l.003-.006l.014-.026c.197-.342.48-.627.82-.827h.002L13.152.681Zm.757 1.295h-.001L2.648 8.616l6.248 4.247a.775.775 0 0 0 .758-.01h.001l11.633-6.804l-6.629-4.074a.75.75 0 0 0-.75.003ZM8.517 14.33a2.286 2.286 0 0 1-.393-.18l-.023-.014l-6.102-4.147v7.003c0 .275.145.528.379.664l.025.014l6.114 4.232V14.33ZM18 9.709l-3.25 1.9v7.548L18 17.245Zm-7.59 4.438l-.002.002a2.296 2.296 0 0 1-.391.18v7.612l3.233-1.902v-7.552Zm9.09-5.316v7.532l2.124-1.25a.776.776 0 0 0 .387-.671V7.363Z"
                    />
                  </svg>
                  {{ __('contreq.master12') }}
                  
                </button>
              </h2>
              <div
                id="collapseSix"
                class="accordion-collapse collapse"
                aria-labelledby="headingOne"
                data-bs-parent="#accordionExample"
              >
                <div class="acc-bd">
                  <a href="{{ url('/createcontract') }}" data-target="{{ url('/createcontract') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M1664 1664h256v128h-256v256h-128v-256h-256v-128h256v-256h128v256zM384 128v1536h768v128H256V0h859l549 549v731h-128V640h-512V128H384zm768 91v293h293l-293-293z"
                      />
                    </svg>
                    {{ __('contreq.master13') }}
                    </a
                  >
                  <a href="{{ url('/createcontracttemplate') }}" data-target="{{ url('/createcontract') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M1664 1664h256v128h-256v256h-128v-256h-256v-128h256v-256h128v256zM384 128v1536h768v128H256V0h859l549 549v731h-128V640h-512V128H384zm768 91v293h293l-293-293z"
                      />
                    </svg>
                    {{ __('contreq.pagename85') }}
                    </a
                  >
                  <a href="{{ url('/showcontracttemplates') }}" data-target="{{ url('/createcontract') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M1664 1664h256v128h-256v256h-128v-256h-256v-128h256v-256h128v256zM384 128v1536h768v128H256V0h859l549 549v731h-128V640h-512V128H384zm768 91v293h293l-293-293z"
                      />
                    </svg>
                    {{ __('contreq.pagename86') }}
                    </a
                  >
                  
                  <a href="{{ url('/contractindex') }}" data-target="{{ url('/contractindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M2048 384v128H768V384h1280zM768 768h1280v128H768V768zm0 384h1280v128H768v-128zm0 384h1280v128H768v-128zM478 990l68 68l-354 354l-178-178l68-68l110 110l286-286zm0-768l68 68l-354 354L14 466l68-68l110 110l286-286z"
                      />
                    </svg>
                    {{ __('contreq.master14') }}</a
                  >
                  
                </div>
              </div>
            </div>
            <!-- End Contract -->
            
<!-- Start mange employee -->
<div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapseSeven"
                  aria-expanded="true"
                  aria-controls="collapseSeven"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="200"
                    height="200"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="currentColor"
                      d="M13.152.682a2.251 2.251 0 0 1 2.269 0l.007.004l6.957 4.276a2.277 2.277 0 0 1 1.126 1.964v7.516c0 .81-.432 1.56-1.133 1.968l-.002.001l-11.964 7.037l-.004.003c-.706.41-1.578.41-2.284 0l-.026-.015l-6.503-4.502a2.268 2.268 0 0 1-1.096-1.943V9.438c0-.392.1-.77.284-1.1l.003-.006l.014-.026c.197-.342.48-.627.82-.827h.002L13.152.681Zm.757 1.295h-.001L2.648 8.616l6.248 4.247a.775.775 0 0 0 .758-.01h.001l11.633-6.804l-6.629-4.074a.75.75 0 0 0-.75.003ZM8.517 14.33a2.286 2.286 0 0 1-.393-.18l-.023-.014l-6.102-4.147v7.003c0 .275.145.528.379.664l.025.014l6.114 4.232V14.33ZM18 9.709l-3.25 1.9v7.548L18 17.245Zm-7.59 4.438l-.002.002a2.296 2.296 0 0 1-.391.18v7.612l3.233-1.902v-7.552Zm9.09-5.316v7.532l2.124-1.25a.776.776 0 0 0 .387-.671V7.363Z"
                    />
                  </svg>
                  {{ __('contreq.master15') }}
                  
                </button>
              </h2>
              <div
                id="collapseSeven"
                class="accordion-collapse collapse"
                aria-labelledby="headingOne"
                data-bs-parent="#accordionExample"
              >
                <div class="acc-bd">
                  <a href="{{ url('/createdepartment') }}" data-target="{{ url('/createdepartment') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M1664 1664h256v128h-256v256h-128v-256h-256v-128h256v-256h128v256zM384 128v1536h768v128H256V0h859l549 549v731h-128V640h-512V128H384zm768 91v293h293l-293-293z"
                      />
                    </svg>
                    {{ __('contreq.master16') }}
                    </a
                  >
                  
                  <a href="{{ url('/departmentindex') }}" data-target="{{ url('/departmentindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M2048 384v128H768V384h1280zM768 768h1280v128H768V768zm0 384h1280v128H768v-128zm0 384h1280v128H768v-128zM478 990l68 68l-354 354l-178-178l68-68l110 110l286-286zm0-768l68 68l-354 354L14 466l68-68l110 110l286-286z"
                      />
                    </svg>
                    {{ __('contreq.master17') }}
                    </a
                  >
                  <a href="{{ url('/createposition') }}" data-target="{{ url('/createposition') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M1664 1664h256v128h-256v256h-128v-256h-256v-128h256v-256h128v256zM384 128v1536h768v128H256V0h859l549 549v731h-128V640h-512V128H384zm768 91v293h293l-293-293z"
                      />
                    </svg>
                    {{ __('contreq.master18') }}
                    </a
                  >
                  
                  <a href="{{ url('/positionindex') }}" data-target="{{ url('/positionindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M2048 384v128H768V384h1280zM768 768h1280v128H768V768zm0 384h1280v128H768v-128zm0 384h1280v128H768v-128zM478 990l68 68l-354 354l-178-178l68-68l110 110l286-286zm0-768l68 68l-354 354L14 466l68-68l110 110l286-286z"
                      />
                    </svg>
                    {{ __('contreq.master19') }}
                    </a
                  >
                  <a href="{{ url('/createemployee') }}" data-target="{{ url('/createemployee') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M1664 1664h256v128h-256v256h-128v-256h-256v-128h256v-256h128v256zM384 128v1536h768v128H256V0h859l549 549v731h-128V640h-512V128H384zm768 91v293h293l-293-293z"
                      />
                    </svg>
                    {{ __('contreq.master20') }}
                    </a
                  >
                  
                  <a href="{{ url('/employeeindex') }}" data-target="{{ url('/employeeindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M2048 384v128H768V384h1280zM768 768h1280v128H768V768zm0 384h1280v128H768v-128zm0 384h1280v128H768v-128zM478 990l68 68l-354 354l-178-178l68-68l110 110l286-286zm0-768l68 68l-354 354L14 466l68-68l110 110l286-286z"
                      />
                    </svg>
                    {{ __('contreq.master21') }}
                    </a
                  >
                  <a href="{{ url('/salaryindex') }}" data-target="{{ url('/salaryindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M2048 384v128H768V384h1280zM768 768h1280v128H768V768zm0 384h1280v128H768v-128zm0 384h1280v128H768v-128zM478 990l68 68l-354 354l-178-178l68-68l110 110l286-286zm0-768l68 68l-354 354L14 466l68-68l110 110l286-286z"
                      />
                    </svg>
                    {{ __('contreq.master22') }}
                    </a
                  >
                </div>
              </div>
            </div>
            <!-- End Contract -->
           
            @endif
            @if(Auth::user()->role_id == 3)
            <!-- Start Settings -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapseFive"
                  aria-expanded="true"
                  aria-controls="collapseFive"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 1024 1024"
                  >
                    <path
                      fill="currentColor"
                      d="M600.704 64a32 32 0 0 1 30.464 22.208l35.2 109.376c14.784 7.232 28.928 15.36 42.432 24.512l112.384-24.192a32 32 0 0 1 34.432 15.36L944.32 364.8a32 32 0 0 1-4.032 37.504l-77.12 85.12a357.12 357.12 0 0 1 0 49.024l77.12 85.248a32 32 0 0 1 4.032 37.504l-88.704 153.6a32 32 0 0 1-34.432 15.296L708.8 803.904c-13.44 9.088-27.648 17.28-42.368 24.512l-35.264 109.376A32 32 0 0 1 600.704 960H423.296a32 32 0 0 1-30.464-22.208L357.696 828.48a351.616 351.616 0 0 1-42.56-24.64l-112.32 24.256a32 32 0 0 1-34.432-15.36L79.68 659.2a32 32 0 0 1 4.032-37.504l77.12-85.248a357.12 357.12 0 0 1 0-48.896l-77.12-85.248A32 32 0 0 1 79.68 364.8l88.704-153.6a32 32 0 0 1 34.432-15.296l112.32 24.256c13.568-9.152 27.776-17.408 42.56-24.64l35.2-109.312A32 32 0 0 1 423.232 64H600.64zm-23.424 64H446.72l-36.352 113.088l-24.512 11.968a294.113 294.113 0 0 0-34.816 20.096l-22.656 15.36l-116.224-25.088l-65.28 113.152l79.68 88.192l-1.92 27.136a293.12 293.12 0 0 0 0 40.192l1.92 27.136l-79.808 88.192l65.344 113.152l116.224-25.024l22.656 15.296a294.113 294.113 0 0 0 34.816 20.096l24.512 11.968L446.72 896h130.688l36.48-113.152l24.448-11.904a288.282 288.282 0 0 0 34.752-20.096l22.592-15.296l116.288 25.024l65.28-113.152l-79.744-88.192l1.92-27.136a293.12 293.12 0 0 0 0-40.256l-1.92-27.136l79.808-88.128l-65.344-113.152l-116.288 24.96l-22.592-15.232a287.616 287.616 0 0 0-34.752-20.096l-24.448-11.904L577.344 128zM512 320a192 192 0 1 1 0 384a192 192 0 0 1 0-384zm0 64a128 128 0 1 0 0 256a128 128 0 0 0 0-256z"
                    />
                  </svg>

                  {{ __('contreq.master37') }}
                </button>
              </h2>
              <div
                id="collapseFive"
                class="accordion-collapse collapse"
                aria-labelledby="headingOne"
                data-bs-parent="#accordionExample"
              >
                <div class="acc-bd">
                  <a href="{{ url('/createuser') }}" data-target="{{ url('/createuser') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 1024 1024"
                    >
                      <path
                        fill="currentColor"
                        d="M640.6 429.8h257.1c7.9 0 14.3-6.4 14.3-14.3V158.3c0-7.9-6.4-14.3-14.3-14.3H640.6c-7.9 0-14.3 6.4-14.3 14.3v92.9H490.6c-3.9 0-7.1 3.2-7.1 7.1v221.5h-85.7v-96.5c0-7.9-6.4-14.3-14.3-14.3H126.3c-7.9 0-14.3 6.4-14.3 14.3v257.2c0 7.9 6.4 14.3 14.3 14.3h257.1c7.9 0 14.3-6.4 14.3-14.3V544h85.7v221.5c0 3.9 3.2 7.1 7.1 7.1h135.7v92.9c0 7.9 6.4 14.3 14.3 14.3h257.1c7.9 0 14.3-6.4 14.3-14.3v-257c0-7.9-6.4-14.3-14.3-14.3h-257c-7.9 0-14.3 6.4-14.3 14.3v100h-78.6v-393h78.6v100c0 7.9 6.4 14.3 14.3 14.3zm53.5-217.9h150V362h-150V211.9zM329.9 587h-150V437h150v150zm364.2 75.1h150v150.1h-150V662.1z"
                      />
                    </svg>
                    {{ __('contreq.master38') }}</a
                  >

                  <a href="{{ url('/userindex') }}" data-target="{{ url('/userindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master39') }}
                  </a>
                  <a href="{{ url('/createvendor') }}" data-target="{{ url('/createuser') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 1024 1024"
                    >
                      <path
                        fill="currentColor"
                        d="M640.6 429.8h257.1c7.9 0 14.3-6.4 14.3-14.3V158.3c0-7.9-6.4-14.3-14.3-14.3H640.6c-7.9 0-14.3 6.4-14.3 14.3v92.9H490.6c-3.9 0-7.1 3.2-7.1 7.1v221.5h-85.7v-96.5c0-7.9-6.4-14.3-14.3-14.3H126.3c-7.9 0-14.3 6.4-14.3 14.3v257.2c0 7.9 6.4 14.3 14.3 14.3h257.1c7.9 0 14.3-6.4 14.3-14.3V544h85.7v221.5c0 3.9 3.2 7.1 7.1 7.1h135.7v92.9c0 7.9 6.4 14.3 14.3 14.3h257.1c7.9 0 14.3-6.4 14.3-14.3v-257c0-7.9-6.4-14.3-14.3-14.3h-257c-7.9 0-14.3 6.4-14.3 14.3v100h-78.6v-393h78.6v100c0 7.9 6.4 14.3 14.3 14.3zm53.5-217.9h150V362h-150V211.9zM329.9 587h-150V437h150v150zm364.2 75.1h150v150.1h-150V662.1z"
                      />
                    </svg>
                    {{ __('contreq.pagename78') }}</a
                  >

                  <a href="{{ url('/vendorindex') }}" data-target="{{ url('/userindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.pagename77') }}
                  </a>
                  <a href="{{ url('/complamentstatusindex') }}" data-target="{{ url('/complamentstatusindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.pagename88') }}
                  </a>
                  <a href="{{ url('/stockindex') }}" data-target="{{ url('/stockindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.pagename80') }}
                  </a>
                  <a href="{{ url('/createstock') }}" data-target="{{ url('/createstock') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.pagename81') }}
                  </a>
                  <a href="{{ url('/createevaluationtemplate') }}" data-target="{{ url('/createevaluationtemplate') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.pagename82') }}
                  </a>
                  <a href="{{ url('/createevaluation') }}" data-target="{{ url('/createevaluation') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.pagename83') }}
                  </a>
                  <a href="{{url('/evaluation')}}"  data-target="{{ url('/showEvaluationResults') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.evaluationResults') }}
                  </a>
                  <a href="{{ url('/containersizeindex') }}" data-target="{{ url('/containersizeindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master40') }}
                  </a>
                 

                  <a href="{{ url('/bankindex') }}" data-target="{{ url('/bankindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 14 14"
                    >
                      <path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12.75 11.5v-9H1.25v9zm.75-9H.5m13 9H.5M4 5v4m3-4v4m3-4v4"
                      />
                    </svg>
                    {{ __('contreq.pagename59') }}</a
                  >
                  <a href="{{ url('/bldehindex') }}" data-target="{{ url('/bldehindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 14 14"
                    >
                      <path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12.75 11.5v-9H1.25v9zm.75-9H.5m13 9H.5M4 5v4m3-4v4m3-4v4"
                      />
                    </svg>
                    {{ __('contreq.pagename61') }}</a
                  >
                  <a href="{{ url('/basicclassindex') }}" data-target="{{ url('/basicclassindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 14 14"
                    >
                      <path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12.75 11.5v-9H1.25v9zm.75-9H.5m13 9H.5M4 5v4m3-4v4m3-4v4"
                      />
                    </svg>
                    {{ __('contreq.pagename63') }}</a
                  >
                  <a href="{{ url('/nationalityindex') }}" data-target="{{ url('/nationalityindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 14 14"
                    >
                      <path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12.75 11.5v-9H1.25v9zm.75-9H.5m13 9H.5M4 5v4m3-4v4m3-4v4"
                      />
                    </svg>
                    {{ __('contreq.pagename67') }}</a
                  >
                  <a href="#" data-target="option2.html" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 32 32"
                    >
                      <path
                        fill="currentColor"
                        d="M12 6H8V2H6v4H2v2h4v4h2V8h4V6z"
                      />
                      <path
                        fill="currentColor"
                        d="m29.919 16.606l-3-7A.999.999 0 0 0 26 9h-3V7a1 1 0 0 0-1-1h-7v2h6v12.556A3.992 3.992 0 0 0 19.142 23h-6.284a3.98 3.98 0 0 0-7.716 0H4v-9H2v10a1 1 0 0 0 1 1h2.142a3.98 3.98 0 0 0 7.716 0h6.284a3.98 3.98 0 0 0 7.716 0H29a1 1 0 0 0 1-1v-7a.997.997 0 0 0-.081-.394ZM9 26a2 2 0 1 1 2-2a2.003 2.003 0 0 1-2 2Zm14-15h2.34l2.144 5H23Zm0 15a2 2 0 1 1 2-2a2.002 2.002 0 0 1-2 2Zm5-3h-1.142A3.995 3.995 0 0 0 23 20v-2h5Z"
                      />
                    </svg>
                    {{ __('contreq.master42') }}</a
                  >
                  <a href="{{ url('/cityindex') }}" data-target="{{ url('/cityindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.city') }}
                  
                  </a>
                </div>
              </div>
            </div>
            <!-- End Settings -->
            @endif
            @if(Auth::user()->role_id == 2)
              <!-- Start calculater -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapseEight"
                  aria-expanded="true"
                  aria-controls="collapseEight"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 1024 1024"
                  >
                    <path
                      fill="currentColor"
                      d="M600.704 64a32 32 0 0 1 30.464 22.208l35.2 109.376c14.784 7.232 28.928 15.36 42.432 24.512l112.384-24.192a32 32 0 0 1 34.432 15.36L944.32 364.8a32 32 0 0 1-4.032 37.504l-77.12 85.12a357.12 357.12 0 0 1 0 49.024l77.12 85.248a32 32 0 0 1 4.032 37.504l-88.704 153.6a32 32 0 0 1-34.432 15.296L708.8 803.904c-13.44 9.088-27.648 17.28-42.368 24.512l-35.264 109.376A32 32 0 0 1 600.704 960H423.296a32 32 0 0 1-30.464-22.208L357.696 828.48a351.616 351.616 0 0 1-42.56-24.64l-112.32 24.256a32 32 0 0 1-34.432-15.36L79.68 659.2a32 32 0 0 1 4.032-37.504l77.12-85.248a357.12 357.12 0 0 1 0-48.896l-77.12-85.248A32 32 0 0 1 79.68 364.8l88.704-153.6a32 32 0 0 1 34.432-15.296l112.32 24.256c13.568-9.152 27.776-17.408 42.56-24.64l35.2-109.312A32 32 0 0 1 423.232 64H600.64zm-23.424 64H446.72l-36.352 113.088l-24.512 11.968a294.113 294.113 0 0 0-34.816 20.096l-22.656 15.36l-116.224-25.088l-65.28 113.152l79.68 88.192l-1.92 27.136a293.12 293.12 0 0 0 0 40.192l1.92 27.136l-79.808 88.192l65.344 113.152l116.224-25.024l22.656 15.296a294.113 294.113 0 0 0 34.816 20.096l24.512 11.968L446.72 896h130.688l36.48-113.152l24.448-11.904a288.282 288.282 0 0 0 34.752-20.096l22.592-15.296l116.288 25.024l65.28-113.152l-79.744-88.192l1.92-27.136a293.12 293.12 0 0 0 0-40.256l-1.92-27.136l79.808-88.128l-65.344-113.152l-116.288 24.96l-22.592-15.232a287.616 287.616 0 0 0-34.752-20.096l-24.448-11.904L577.344 128zM512 320a192 192 0 1 1 0 384a192 192 0 0 1 0-384zm0 64a128 128 0 1 0 0 256a128 128 0 0 0 0-256z"
                    />
                  </svg>
                  {{ __('contreq.master29') }}
                  
                </button>
              </h2>
              <div
                id="collapseEight"
                class="accordion-collapse collapse"
                aria-labelledby="headingOne"
                data-bs-parent="#accordionExample"
              >
                <div class="acc-bd">
                  <a href="{{ url('/createaccount') }}" data-target="{{ url('/createaccount') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 1024 1024"
                    >
                      <path
                        fill="currentColor"
                        d="M640.6 429.8h257.1c7.9 0 14.3-6.4 14.3-14.3V158.3c0-7.9-6.4-14.3-14.3-14.3H640.6c-7.9 0-14.3 6.4-14.3 14.3v92.9H490.6c-3.9 0-7.1 3.2-7.1 7.1v221.5h-85.7v-96.5c0-7.9-6.4-14.3-14.3-14.3H126.3c-7.9 0-14.3 6.4-14.3 14.3v257.2c0 7.9 6.4 14.3 14.3 14.3h257.1c7.9 0 14.3-6.4 14.3-14.3V544h85.7v221.5c0 3.9 3.2 7.1 7.1 7.1h135.7v92.9c0 7.9 6.4 14.3 14.3 14.3h257.1c7.9 0 14.3-6.4 14.3-14.3v-257c0-7.9-6.4-14.3-14.3-14.3h-257c-7.9 0-14.3 6.4-14.3 14.3v100h-78.6v-393h78.6v100c0 7.9 6.4 14.3 14.3 14.3zm53.5-217.9h150V362h-150V211.9zM329.9 587h-150V437h150v150zm364.2 75.1h150v150.1h-150V662.1z"
                      />
                    </svg>
                    {{ __('contreq.master30') }}
                    </a
                  >

                  <a href="{{ url('/accountindex') }}" data-target="{{ url('/accountindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master31') }}
                    
                  </a>
                  <a href="{{ url('/accountbalance') }}" data-target="{{ url('/accountbalance') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master32') }}
                    
                  </a>
                  <a href="{{ url('/createpurchase') }}" data-target="{{ url('/createpurchase') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.pagename87') }}
                    
                  </a>
                  <a href="{{ url('/sandSearch') }}" data-target="{{ url('/sandSearch') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master33') }}
                    
                  </a>
                  <a href="{{ url('/createsand') }}" data-target="{{ url('/createsand') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master34') }}
                   
                  </a>
                  <a href="{{ url('/createsandreq') }}" data-target="{{ url('/createsandreq') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master52') }}
                   
                  </a>
                  <a href="{{ url('/createcustpayment') }}" data-target="{{ url('/createcustpayment') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master53') }}
                   
                  </a>
                  <a href="{{ url('/createcustomers') }}" data-target="{{ url('/createcustomers') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master35') }}
                   
                  </a>
                  <a href="{{ url('/customerindex') }}" data-target="{{ url('/customerindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master36') }}
                  
                  </a>
                  
                 
                </div>
              </div>
            </div>
            @endif
            <!-- End Calculaters -->
            
             <!-- Start report -->
             <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapseNine"
                  aria-expanded="true"
                  aria-controls="collapseNine"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 1024 1024"
                  >
                    <path
                      fill="currentColor"
                      d="M600.704 64a32 32 0 0 1 30.464 22.208l35.2 109.376c14.784 7.232 28.928 15.36 42.432 24.512l112.384-24.192a32 32 0 0 1 34.432 15.36L944.32 364.8a32 32 0 0 1-4.032 37.504l-77.12 85.12a357.12 357.12 0 0 1 0 49.024l77.12 85.248a32 32 0 0 1 4.032 37.504l-88.704 153.6a32 32 0 0 1-34.432 15.296L708.8 803.904c-13.44 9.088-27.648 17.28-42.368 24.512l-35.264 109.376A32 32 0 0 1 600.704 960H423.296a32 32 0 0 1-30.464-22.208L357.696 828.48a351.616 351.616 0 0 1-42.56-24.64l-112.32 24.256a32 32 0 0 1-34.432-15.36L79.68 659.2a32 32 0 0 1 4.032-37.504l77.12-85.248a357.12 357.12 0 0 1 0-48.896l-77.12-85.248A32 32 0 0 1 79.68 364.8l88.704-153.6a32 32 0 0 1 34.432-15.296l112.32 24.256c13.568-9.152 27.776-17.408 42.56-24.64l35.2-109.312A32 32 0 0 1 423.232 64H600.64zm-23.424 64H446.72l-36.352 113.088l-24.512 11.968a294.113 294.113 0 0 0-34.816 20.096l-22.656 15.36l-116.224-25.088l-65.28 113.152l79.68 88.192l-1.92 27.136a293.12 293.12 0 0 0 0 40.192l1.92 27.136l-79.808 88.192l65.344 113.152l116.224-25.024l22.656 15.296a294.113 294.113 0 0 0 34.816 20.096l24.512 11.968L446.72 896h130.688l36.48-113.152l24.448-11.904a288.282 288.282 0 0 0 34.752-20.096l22.592-15.296l116.288 25.024l65.28-113.152l-79.744-88.192l1.92-27.136a293.12 293.12 0 0 0 0-40.256l-1.92-27.136l79.808-88.128l-65.344-113.152l-116.288 24.96l-22.592-15.232a287.616 287.616 0 0 0-34.752-20.096l-24.448-11.904L577.344 128zM512 320a192 192 0 1 1 0 384a192 192 0 0 1 0-384zm0 64a128 128 0 1 0 0 256a128 128 0 0 0 0-256z"
                    />
                  </svg>
                  {{ __('contreq.master43') }}
                  
                </button>
              </h2>
              <div
                id="collapseNine"
                class="accordion-collapse collapse"
                aria-labelledby="headingOne"
                data-bs-parent="#accordionExample"
              >
                <div class="acc-bd">
                  <a href="{{ url('/containers-report') }}" data-target="{{ url('/containers-report') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 1024 1024"
                    >
                      <path
                        fill="currentColor"
                        d="M640.6 429.8h257.1c7.9 0 14.3-6.4 14.3-14.3V158.3c0-7.9-6.4-14.3-14.3-14.3H640.6c-7.9 0-14.3 6.4-14.3 14.3v92.9H490.6c-3.9 0-7.1 3.2-7.1 7.1v221.5h-85.7v-96.5c0-7.9-6.4-14.3-14.3-14.3H126.3c-7.9 0-14.3 6.4-14.3 14.3v257.2c0 7.9 6.4 14.3 14.3 14.3h257.1c7.9 0 14.3-6.4 14.3-14.3V544h85.7v221.5c0 3.9 3.2 7.1 7.1 7.1h135.7v92.9c0 7.9 6.4 14.3 14.3 14.3h257.1c7.9 0 14.3-6.4 14.3-14.3v-257c0-7.9-6.4-14.3-14.3-14.3h-257c-7.9 0-14.3 6.4-14.3 14.3v100h-78.6v-393h78.6v100c0 7.9 6.4 14.3 14.3 14.3zm53.5-217.9h150V362h-150V211.9zM329.9 587h-150V437h150v150zm364.2 75.1h150v150.1h-150V662.1z"
                      />
                    </svg>
                    {{ __('contreq.master44') }}
                    </a
                  >

                  <a href="{{ url('/accounts-report') }}" data-target="{{ url('/accountindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master45') }}
                    
                  </a>
                  <a href="{{ url('/createsalereport') }}" data-target="{{ url('/accountbalance') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master46') }}
                    
                  </a>
                  <a href="{{ url('/showcustomerReport') }}" data-target="{{ url('/showcustomerReport') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master54') }}
                    
                  </a>
                  <a href="{{ url('/createcontractreport') }}" data-target="{{ url('/createcontractreport') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master47') }}
                    
                  </a>
                  <a href="{{ url('/createinvoicesreport') }}" data-target="{{ url('/createsand') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master48') }}
                   
                  </a>
                  <a href="{{ url('/createsandssreport') }}" data-target="{{ url('/createcustomers') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master49') }}
                   
                  </a>
                  <a href="{{ url('/createpurchasereport') }}" data-target="{{ url('/createpurchasereport') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master50') }}
                  
                  </a>
                  <a href="{{ url('/createitemsreport') }}" data-target="{{ url('/createitemsreport') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.master51') }}
                  
                  </a>
                  <a href="{{ url('/createmainrequestsreport') }}" data-target="{{ url('/createmainrequestsreport') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"
                        />
                        <path
                          fill="currentColor"
                          d="M11 2a5 5 0 1 0 0 10a5 5 0 0 0 0-10ZM8 7a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM4 18.5c0-.18.09-.489.413-.899c.316-.4.804-.828 1.451-1.222C7.157 15.589 8.977 15 11 15c.375 0 .744.02 1.105.059a1 1 0 1 0 .211-1.99A12.905 12.905 0 0 0 11 13c-2.395 0-4.575.694-6.178 1.671c-.8.49-1.484 1.065-1.978 1.69C2.358 16.977 2 17.713 2 18.5c0 .845.411 1.511 1.003 1.986c.56.45 1.299.748 2.084.956C6.665 21.859 8.771 22 11 22l.685-.005a1 1 0 1 0-.027-2L11 20c-2.19 0-4.083-.143-5.4-.492c-.663-.175-1.096-.382-1.345-.582C4.037 18.751 4 18.622 4 18.5ZM18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1Z"
                        />
                      </g>
                    </svg>
                    {{ __('contreq.pagename97') }}
                  
                  </a>
                </div>
              </div>
            </div>
            <!-- End report -->
            @if(Auth::user()->role_id == 1)
              <!-- Start Customer Complaint -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapseThree"
                  aria-expanded="true"
                  aria-controls="collapseThree"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="currentColor"
                      d="M20 12V7h2v6h-2m0 4h2v-2h-2m-10-2c2.67 0 8 1.34 8 4v3H2v-3c0-2.66 5.33-4 8-4m0-9a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10.9c-2.97 0-6.1 1.46-6.1 2.1v1.1h12.2V17c0-.64-3.13-2.1-6.1-2.1m0-9A2.1 2.1 0 0 0 7.9 8a2.1 2.1 0 0 0 2.1 2.1A2.1 2.1 0 0 0 12.1 8A2.1 2.1 0 0 0 10 5.9Z"
                    />
                  </svg>
                  {{ __('contreq.master23') }}
                 
                </button>
              </h2>
              <div
                id="collapseThree"
                class="accordion-collapse collapse"
                aria-labelledby="headingOne"
                data-bs-parent="#accordionExample"
              >
                <div class="acc-bd">
                  <a href="{{ url('/complamintindex') }}" data-target="{{ url('/createitemsreport') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 9h8m-8 4h6m-1.99 5.594L8 21v-3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v5.5M16 19h6m-3-3v6"
                      />
                    </svg>
                    {{ __('contreq.master24') }}
                    </a
                  >

                  
                </div>
              </div>
            </div>
            @endif
            <!-- End Customer Complaint -->

            <!-- Start Car Repair Request -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapseFour"
                  aria-expanded="true"
                  aria-controls="collapseFour"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M11.42 15.17L17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z"
                    />
                  </svg>
                  {{ __('contreq.master26') }}
                 
                </button>
              </h2>
              <div
                id="collapseFour"
                class="accordion-collapse collapse"
                aria-labelledby="headingOne"
                data-bs-parent="#accordionExample"
              >
                <div class="acc-bd">
                  <a href="{{ url('/createmaintinancerequest') }}" data-target="{{ url('/createmaintinancerequest') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M1664 1664h256v128h-256v256h-128v-256h-256v-128h256v-256h128v256zM384 128v1536h768v128H256V0h859l549 549v731h-128V640h-512V128H384zm768 91v293h293l-293-293z"
                      />
                    </svg>
                    {{ __('contreq.master27') }}</a
                  >
                  <a href="{{ url('/maintinancerequestindex') }}" data-target="{{ url('/maintinancerequestindex') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M2048 384v128H768V384h1280zM768 768h1280v128H768V768zm0 384h1280v128H768v-128zm0 384h1280v128H768v-128zM478 990l68 68l-354 354l-178-178l68-68l110 110l286-286zm0-768l68 68l-354 354L14 466l68-68l110 110l286-286z"
                      />
                    </svg>
                    {{ __('contreq.pagename92') }}</a
                  >
                  <a href="{{ url('/maintinancerequestindex1') }}" data-target="{{ url('/maintinancerequestindex1') }}" class="menu-item ps-4"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="200"
                      height="200"
                      viewBox="0 0 2048 2048"
                    >
                      <path
                        fill="currentColor"
                        d="M2048 384v128H768V384h1280zM768 768h1280v128H768V768zm0 384h1280v128H768v-128zm0 384h1280v128H768v-128zM478 990l68 68l-354 354l-178-178l68-68l110 110l286-286zm0-768l68 68l-354 354L14 466l68-68l110 110l286-286z"
                      />
                    </svg>
                    {{ __('contreq.pagename93') }}</a
                  >
                </div>
              </div>
            </div>
            <!-- End Car Repair Request -->
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
    @yield('content')  <!-- Content from individual views will go here -->
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to toggle the language between English and Arabic
        function toggleLanguage() {
            let currentLang = "{{ app()->getLocale() }}"; // Get current language (English or Arabic)
            let newLang = currentLang === 'en' ? 'ar' : 'en'; // Toggle between English and Arabic

            // Add the new language to the form as a hidden input
            let form = document.getElementById('language-form');
            let langInput = document.createElement('input');
            langInput.type = 'hidden';
            langInput.name = 'lang';
            langInput.value = newLang;
            form.appendChild(langInput);
            // Submit the form to reload the page with the new language
            form.submit();
        }
    </script>
    <!-- Additional scripts can be included here -->
    @yield('scripts')
  </body>
</html>
