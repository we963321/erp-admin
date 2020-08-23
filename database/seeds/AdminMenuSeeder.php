<?php

use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
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

        \App\Models\Admin\Permission::truncate();
        \DB::select(
            <<<SQL
                INSERT INTO `admin_permissions` (`id`, `name`, `label`, `description`, `cid`, `icon`, `created_at`, `updated_at`)
VALUES
    (1, 'permission', '帳號管理', '', 0, 'fa-users', "$date_created", "$date_updated"),
    (2, 'permission.index', '權限列表', '', 1, '', "$date_created", "$date_updated"),
    (3, 'permission.create', '權限新增', '', 1, '', "$date_created", "$date_updated"),
    (4, 'permission.edit', '權限修改', '', 1, '', "$date_created", "$date_updated"),
    (5, 'permission.destroy', '權限刪除', '', 1, '', "$date_created", "$date_updated"),
    (6, 'role.index', '角色列表', '', 1, '', "$date_created", "$date_updated"),
    (7, 'role.create', '角色新增', '', 1, '', "$date_created", "$date_updated"),
    (8, 'role.edit', '角色修改', '', 1, '', "$date_created", "$date_updated"),
    (9, 'role.destroy', '角色刪除', '', 1, '', "$date_created", "$date_updated"),
    (10, 'user.index', '員工列表', '', 1, '', "$date_created", "$date_updated"),
    (11, 'user.create', '員工新增', '', 1, '', "$date_created", "$date_updated"),
    (12, 'user.edit', '員工編輯', '', 1, '', "$date_created", "$date_updated"),
    (13, 'user.destroy', '員工刪除', '', 1, '', "$date_created", "$date_updated"),

    (14, 'store', '店別管理', '', 0, 'fa-th', "$date_created", "$date_updated"),
    (15, 'store.index', '店別列表', '', 14, '', "$date_created", "$date_updated"),
    (16, 'store.create', '店別新增', '', 14, '', "$date_created", "$date_updated"),
    (17, 'store.edit', '店別修改', '', 14, '', "$date_created", "$date_updated"),
    (18, 'store.destroy', '店別刪除', '', 14, '', "$date_created", "$date_updated"),

    (19, 'customer', '客戶管理', '', 0, 'fa-slideshare', "$date_created", "$date_updated"),
    (20, 'customer.index', '客戶列表', '', 19, '', "$date_created", "$date_updated"),
    (21, 'customer.create', '客戶新增', '', 19, '', "$date_created", "$date_updated"),
    (22, 'customer.edit', '客戶修改', '', 19, '', "$date_created", "$date_updated"),
    (23, 'customer.destroy', '客戶刪除', '', 19, '', "$date_created", "$date_updated"),

    (20, 'customer-cars.index', '客戶車輛資料', '', 19, '', "$date_created", "$date_updated"),
    (21, 'customer-cars.create', '客戶車輛資料新增', '', 19, '', "$date_created", "$date_updated"),
    (22, 'customer-cars.edit', '客戶車輛資料修改', '', 19, '', "$date_created", "$date_updated"),
    (23, 'customer-cars.destroy', '客戶車輛資料刪除', '', 19, '', "$date_created", "$date_updated"),

    (100, 'system', '系統設定', '', 0, 'fa-gear', "$date_created", "$date_updated"),
    
    (101, 'counties.index', '縣市列表', '', 100, '', "$date_created", "$date_updated"),
    (102, 'counties.create', '縣市新增', '', 100, '', "$date_created", "$date_updated"),
    (103, 'counties.edit', '縣市修改', '', 100, '', "$date_created", "$date_updated"),
    (104, 'counties.destroy', '縣市刪除', '', 100, '', "$date_created", "$date_updated"),

    (105, 'town.index', '鄉鎮區列表', '', 100, '', "$date_created", "$date_updated"),
    (106, 'town.create', '鄉鎮區新增', '', 100, '', "$date_created", "$date_updated"),
    (107, 'town.edit', '鄉鎮區修改', '', 100, '', "$date_created", "$date_updated"),
    (108, 'town.destroy', '鄉鎮區刪除', '', 100, '', "$date_created", "$date_updated"),

    (109, 'community.index', '居住社區列表', '', 100, '', "$date_created", "$date_updated"),
    (110, 'community.create', '居住社區新增', '', 100, '', "$date_created", "$date_updated"),
    (111, 'community.edit', '居住社區修改', '', 100, '', "$date_created", "$date_updated"),
    (112, 'community.destroy', '居住社區刪除', '', 100, '', "$date_created", "$date_updated"),

    (113, 'customer-category.index', '會員種類列表', '', 100, '', "$date_created", "$date_updated"),
    (114, 'customer-category.create', '會員種類新增', '', 100, '', "$date_created", "$date_updated"),
    (115, 'customer-category.edit', '會員種類修改', '', 100, '', "$date_created", "$date_updated"),
    (116, 'customer-category.destroy', '會員種類刪除', '', 100, '', "$date_created", "$date_updated"),

    (117, 'customer-service.index', '專屬服務列表', '', 100, '', "$date_created", "$date_updated"),
    (118, 'customer-service.create', '專屬服務新增', '', 100, '', "$date_created", "$date_updated"),
    (119, 'customer-service.edit', '專屬服務修改', '', 100, '', "$date_created", "$date_updated"),
    (120, 'customer-service.destroy', '專屬服務刪除', '', 100, '', "$date_created", "$date_updated"),

    (121, 'customer-project.index', '專案資料列表', '', 100, '', "$date_created", "$date_updated"),
    (122, 'customer-project.create', '專案資料新增', '', 100, '', "$date_created", "$date_updated"),
    (123, 'customer-project.edit', '專案資料修改', '', 100, '', "$date_created", "$date_updated"),
    (124, 'customer-project.destroy', '專案資料刪除', '', 100, '', "$date_created", "$date_updated"),

    (125, 'product-category.index', '產品類別列表', '', 100, '', "$date_created", "$date_updated"),
    (126, 'product-category.create', '產品類別新增', '', 100, '', "$date_created", "$date_updated"),
    (127, 'product-category.edit', '產品類別修改', '', 100, '', "$date_created", "$date_updated"),
    (128, 'product-category.destroy', '產品類別刪除', '', 100, '', "$date_created", "$date_updated"),

    (129, 'product.index', '產品資料列表', '', 100, '', "$date_created", "$date_updated"),
    (130, 'product.create', '產品資料新增', '', 100, '', "$date_created", "$date_updated"),
    (131, 'product.edit', '產品資料修改', '', 100, '', "$date_created", "$date_updated"),
    (132, 'product.destroy', '產品資料刪除', '', 100, '', "$date_created", "$date_updated"),

    (133, 'industry.index', '行業別列表', '', 100, '', "$date_created", "$date_updated"),
    (134, 'industry.create', '行業別新增', '', 100, '', "$date_created", "$date_updated"),
    (135, 'industry.edit', '行業別修改', '', 100, '', "$date_created", "$date_updated"),
    (136, 'industry.destroy', '行業別刪除', '', 100, '', "$date_created", "$date_updated"),

    (137, 'entertainment.index', '休閒娛樂列表', '', 100, '', "$date_created", "$date_updated"),
    (138, 'entertainment.create', '休閒娛樂新增', '', 100, '', "$date_created", "$date_updated"),
    (139, 'entertainment.edit', '休閒娛樂修改', '', 100, '', "$date_created", "$date_updated"),
    (140, 'entertainment.destroy', '休閒娛樂刪除', '', 100, '', "$date_created", "$date_updated"),

    (141, 'tour.index', '旅行模式列表', '', 100, '', "$date_created", "$date_updated"),
    (142, 'tour.create', '旅行模式新增', '', 100, '', "$date_created", "$date_updated"),
    (143, 'tour.edit', '旅行模式修改', '', 100, '', "$date_created", "$date_updated"),
    (144, 'tour.destroy', '旅行模式刪除', '', 100, '', "$date_created", "$date_updated"),

    (145, 'hobby.index', '收藏嗜好列表', '', 100, '', "$date_created", "$date_updated"),
    (146, 'hobby.create', '收藏嗜好新增', '', 100, '', "$date_created", "$date_updated"),
    (147, 'hobby.edit', '收藏嗜好修改', '', 100, '', "$date_created", "$date_updated"),
    (148, 'hobby.destroy', '收藏嗜好刪除', '', 100, '', "$date_created", "$date_updated"),

    (149, 'vehicle-brand.index', '車輛品牌列表', '', 100, '', "$date_created", "$date_updated"),
    (150, 'vehicle-brand.create', '車輛品牌新增', '', 100, '', "$date_created", "$date_updated"),
    (151, 'vehicle-brand.edit', '車輛品牌修改', '', 100, '', "$date_created", "$date_updated"),
    (152, 'vehicle-brand.destroy', '車輛品牌刪除', '', 100, '', "$date_created", "$date_updated"),

    (153, 'brand-series.index', '品牌車系列表', '', 100, '', "$date_created", "$date_updated"),
    (154, 'brand-series.create', '品牌車系新增', '', 100, '', "$date_created", "$date_updated"),
    (155, 'brand-series.edit', '品牌車系修改', '', 100, '', "$date_created", "$date_updated"),
    (156, 'brand-series.destroy', '品牌車系刪除', '', 100, '', "$date_created", "$date_updated"),

    (157, 'vehicle-color.index', '車輛顏色列表', '', 100, '', "$date_created", "$date_updated"),
    (158, 'vehicle-color.create', '車輛顏色新增', '', 100, '', "$date_created", "$date_updated"),
    (159, 'vehicle-color.edit', '車輛顏色修改', '', 100, '', "$date_created", "$date_updated"),
    (160, 'vehicle-color.destroy', '車輛顏色刪除', '', 100, '', "$date_created", "$date_updated");
SQL
        );
    }
}
