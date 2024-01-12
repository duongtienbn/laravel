Laravel 9
Requirements Environment
PHP version : 8.1 - 8.2
Composer latest version
MySQL : 5.7.x 注意 8.xは他のツールが対応していない可能性がある。

✅MySQL
mysql -uroot -p
:password
$ mysql -V
　5.7.39
🔥local PCからAWSのinstance上にあるMySQLに接続できない。
　RDSを作成する必要がある

Lusty server
ssh bitnami@lusty.asia

Laravel Official Site
https://laravel.com/

✅git pullしたら、ディレクトリに入って、
$ composer install

✅Databaseに接続
.envがgithubには置けないので、コピー
	APP_URL=htttp://localhost:8000
	DB_CONNECTION=mysqlとか、pgsql
	DB_PASSWORD=gomi3939
$ php artisan config:cache
$ php artisan migrate

🔥[01_first_app]
$ composer create-project laravel/laravel 01_first_app
✅version 9：新規にプロジェクトを作成する時にはLinkStaffでも使っている9を使ってください。
　$ composer create-project "laravel/laravel=9.*" laravel-9
$ php artisan serve

CRUD
https://www.youtube.com/watch?v=_SSGvxiSFzM&t=825s
https://www.tutussfunny.com/laravel-10-crud-application-tutorial/

・テーブルを作成
$ php artisan make:migration create_student_table
　※database/migrationに...create_student_table.phpが作成されます

・name, address, mobileフィールドを追加
$ php artisan migrate

・コントローラーを作成
$ php artisan make:Controller StudentController --resource
  ※ /app/Http/Controllers/StudentController.phpが作成されます

・モデルを作成
$ php artisan make:model Student
  /app/Models/Student.phpが作成されます

・モデルを編集
　protected $table = 'students';
  protected $primaryKey = 'id';
  protected $fillable = ['name', 'address', 'mobile'];
  use HasFactory;
・コントローラーのindex()を編集
  use App\Models\Student;
　$students = Student::all();
  return view ('students.index')->with('students', $students);
・resources/viewsフォルダーに、studensフォルダーを作成
・studentsフォルダーの下に
  layout.blade.php
　index.blade.php
  show.blade.php
	create.blade.php
	edit.blade.php

・ルーティング routes/web.php
  use App\Http\Controllers\StudentController;
　Route::resource("/student", StudentController::class);
🎉完成

🔥[02_import_excel]

https://www.its-corp.co.jp/laravel9-excel-import-export/


excelインポート
https://www.its-corp.co.jp/laravel9-excel-import-export/

新規プロジェクト作成
composer create-project "laravel/laravel=9.*" 02_import_excel

ライブラリインストール
composer require maatwebsite/excel

漢字のヘッダーを使う場合 app/config/excel.php
        'heading_row' => [
            'formatter' => 'slug',  ✅
        ],
        
.envを編集
mysqlのパスワードを登録


🔥[03_import_csv]
https://laraveltuts.com/laravel-9-import-export-excel-csv-file-to-database-example/
https://www.youtube.com/watch?v=pbxz7B_Yubo

・プロジェクトを作成
　composer create-project "laravel/laravel=9.*" 03_import_export_excel_csv
・.envのdatabase passwordを登録
・ライブラリをインストール
　composer require psr/simple-cache:^1.0 maatwebsite/excel
　php artisan migrate
・Step 4:ダミーレコードを作成
　php artisan tinker
　>> User::factory()->count(10)->create()
　...
　>>exit
・Step 5: インポートクラスを作成
　php artisan make:import UsersImport --model=User
　app/Imports/UsersImport.phpを編集
・empty.csvファイルを作成
name,email,password
tom,tom.zed39@gmail.com,gomi3939
・exportクラスを作成、編集
　php artisan make:export UsersExport --model=User
・コントローラーを作成、編集
　php artisan make:controller UserController
・Step 8:ルーティング
・Step 9:ビューを作成
　users.blade.php
・Step 10:テスト
　php artisan serve
　http://localhost:8000/users

　
🔥[04_dropdown]
01_first_appをコピーして作成

✅マイグレーション作成
php artisan make:migration create_work_areas_table --create=work_areas

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkAreasTable extends Migration
{
    public function up()
    {
        Schema::create('work_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_areas');
    }
}

✅マイグレートを実行
php artisan config:cache
php artisan migrate


✅モデルを作成
php artisan make:model WorkArea

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}

✅コントローラー作成
php artisan make:controller WorkAreaController --resource

use App\Models\WorkArea;
use Illuminate\Http\Request;

class WorkAreaController extends Controller
{
    public function index()
    {
        $workAreas = WorkArea::all();

        return view('work_areas.index', compact('workAreas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:work_areas',
        ]);

        WorkArea::create([
            'name' => $request->name,
        ]);

        return redirect()->route('work-areas.index');
    }

