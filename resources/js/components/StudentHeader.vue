<template>
  <div class="shadow">
    <header id="page-header">
      <!-- Header Content -->
      <div class="content-header bg-white-op-90">
        <!-- Left Section -->
        <div class="content-header-section py-10">
          <!-- Logo -->
          <div class="content-header-item">
            <a class="font-w700 mr-5" href="/">
              <span>
                <img style="width: 190px;" src alt="logo" />
              </span>
            </a>
          </div>
          <!-- END Logo -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="content-header-section">
          <ul class="nav-main-header nav-main-header-no-icons">
            <li>
              <a class="ac-link" href="/">
                <i class="si si-home"></i>Discover
              </a>
            </li>

            <li>
              <a class="ac-link" href>
                Become a
                Tutor
              </a>
            </li>
            <li>
              <a class="ac-link" href>
                Sign
                In
              </a>
            </li>
          </ul>
          <!-- END Header Navigation -->

          <!-- Toggle Sidebar -->
          <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
          <button
            type="button"
            class="btn btn-circle btn-dual-secondary d-lg-none"
            data-toggle="layout"
            data-action="sidebar_toggle"
          >
            <i class="fa fa-navicon"></i>
          </button>
          <!-- END Toggle Sidebar -->
        </div>
        <!-- END Right Section -->
      </div>
      <!-- END Header Content -->

      <!-- Header Loader -->
      <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
          <div class="content-header-item">
            <i class="fa fa-sun-o fa-spin text-white"></i>
          </div>
        </div>
      </div>
      <!-- END Header Loader -->
    </header>
  </div>
</template>
