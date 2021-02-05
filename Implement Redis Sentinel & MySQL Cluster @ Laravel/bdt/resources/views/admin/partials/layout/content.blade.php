<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'          - Fixed Header

// Brand options
1. '.brand-minimized'       - Minimized brand (Only symbol)

// Sidebar options
1. '.sidebar-fixed'         - Fixed Sidebar
2. '.sidebar-hidden'        - Hidden Sidebar
3. '.sidebar-off-canvas'    - Off Canvas Sidebar
4. '.sidebar-minimized'     - Minimized Sidebar (Only icons)
5. '.sidebar-compact'       - Compact Sidebar

// Aside options
1. '.aside-menu-fixed'      - Fixed Aside Menu
2. '.aside-menu-hidden'     - Hidden Aside Menu
3. '.aside-menu-off-canvas' - Off Canvas Aside Menu

// Breadcrumb options
1. '.breadcrumb-fixed'      - Fixed Breadcrumb

// Footer options
1. '.footer-fixed'          - Fixed footer

-->
@include('admin.partials.layout.header')

<div class="app-body">
  @include('admin.partials.layout.sidebar')

  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      @yield('breadcrumb')
    </ol>

    <div class="container-fluid">

      <div class="animated fadeIn">
        @yield('content')
      </div>

    </div>
    <!-- /.conainer-fluid -->
  </main>

  @include('admin.partials.layout.aside-menu')

</div>

@include('admin.partials.layout.footer')