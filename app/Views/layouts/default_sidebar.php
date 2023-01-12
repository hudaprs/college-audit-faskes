<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="<?= base_url('dist/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="<?= base_url('') ?>" class="d-block">
                <?= session()->get('name') ?>
            </a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="<?= base_url('') ?>" class="nav-link">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>

            <?php if (App\Helpers\RoleHelper::isAdmin()): ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('master/users') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/facilitie') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Facilitie</p>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif ?>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-building"></i>
                    <p>
                        Facility Management
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= base_url('facility-management/health-facility') ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Health Facility</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= base_url('facility-management/mapping-facility') ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Mapping Facility</p>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>

    </nav>
</div>
<!-- /.sidebar-menu -->