    public function destroy(WorkArea $workArea)
    {
        $workArea->delete();

        return redirect()->route('work-areas.index');
    }
}

✅ビューを作成
<!-- ドロップダウンリスト -->
<select>
    @foreach ($workAreas as $workArea)
        <option value="{{ $workArea->name }}">{{ $workArea->name }}</option>
    @endforeach
</select>

<!-- 登録フォーム -->
<form method="POST" action="{{ route('work-areas.store') }}">
    @csrf
    <input type="text" name="name" required>
    <button type="submit">登録

<form action="{{ route('work_area.store') }}" method="POST">
  @csrf
  <select name="work_area" id="work_area">
    <option value="">選択してください</option>
    @foreach ($workAreas as $workArea)
      <option value="{{ $workArea['name'] }}">{{ $workArea['name'] }}</option>
    @endforeach
  </select>
  <input type="text" name="other_work_area" id="other_work_area" style="display:none;">
  <button type="submit">送信</button>
</form>



✅ルーティング作成
Route::resource("/work_area", WorkAreaController::class);


🔥[05_auto_complete]
https://www.positronx.io/create-autocomplete-search-in-laravel-with-typeahead-js/

W3SCHOOL without jQuery
https://www.w3schools.com/php/php_ajax_livesearch.asp


======= faker tinker factoryの使い方 ======
Factoryを作成する
php artisan make:factory WorkArea

TinkerとFakerの使い方
https://tektektech.com/laravel-use-faker-with-tinker/

FactoryとFaker
https://morioh.com/p/26acdaee8db5
php artisan make:factory WorkArea

✅ composer dump-autoload

日本語でfakerを使いたい
https://don-bu-rakko.com/laravel-faker-%E3%81%A7-%E6%97%A5%E6%9C%AC%E8%AA%9E%E3%81%AE%E6%96%87%E7%AB%A0%E3%82%92%E5%85%A5%E5%8A%9B%E3%81%97%E3%81%A6%E3%82%82%E3%82%89%E3%81%84%E3%81%9F%E3%81%84/
config/app.phpのfaker_localeを'ja_JP'に変更すれば良い






🔥[06_work_area_crud_Tom]
mkdir 06_work_area_crud_Tom
cd 06_work_area_crud_Tom
composer create-project laravel/laravel example
php artisan make:migration create_work_area_table
migrationにnameフィールドを追加
.envにmysqlのパスワードを登録
php artisan migrate
php artisan make:Controller WorkAreaController --resource
php artisan make:model WorkArea
　modelを編集、fillableを追加
resources/views/work_areasフォルダを作成
index.blade.phpを作成
layout.blade.phpを作成
ルーティング
use App\Http\Controllers\WorkAreaController;
Route::resource("/work_area", WorkAreaController::class);

localhost:8000/work_area



🔥[08_multi_role_login_Tom]
新規プロジェクトを作成
composer create-project laravel/laravel 08_multi_role_login_Tom
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev
エラー
Vite manifest not found at:
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

解決：npm run build ← public フォルダを生成
"laravel manifest build"で検索
https://laracasts.com/discuss/channels/laravel/laravel-9-vite-manifest-not-found-at-publicbuildmanifestjson?page=1&replyId=869357



npm install sass-loader@^12.1.0 resolve-url-loader@^5.0.0 --save-dev --legacy-peer-deps
npm install --save-dev vite laravel-vite-plugin



php artisan view:clear


🔥[14_file_upload_Tom]
応募者の履歴書、面接記録などをアップロードする
https://www.itsolutionstuff.com/post/laravel-9-file-upload-tutorial-exampleexample.html

./upload

ファイル一覧を表示




.envのデータベースにパスワードを登録
DB_PASSWORD=

実行
php artisan serve
http://localhost:8000

テーブル更新
database/migrationsのUserテーブル

マイグレーション
php artisan migrate:refresh

AppServiceProviderにSchema?
1:58

カスタムアトリビュート
2:41
use Illuminate\Database\Eloquent\Casts\Attribute;

package.jsonを変更
"scripts": {
     "dev": "npm run development",
     "development": "mix"
},


composer require laravel/ui
php artisan ui bootstrap --auth 

❌npm install laravel-mix@latest --save-dev

npm install
npm run dev

❌webpack.mix.jsを作成しないとエラーが出た
https://reffect.co.jp/laravel/first-laravel-mix
⭕️mixは使わないで、viteに戻した


Step.4
Create Middleware
php artisan make:middleware UserRoleMiddleware

Step.5
Register middleware


$roleをパラメータに追加

シード
php artisan make:seeder CreateUserSeeder
php artisan db:seed --class=CreateUserSeeder















