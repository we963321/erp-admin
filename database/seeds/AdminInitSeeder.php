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

    (19, 'admin.customer', '客戶管理', '', 0, 'fa-slideshare', "$date_created", "$date_updated"),
    (20, 'admin.customer.index', '客戶列表', '', 19, '', "$date_created", "$date_updated"),
    (21, 'admin.customer.create', '客戶新增', '', 19, '', "$date_created", "$date_updated"),
    (22, 'admin.customer.edit', '客戶修改', '', 19, '', "$date_created", "$date_updated"),
    (23, 'admin.customer.destroy', '客戶刪除', '', 19, '', "$date_created", "$date_updated"),

    (100, 'admin.system', '系統設定', '', 0, 'fa-gear', "$date_created", "$date_updated"),
    
    (101, 'admin.counties.index', '縣市列表', '', 100, '', "$date_created", "$date_updated"),
    (102, 'admin.counties.create', '縣市新增', '', 100, '', "$date_created", "$date_updated"),
    (103, 'admin.counties.edit', '縣市修改', '', 100, '', "$date_created", "$date_updated"),
    (104, 'admin.counties.destroy', '縣市刪除', '', 100, '', "$date_created", "$date_updated"),

    (105, 'admin.town.index', '鄉鎮區列表', '', 100, '', "$date_created", "$date_updated"),
    (106, 'admin.town.create', '鄉鎮區新增', '', 100, '', "$date_created", "$date_updated"),
    (107, 'admin.town.edit', '鄉鎮區修改', '', 100, '', "$date_created", "$date_updated"),
    (108, 'admin.town.destroy', '鄉鎮區刪除', '', 100, '', "$date_created", "$date_updated"),

    (109, 'admin.community.index', '居住社區列表', '', 100, '', "$date_created", "$date_updated"),
    (110, 'admin.community.create', '居住社區新增', '', 100, '', "$date_created", "$date_updated"),
    (111, 'admin.community.edit', '居住社區修改', '', 100, '', "$date_created", "$date_updated"),
    (112, 'admin.community.destroy', '居住社區刪除', '', 100, '', "$date_created", "$date_updated"),

    (113, 'admin.customer-category.index', '會員種類列表', '', 100, '', "$date_created", "$date_updated"),
    (114, 'admin.customer-category.create', '會員種類新增', '', 100, '', "$date_created", "$date_updated"),
    (115, 'admin.customer-category.edit', '會員種類修改', '', 100, '', "$date_created", "$date_updated"),
    (116, 'admin.customer-category.destroy', '會員種類刪除', '', 100, '', "$date_created", "$date_updated"),

    (117, 'admin.customer-service.index', '專屬服務列表', '', 100, '', "$date_created", "$date_updated"),
    (118, 'admin.customer-service.create', '專屬服務新增', '', 100, '', "$date_created", "$date_updated"),
    (119, 'admin.customer-service.edit', '專屬服務修改', '', 100, '', "$date_created", "$date_updated"),
    (120, 'admin.customer-service.destroy', '專屬服務刪除', '', 100, '', "$date_created", "$date_updated"),

    (121, 'admin.customer-project.index', '專案資料列表', '', 100, '', "$date_created", "$date_updated"),
    (122, 'admin.customer-project.create', '專案資料新增', '', 100, '', "$date_created", "$date_updated"),
    (123, 'admin.customer-project.edit', '專案資料修改', '', 100, '', "$date_created", "$date_updated"),
    (124, 'admin.customer-project.destroy', '專案資料刪除', '', 100, '', "$date_created", "$date_updated"),

    (125, 'admin.product-category.index', '產品類別列表', '', 100, '', "$date_created", "$date_updated"),
    (126, 'admin.product-category.create', '產品類別新增', '', 100, '', "$date_created", "$date_updated"),
    (127, 'admin.product-category.edit', '產品類別修改', '', 100, '', "$date_created", "$date_updated"),
    (128, 'admin.product-category.destroy', '產品類別刪除', '', 100, '', "$date_created", "$date_updated"),

    (129, 'admin.product.index', '產品資料列表', '', 100, '', "$date_created", "$date_updated"),
    (130, 'admin.product.create', '產品資料新增', '', 100, '', "$date_created", "$date_updated"),
    (131, 'admin.product.edit', '產品資料修改', '', 100, '', "$date_created", "$date_updated"),
    (132, 'admin.product.destroy', '產品資料刪除', '', 100, '', "$date_created", "$date_updated"),

    (133, 'admin.industry.index', '行業別列表', '', 100, '', "$date_created", "$date_updated"),
    (134, 'admin.industry.create', '行業別新增', '', 100, '', "$date_created", "$date_updated"),
    (135, 'admin.industry.edit', '行業別修改', '', 100, '', "$date_created", "$date_updated"),
    (136, 'admin.industry.destroy', '行業別刪除', '', 100, '', "$date_created", "$date_updated"),

    (137, 'admin.entertainment.index', '休閒娛樂列表', '', 100, '', "$date_created", "$date_updated"),
    (138, 'admin.entertainment.create', '休閒娛樂新增', '', 100, '', "$date_created", "$date_updated"),
    (139, 'admin.entertainment.edit', '休閒娛樂修改', '', 100, '', "$date_created", "$date_updated"),
    (140, 'admin.entertainment.destroy', '休閒娛樂刪除', '', 100, '', "$date_created", "$date_updated"),

    (141, 'admin.tour.index', '旅行模式列表', '', 100, '', "$date_created", "$date_updated"),
    (142, 'admin.tour.create', '旅行模式新增', '', 100, '', "$date_created", "$date_updated"),
    (143, 'admin.tour.edit', '旅行模式修改', '', 100, '', "$date_created", "$date_updated"),
    (144, 'admin.tour.destroy', '旅行模式刪除', '', 100, '', "$date_created", "$date_updated"),

    (145, 'admin.hobby.index', '收藏嗜好列表', '', 100, '', "$date_created", "$date_updated"),
    (146, 'admin.hobby.create', '收藏嗜好新增', '', 100, '', "$date_created", "$date_updated"),
    (147, 'admin.hobby.edit', '收藏嗜好修改', '', 100, '', "$date_created", "$date_updated"),
    (148, 'admin.hobby.destroy', '收藏嗜好刪除', '', 100, '', "$date_created", "$date_updated"),

    (149, 'admin.vehicle-brand.index', '車輛品牌列表', '', 100, '', "$date_created", "$date_updated"),
    (150, 'admin.vehicle-brand.create', '車輛品牌新增', '', 100, '', "$date_created", "$date_updated"),
    (151, 'admin.vehicle-brand.edit', '車輛品牌修改', '', 100, '', "$date_created", "$date_updated"),
    (152, 'admin.vehicle-brand.destroy', '車輛品牌刪除', '', 100, '', "$date_created", "$date_updated"),

    (153, 'admin.brand-series.index', '品牌車系列表', '', 100, '', "$date_created", "$date_updated"),
    (154, 'admin.brand-series.create', '品牌車系新增', '', 100, '', "$date_created", "$date_updated"),
    (155, 'admin.brand-series.edit', '品牌車系修改', '', 100, '', "$date_created", "$date_updated"),
    (156, 'admin.brand-series.destroy', '品牌車系刪除', '', 100, '', "$date_created", "$date_updated"),

    (157, 'admin.vehicle-color.index', '車輛顏色列表', '', 100, '', "$date_created", "$date_updated"),
    (158, 'admin.vehicle-color.create', '車輛顏色新增', '', 100, '', "$date_created", "$date_updated"),
    (159, 'admin.vehicle-color.edit', '車輛顏色修改', '', 100, '', "$date_created", "$date_updated"),
    (160, 'admin.vehicle-color.destroy', '車輛顏色刪除', '', 100, '', "$date_created", "$date_updated");
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
