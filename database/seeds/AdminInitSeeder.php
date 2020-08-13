<?php

use Illuminate\Database\Seeder;

class AdminInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date_created = date('Y-m-d H:i:s');
        $date_updated = date('Y-m-d H:i:s');

        \App\Models\Admin\AdminUser::truncate();
        \App\Models\Admin\Permission::truncate();
        \DB::select(
            <<<SQL
                INSERT INTO `admin_permissions` (`id`, `name`, `label`, `description`, `cid`, `icon`, `created_at`, `updated_at`)
VALUES
    (1, 'admin.permission', '帳號管理', '', 0, 'fa-users', "$date_created", "$date_updated"),
    (2, 'admin.permission.index', '權限列表', '', 1, '', "$date_created", "$date_updated"),
    (3, 'admin.permission.create', '權限新增', '', 1, '', "$date_created", "$date_updated"),
    (4, 'admin.permission.edit', '權限修改', '', 1, '', "$date_created", "$date_updated"),
    (5, 'admin.permission.destroy', '權限刪除', '', 1, '', "$date_created", "$date_updated"),
    (6, 'admin.role.index', '角色列表', '', 1, '', "$date_created", "$date_updated"),
    (7, 'admin.role.create', '角色新增', '', 1, '', "$date_created", "$date_updated"),
    (8, 'admin.role.edit', '角色修改', '', 1, '', "$date_created", "$date_updated"),
    (9, 'admin.role.destroy', '角色刪除', '', 1, '', "$date_created", "$date_updated"),
    (10, 'admin.user.index', '員工列表', '', 1, '', "$date_created", "$date_updated"),
    (11, 'admin.user.create', '員工新增', '', 1, '', "$date_created", "$date_updated"),
    (12, 'admin.user.edit', '員工編輯', '', 1, '', "$date_created", "$date_updated"),
    (13, 'admin.user.destroy', '員工刪除', '', 1, '', "$date_created", "$date_updated"),
    (14, 'admin.store', '分店管理', '', 0, 'fa-th', "$date_created", "$date_updated"),
    (15, 'admin.store.index', '分店列表', '', 14, '', "$date_created", "$date_updated"),
    (16, 'admin.store.create', '分店新增', '', 14, '', "$date_created", "$date_updated"),
    (17, 'admin.store.edit', '分店修改', '', 14, '', "$date_created", "$date_updated"),
    (18, 'admin.store.destroy', '分店刪除', '', 14, '', "$date_created", "$date_updated"),
    (19, 'admin.customer', '客戶管理', '', 0, 'fa-th', "$date_created", "$date_updated"),
    (20, 'admin.customer.index', '客戶列表', '', 19, '', "$date_created", "$date_updated"),
    (21, 'admin.customer.create', '客戶新增', '', 19, '', "$date_created", "$date_updated"),
    (22, 'admin.customer.edit', '客戶修改', '', 19, '', "$date_created", "$date_updated"),
    (23, 'admin.customer.destroy', '客戶刪除', '', 19, '', "$date_created", "$date_updated");
SQL
        );
        $admin = new \App\Models\Admin\AdminUser();
        $admin->id = 1;
        $admin->name = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('123456');
        $admin->emp_id = 'z20200000000001';
        $admin->mobile = '0123456789';
        $admin->id_number = 'A123456789';
        $admin->save();
    }
}
