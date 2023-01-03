<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <?= $isEdit ? 'Edit User' : ($isDetail ? 'Detail User' : 'Create User') ?>
                </h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="w-100">
                <h3 class="card-title">
                    <?= $isDetail ? 'User Detail' : 'Form' ?>
                </h3>
            </div>
            <div class="d-flex justify-content-end align-items-center w-100">
                <a href="<?= base_url('master/users') ?>" class="btn btn-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Flash Message -->
            <?= view_cell('\App\Libraries\Widget::flashMessage') ?>

            <form
                action="<?= $isEdit ? base_url('master/users/' . $user->id . '/update') : base_url('master/users/store') ?>"
                method="post">
                <?= csrf_field() ?>

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name"
                        value="<?= old('name') ? old('name') : (isset($user) ? $user->name : null) ?>" <?= $isDetail ? 'disabled' : '' ?>>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email"
                        value="<?= old('email') ? old('email') : (isset($user) ? $user->email : null) ?>" <?= $isDetail ? 'disabled' : '' ?>>
                </div>

                <!-- Password -->
                <?php if (!$isDetail && !$isEdit): ?>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Enter password" <?= $isDetail ? 'disabled' : '' ?>>
                    </div>
                    <?php endif ?>

                <!-- Role -->
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" <?= $isDetail ? 'disabled' : '' ?>>
                        <?php foreach ($roleList as $role): ?>
                            <option value="<?= $role ?>" <?=(old('role') ? old('role') : (isset($user) ? $user->role : null)) === $role ? 'selected' : '' ?>>
                                <?= $role ?>
                            </option>
                            <?php endforeach ?>
                    </select>
                </div>

                <div class="<?= $isDetail ? 'd-none' : 'd-flex' ?> justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <?= $isEdit ? 'Edit' : 'Submit' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>