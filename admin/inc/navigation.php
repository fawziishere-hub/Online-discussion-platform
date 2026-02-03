<style>
  .main-sidebar {
    background-color: #222831;
    /* Set a dark background color */
    width: 250px;
    /* Adjust the width as needed */
  }

  .main-sidebar .brand-link {
    border-bottom: 1px solid #343a40;
    /* Add a subtle bottom border to the brand link */
    padding: 1rem;
    /* Add some padding to the brand link */
  }

  .main-sidebar .brand-link .brand-image {
    filter: brightness(1.2);
    /* Make the logo slightly brighter */
  }

  .main-sidebar .nav-item .nav-link {
    color: #dee2e6;
    /* Set a light color for the menu items */
    border-radius: 0.25rem;
    /* Add a slight border-radius to the menu items */
    transition: all 0.2s ease-in-out;
    /* Add a smooth transition effect */
  }

  .main-sidebar .nav-item .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    /* Add a subtle background on hover */
  }

  .main-sidebar .nav-item .nav-link .nav-icon {
    color: #adb5bd;
    /* Set a slightly lighter color for the icons */
    margin-right: 0.5rem;
    /* Add some space between the icon and text */
  }

  .main-sidebar .nav-header {
    color: #ced4da;
    /* Set a lighter color for the section headers */
    font-size: 0.875rem;
    /* Slightly reduce the font size of the section headers */
    margin-top: 1rem;
    /* Add some space above the section headers */
    text-transform: uppercase;
    /* Make the section headers uppercase */
  }
</style>












<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand">
  <!-- Brand Logo -->
  <a href="<?php echo base_url ?>admin" class="brand-link bg-gradient text-sm">
    <!-- <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="ODP Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8;width: 1.5rem;height: 1.5rem;max-height: unset"> -->
    <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
  </a>
  <!-- Sidebar -->
  <div
    class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
    <div class="os-resize-observer-host observed">
      <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
    </div>
    <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
      <div class="os-resize-observer"></div>
    </div>
    <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
    <div class="os-padding">
      <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
        <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
          <!-- Sidebar user panel (optional) -->
          <div class="clearfix"></div>
          <!-- Sidebar Menu -->
          <nav class="mt-4">
            <ul
              class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child"
              data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item dropdown">
                <a href="./" class="nav-link nav-home">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="./?page=posts" class="nav-link nav-posts">
                  <i class="nav-icon fas fa-blog"></i>
                  <p>
                    Posts
                  </p>
                </a>
              </li>
              <?php if ($_settings->userdata('type') == 1): ?>
                <li class="nav-header">Maintenance</li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=categories" class="nav-link nav-categories">
                    <i class="nav-icon fas fa-th-list"></i>
                    <p>
                      Category List
                    </p>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user/list">
                    <i class="nav-icon fas fa-users-cog"></i>
                    <p>
                      User List
                    </p>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                    <i class="nav-icon fas fa-tools"></i>
                    <p>
                      Settings
                    </p>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar-corner"></div>
  </div>
  <!-- /.sidebar -->
</aside>
<script>
  $(document).ready(function () {
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
    page = page.replace(/\//g, '_');
    console.log(page)

    if ($('.nav-link.nav-' + page).length > 0) {
      $('.nav-link.nav-' + page).addClass('active')
      if ($('.nav-link.nav-' + page).hasClass('tree-item') == true) {
        $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active')
        $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open')
      }
      if ($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true) {
        $('.nav-link.nav-' + page).parent().addClass('menu-open')
      }

    }
    $('.nav-link.active').addClass('bg-gradient-gray')
  })
</script>