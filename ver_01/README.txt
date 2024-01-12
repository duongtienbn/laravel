<!-- プロジェクトを作成 -->

composer create-project laravel/laravel 11_crud_new_Hung
-migration students を作成
-migration skills を作成
-migration countries を作成
-migration staffs を作成
-migration departments を作成
-migration apply_depadepartments を作成
-migration working_places を作成
-model Stutent を作成
-model Apply を作成
-model Country を作成
-model Department を作成
-model Place を作成
-model Skill を作成
-model Staff を作成
-controller StudentControllerを作成
-controller ApplyControllerを作成
-controller CountryControllerを作成
-controller DepartmentControllerを作成
-controller PlaceControllerを作成
-controller SkillControllerを作成
-controller StaffControllerを作成
-seeder StudentSeeder を作成
-seeder CountrySeeder を作成
-seeder ApplySeeder を作成
-seeder DepartmentSeeder を作成
-seeder PlaceSeeder を作成
-seeder SkillSeeder を作成
-seeder StaffSeeder を作成

<!-- Migrationを作成  -->

php artisan make:migration students
php artisan make:migration skills
php artisan make:migration countries
php artisan make:migration staffs
php artisan make:migration departments
php artisan make:migration apply_depadepartments
php artisan make:migration working_places

<!-- Modelを作成  -->

php artisan make:model Stutent
php artisan make:model Apply
php artisan make:model Country
php artisan make:model Department
php artisan make:model Place
php artisan make:model Skill
php artisan make:model Staff

<!-- Controllerを作成  -->

php artisan make:controller StudentController
php artisan make:controller ApplyController
php artisan make:controller CountryController
php artisan make:controller DepartmentController
php artisan make:controller PlaceController
php artisan make:controller SkillController
php artisan make:controller StaffController

<!-- Seederを作成  -->

php artisan make:seeder StudentSeeder
php artisan make:seeder CountrySeeder
php artisan make:seeder ApplySeeder
php artisan make:seeder DepartmentSeeder
php artisan make:seeder PlaceSeeder
php artisan make:seeder SkillSeeder
php artisan make:seeder StaffSeeder

<!-- Seederを実行  -->

php artisan db:seed --class=StudentSeeder
php artisan db:seed --class=CountrySeeder
php artisan db:seed --class=ApplySeeder
php artisan db:seed --class=DepartmentSeeder
php artisan db:seed --class=PlaceSeeder
php artisan db:seed --class=SkillSeeder
php artisan db:seed --class=StaffSeeder
php artisan db:seed --class=CreateUserSeeder

<!-- student viewを作成  -->

layout.blade.php				//layout
students-index.blade.php　　　　　//index画面
students-create.blade.php
students-show.blade.php
students-edit.blade.php

=========================================================================================================
=============================================validation==================================================
=========================================================================================================

<!-- scriptsを作成 -->

apply_department-scripts.blade.php
country-scripts.blade.php
department-scripts.blade.php
skill-scripts.blade.php
staff-scripts.blade.php
working_place-scripts.blade.php
session.blade.php
validate-form.blade.php

<!-- URL -->

http://127.0.0.1:8000/student



